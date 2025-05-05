<?php
// Inclure les dépendances
require_once '../config/config.php';

// Définir la classe RegisterModel
class RegisterModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function createUser($data) {
        $stmt = $this->db->prepare("INSERT INTO utilisateurs (nom, prenoms, email, password, created_at) VALUES (?, ?, ?, ?, NOW())");
        try {
            return $stmt->execute([
                $data['nom'],
                $data['prenom'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
        } catch (PDOException $e) {
            error_log("Erreur d'inscription: " . $e->getMessage());
            return false;
        }
    }
}

// Définir la classe RegisterController
class RegisterController {
    private $model;

    public function __construct($db) {
        $this->model = new RegisterModel($db);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegistration();
        } else {
            $this->showForm();
        }
    }

    private function processRegistration() {
        $errors = [];

        if ($this->model->emailExists($_POST['email'])) {
            $errors['email'] = 'Cet email est déjà utilisé';
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format d\'email invalide';
        }

        if (!$this->validatePassword($_POST['password'])) {
            $errors['password'] = 'Le mot de passe ne respecte pas les exigences';
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errors['confirm_password'] = 'Les mots de passe ne correspondent pas';
        }

        if (empty($errors)) {
            if ($this->model->createUser($_POST)) {
                header('Location: login.php?success=1');
                exit;
            }
        }

        $this->showForm($errors);
    }

    private function validatePassword($password) {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&=#_-]).{8,}$/', $password);
    }

    private function showForm($errors = []) {
        // Afficher le formulaire avec les erreurs éventuelles
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Créer un compte - ArchivAI</title>
            <link rel="stylesheet" href="../assets/css/register.css">
            <script src="../assets/js/register.js" defer></script>
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
                    <h1 class="auth-title">Créez votre compte</h1>

                    <form method="POST" class="auth-form">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
                            </div>
                            <?php if (isset($errors['nom'])): ?>
                                <div class="error-message"><?= $errors['nom'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">
                            </div>
                            <?php if (isset($errors['prenom'])): ?>
                                <div class="error-message"><?= $errors['prenom'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" id="email" name="email" placeholder="Entrez votre email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                            </div>
                            <div id="email-feedback" class="feedback"></div>
                            <?php if (isset($errors['email'])): ?>
                                <div class="error-message"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                                <button type="button" class="toggle-password" id="toggle-password" aria-label="Afficher/Masquer le mot de passe">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($errors['password'])): ?>
                                <div class="error-message"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                            
                            <div class="password-strength">
                                <div class="strength-bar-container">
                                    <div id="strength-bar" class="strength-bar"></div>
                                </div>
                                <div class="strength-info">
                                    <span id="strength-label" class="strength-label">Faible</span>
                                </div>
                                
                                <div class="password-criteria">
                                    <ul class="criteria-list">
                                        <li id="length" class="criteria-item invalid">
                                            <i class="fas fa-check"></i>
                                            <i class="fas fa-times"></i>
                                            8 caractères minimum
                                        </li>
                                        <li id="uppercase" class="criteria-item invalid">
                                            <i class="fas fa-check"></i>
                                            <i class="fas fa-times"></i>
                                            Une majuscule
                                        </li>
                                        <li id="number" class="criteria-item invalid">
                                            <i class="fas fa-check"></i>
                                            <i class="fas fa-times"></i>
                                            Un chiffre
                                        </li>
                                        <li id="special" class="criteria-item invalid">
                                            <i class="fas fa-check"></i>
                                            <i class="fas fa-times"></i>
                                            Un caractère spécial
                                        </li>
                                    </ul>
                                </div>
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
                            <div id="confirm-feedback" class="feedback"></div>
                            <?php if (isset($errors['confirm_password'])): ?>
                                <div class="error-message"><?= $errors['confirm_password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Créer un compte</button>
                    </form>
                    
                    <div class="auth-links">
                        Déjà inscrit ? <a href="login.php">Connectez-vous</a>
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
        <?php
    }
}

// Initialiser le contrôleur
$db = new PDO('mysql:host=localhost;dbname=archivdb', 'root', ''); // Remplace par tes informations de connexion
$controller = new RegisterController($db);
$controller->handleRequest();
?>