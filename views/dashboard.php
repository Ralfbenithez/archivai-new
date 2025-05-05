<?php
define('CSS_URL', '/archivai/assets/css/');
define('IMG_URL', '/archivai/assets/img/');
define('JS_URL', '/archivai/assets/js/');
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
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= IMG_URL ?>archivAI.png" alt="ArchivAI Logo" height="40">
                <span>ArchivAI</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fichiers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Réglage</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-folder"></i> Fichiers</a></li>
                <li><a href="#"><i class="fas fa-user"></i> Compte</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Réglage</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <div class="top-bar">
                <input type="text" placeholder="Entrer une recherche..." class="search-bar">
                <button class="btn btn-primary">Filtrer</button>
            </div>
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
                    <h2>12</h2>
                    <p>Catégories</p>
                </div>
            </div>
            <div class="charts">
                <div class="chart-container">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            &copy; 2025 ArchivAI. Tous droits réservés.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= JS_URL ?>dashboard.js"></script>
</body>
</html>