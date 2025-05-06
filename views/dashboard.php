<?php
session_start();
if (!isset($_SESSION['prenom'])) {
    header("Location: login.php");
    exit;
}

define('CSS_URL', '/archivai/assets/css/');
define('IMG_URL', '/archivai/assets/img/');
define('PP_URL', '/archivai/assets/profil/');
define('JS_URL', '/archivai/assets/js/');

// Correction pour récupérer le prénom de l'utilisateur
$prenom = isset($_SESSION['prenom']) && !empty($_SESSION['prenom']) ? $_SESSION['prenom'] : 'Hello !';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ArchivAI</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= CSS_URL ?>dashboard.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="<?= IMG_URL ?>archivAI.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= JS_URL ?>dashboard.js" defer></script>
</head>
<body class="dark-mode">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <!-- Logo et texte stylisé -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="<?= IMG_URL ?>archivAI.png" alt="ArchivAI Logo" height="40" class="me-2">
                <span style="font-weight: bold; font-size: 1.5rem; color: #3b82f6;">ArchivAI</span>
            </a>

            <!-- Barre de recherche -->
            <div class="d-flex align-items-center ms-auto me-3">
                <div class="search-bar-container position-relative">
                    <input type="text" class="form-control search-bar" placeholder="Rechercher un document..." id="searchInput">
                    <button class="btn search-icon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Profil et toggle nuit -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn-toggle-theme">
                    <i class="fas fa-sun"></i>
                </button>
                <div class="dropdown">
                    <button class="btn dropdown-toggle profile-btn d-flex align-items-center" type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= PP_URL ?>Profile black.jpg" alt="Photo de profil" class="rounded-circle me-2" width="40" height="40">
                        <span><?= htmlspecialchars($prenom) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="#">Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-folder"></i> Documents</a></li>
                <li><a href="#"><i class="fas fa-upload"></i> Importer</a></li>
                <li><a href="#"><i class="fas fa-user"></i> Compte</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Réglages</a></li>
            </ul>
            <!-- Carte Aide -->
            <div class="help-card mt-auto">
                <a href="#">
                    <i class="fas fa-question-circle"></i> Aide
                </a>
            </div>
        </aside>
        <main class="main-content">
            <div class="info-cards">
                <div class="info-card blue">
                    <h2>93</h2>
                    <p>Fichiers</p>
                </div>
                <div class="info-card pink">
                    <h2>2.56</h2>
                    <p>GO</p>
                </div>
                <div class="info-card green">
                    <h2>19</h2>
                    <p>Catégories de Fichiers</p>
                </div>
            </div>
            <div class="charts">
                <div class="chart-container">
                    <h5 class="mb-3">Statistique des fichiers</h5>
                    <canvas id="fileDistributionChart"></canvas>
                </div>
                <div class="chart-container">
                    <h5 class="mb-3">Activité mensuelle</h5>
                    <canvas id="monthlyActivityChart"></canvas>
                </div>
            </div>
            
            <!-- Section des documents récents -->
            <div class="mt-4">
                <h4 class="mb-3">Documents récents</h4>
                <div id="fileList" class="row g-3">
                    <!-- Les documents récents seront ajoutés via JavaScript -->
                </div>
            </div>
        </main>
    </div>

    <!-- Icône flottante pour l'appareil photo -->
    <div class="floating-camera">
        <i class="fas fa-camera"></i>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-copyright">
                &copy; 2025 ArchivAI. Tous droits réservés.
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>