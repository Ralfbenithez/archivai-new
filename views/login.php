<?php

ini_set('session.gc_maxlifetime', 1800); // 30 minutes
session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// Initialisation des variables
$email = '';
$remember_me = false;
$errors = [];

// Vérifier le cookie de "Se souvenir de moi"
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    require_once '../config/config.php';
    
    list($user_id, $token, $hash) = explode(':', $_COOKIE['remember_user']);
    
    // Vérifier que le cookie n'a pas été manipulé
    $check_hash = hash('sha256', $user_id . ':' . $token . ':' . SECRET_KEY);
    
    if ($hash === $check_hash) {
        // Vérifier le token en base de données
        $stmt = $db->prepare("SELECT id, nom, prenoms, email FROM utilisateurs WHERE id = ? AND remember_token = ? AND token_expires_at > NOW()");
        $stmt->execute([$user_id, $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Authentification réussie via cookie
            $_SESSION['user_id'] = $user['id'];
            session_regenerate_id(true);
            $_SESSION['user_name'] = $user['prenoms'] . ' ' . $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            
            // Renouveler le cookie si nécessaire
            renewRememberMeCookie($user['id'], $db);
            
            // Mettre à jour la dernière connexion
            $update = $db->prepare("UPDATE utilisateurs SET last_login = NOW() WHERE id = ?");
            $update->execute([$user['id']]);
            
            // Rediriger vers le tableau de bord
            header('Location: dashboard.php');
            exit;
        } else {
            // Token invalide ou expiré, supprimer le cookie
            setcookie('remember_user', '', time() - 3600, '/', '', true, true);
        }
    } else {
        // Cookie potentiellement manipulé, supprimer
        setcookie('remember_user', '', time() - 3600, '/', '', true, true);
    }
}

