<!-- filepath: c:\xampp\htdocs\archivai\views\reset_password.php -->
<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_GET['token'] ?? null;
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirmPassword)) {
        $error = 'Veuillez remplir tous les champs.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        $stmt = $db->prepare("SELECT id FROM utilisateurs WHERE reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE utilisateurs SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
            $stmt->execute([$hashedPassword, $user['id']]);
            $success = 'Votre mot de passe a été réinitialisé. Vous pouvez maintenant vous connecter.';
        } else {
            $error = 'Le lien de réinitialisation est invalide ou expiré.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - ArchivAI</title>
    <link rel="stylesheet" href="../assets/css/forgot-password.css">
    <link rel="icon" href="../assets/img/archivAI.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="../public/index.php" class="navbar-logo">
            <img src="../assets/img/archivAI.png" alt="ArchivAI Logo">
            <span>ArchivAI</span>
        </a>
    </nav>

    <main class="auth-container">
        <div class="auth-card">
            <img src="../assets/img/archivAI.png" alt="Logo ArchivAI" class="auth-logo">
            <h1 class="auth-title">Réinitialiser le mot de passe</h1>

            <?php if (isset($success)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
            <?php elseif (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>
                        <button type="button" class="toggle-password" id="toggle-password" aria-label="Afficher/Masquer le mot de passe">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez votre mot de passe" required>
                        <button type="button" class="toggle-password" id="toggle-confirm" aria-label="Afficher/Masquer le mot de passe">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Réinitialiser
                </button>
            </form>

            <div class="auth-links">
                <a href="login.php">Retour à la connexion</a>
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