// Fonction pour créer/renouveler le cookie "Se souvenir de moi"
function renewRememberMeCookie($user_id, $db) {
    // Générer un nouveau token
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
    
    // Mettre à jour le token dans la base de données
    $stmt = $db->prepare("UPDATE utilisateurs SET remember_token = ?, token_expires_at = ? WHERE id = ?");
    $stmt->execute([$token, $expires, $user_id]);
    
    // Créer une valeur de hachage pour vérifier l'intégrité du cookie
    $hash = hash('sha256', $user_id . ':' . $token . ':' . SECRET_KEY);
    
    // Définir le cookie qui expire dans 30 jours
    $cookie_value = $user_id . ':' . $token . ':' . $hash;
    setcookie('remember_user', $cookie_value, [
        'expires' => time() + 30 * 24 * 60 * 60,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

// Fonction pour limiter les tentatives de connexion
function checkLoginAttempts($ip, $email, $db) {
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE (ip_address = ? OR email = ?) AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $stmt->execute([$ip, $email]);
        $count = $stmt->fetchColumn();
        return $count < 5; // Autorise jusqu'à 5 tentatives en 15 minutes
    } catch (PDOException $e) {
        error_log('Erreur lors de la vérification des tentatives de connexion : ' . $e->getMessage());
        // Fallback : autoriser l'utilisateur si une erreur survient
        return true;
    }
}

// Fonction pour enregistrer une tentative de connexion échouée
function recordFailedLogin($ip, $email, $db) {
    $stmt = $db->prepare("INSERT INTO login_attempts (ip_address, email, attempt_time) VALUES (?, ?, NOW())");
    $stmt->execute([$ip, $email]);
    error_log('Tentative échouée pour : ' . substr($email, 0, 3) . '***');
}

// Gestion de la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/config.php';
    
    // Récupérer et nettoyer les données du formulaire
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Validation de base
    if (empty($email) || empty($password)) {
        $errors['login'] = 'Veuillez remplir tous les champs.';
    } 
    // Vérifier les tentatives de connexion
    elseif (!checkLoginAttempts($ip, $email, $db)) {
        $errors['login'] = 'Trop de tentatives de connexion. Veuillez réessayer dans 15 minutes.';
    } 
    else {
        try {
            // Rechercher l'utilisateur par email
            $stmt = $db->prepare("SELECT id, nom, prenoms, email, password, account_status FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Vérifier si le compte est actif
                if ($user['account_status'] !== 'active') {
                    $errors['login'] = 'Votre compte n\'est pas actif. Veuillez vérifier votre email pour l\'activer ou contacter l\'assistance.';
                } else {
                    // Authentification réussie
                    $_SESSION['prenom'] = $user['prenoms']; // Assurez-vous que 'prenom' est une colonne dans votre table utilisateurs
                    $_SESSION['user_id'] = $user['id']; // Stockez également l'ID utilisateur pour d'autres usages
                    $_SESSION['user_name'] = $user['prenoms'] . ' ' . $user['nom'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    // Gestion du "Se souvenir de moi"
                    if ($remember_me) {
                        renewRememberMeCookie($user['id'], $db);
                    }
                    
                    // Mettre à jour la dernière connexion
                    $update = $db->prepare("UPDATE utilisateurs SET last_login = NOW() WHERE id = ?");
                    $update->execute([$user['id']]);
                    
                    // Supprimer les anciennes tentatives de connexion
                    $cleanup = $db->prepare("DELETE FROM login_attempts WHERE email = ?");
                    $cleanup->execute([$email]);
                    
                    // Rediriger vers le tableau de bord ou la page précédente
                    $allowed_redirects = ['dashboard.php', '/../public/index.php'];
                    $redirect = isset($_SESSION['return_to']) && in_array($_SESSION['return_to'], $allowed_redirects)
                        ? $_SESSION['return_to']
                        : 'dashboard.php';
                    unset($_SESSION['return_to']); // Nettoyer après utilisation
                    
                    header('Location: ' . $redirect);
                    exit;
                }
            } else {
                // Authentification échouée
                recordFailedLogin($ip, $email, $db);
                $errors['login'] = 'Identifiants incorrects ou compte inactif.';
            }
        } catch (PDOException $e) {
            // Journaliser l'erreur pour les administrateurs, mais ne pas la divulguer à l'utilisateur
            error_log('Erreur de connexion: ' . $e->getMessage());
            $errors['login'] = 'Une erreur est survenue. Veuillez réessayer ultérieurement.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ArchivAI</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="icon" href="../assets/img/archivAI.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="../assets/js/login.js" defer></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="../index.php" class="navbar-logo">
            <img src="../assets/img/archivAI.png" alt="ArchivAI Logo">
            <span>ArchivAI</span>
        </a>
    </nav>

    <main class="auth-container">
        <div class="auth-card">
            <img src="../assets/img/archivAI.png" alt="Logo ArchivAI" class="auth-logo">
            <h1 class="auth-title">Connexion à votre compte</h1>

            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Inscription réussie ! Vous pouvez maintenant vous connecter.
                </div>
            <?php elseif (isset($_GET['password_reset'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Votre mot de passe a été réinitialisé avec succès. Veuillez vous connecter avec votre nouveau mot de passe.
                </div>
            <?php elseif (isset($_GET['account_activated'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.
                </div>
            <?php elseif (isset($_GET['logout'])): ?>
                <div class="info-message">
                    <i class="fas fa-info-circle"></i> Vous avez été déconnecté avec succès.
                </div>
            <?php elseif (isset($_GET['session_expired'])): ?>
                <div class="warning-message">
                    <i class="fas fa-exclamation-triangle"></i> Votre session a expiré. Veuillez vous reconnecter.
                </div>
            <?php endif; ?>

            <?php if (!empty($errors['login'])): ?>
                <div class="error-message global-error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($errors['login']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="Entrez votre email" required 
                               value="<?= htmlspecialchars($email) ?>" autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required autocomplete="current-password">
                        <button type="button" class="toggle-password" id="toggle-password" aria-label="Afficher/Masquer le mot de passe">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <div class="checkbox-container">
                        <input type="checkbox" id="remember_me" name="remember_me" <?= $remember_me ? 'checked' : '' ?>>
                        <label for="remember_me">Se souvenir de moi</label>
                    </div>
                    <a href="forgot-password.php" class="forgot-password-link">Mot de passe oublié?</a>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
            
            <div class="auth-links">
                Pas encore de compte ? <a href="register.php">Créer un compte</a>
            </div>

            <div class="auth-divider">
                
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-copyright">
                &copy; 2025 ArchivAI. Tous droits réservés.
            </div>
        </div>
    </footer>

</body>
</html>