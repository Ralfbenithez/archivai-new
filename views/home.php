<?php
define('CSS_URL', '/archivai//assets/css/'); 
define('IMG_URL', '/archivai/assets/img/');
define('JS_URL', '/archivai/assets/js/');
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= CSS_URL ?>styles.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="<?= IMG_URL ?>archivAI.png" type="image/x-icon">
    <!-- Meta tags pour SEO -->
    <meta name="description" content="ArchivAI - Solution d'archivage intelligent par IA qui révolutionne la gestion documentaire. Classification automatique, OCR avancé et sécurité renforcée.">
    <meta name="keywords" content="archivage, IA, intelligence artificielle, gestion documentaire, OCR, classification automatique, archivage numérique, Côte d'Ivoire">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= IMG_URL ?><?= $data['footer']['logo'] ?>" alt="ArchivAI Logo" height="40">
                <span>ArchivAI</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Processus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="ms-3 d-flex">
                    <a href="../views/register.php" class="btn btn-outline-light me-2">Inscription</a>
                    <a href="../views/login.php" class="btn btn-conversion">Connexion</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title"><?= $data['hero']['title'] ?></h1>
                    <p class="hero-text">
                        <?= $data['hero']['text'] ?>
                    </p>
                    <div class="hero-buttons">
                        <a href="#contact" class="btn btn-demo me-3">Nous contacter</a>
                        <a href="#how-it-works" class="btn btn-outline-light">En savoir plus</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <img src="<?= IMG_URL ?><?= $data['footer']['logo'] ?>" alt="ArchivAI" class="img-fluid archivai-image"  height="100%" width="100%">
                </div>
            </div>
        </div>
        <div class="shape-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <h2 class="section-title"><?= $data['about']['title'] ?></h2>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image-container">
                        <img src="<?= IMG_URL ?>about-image.png" alt="À propos d'ArchivAI" class="img-fluid about-image">
                        <div class="about-pattern"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <p class="about-text"><?= $data['about']['text'] ?></p>
                        <p class="about-vision"><strong>Notre vision:</strong> <?= $data['about']['vision'] ?></p>
                        <div class="about-stats">
                            <div class="stat-item">
                                <span class="stat-number">95%</span>
                                <span class="stat-text">Gain de temps</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">99.9%</span>
                                <span class="stat-text">Précision IA</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">500+</span>
                                <span class="stat-text">Clients satisfaits</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="section-title"><?= $data['features']['title'] ?></h2>
            <p class="section-subtitle">
                <?= $data['features']['subtitle'] ?>
            </p>
            <div class="row">
                <?php foreach ($data['features']['items'] as $feature): ?>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="<?= $feature['icon'] ?>"></i>
                            </div>
                            <h3 class="feature-title"><?= $feature['title'] ?></h3>
                            <p class="feature-text">
                                <?= $feature['text'] ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2 class="section-title"><?= $data['steps']['title'] ?></h2>
            <p class="section-subtitle">
                <?= $data['steps']['subtitle'] ?>
            </p>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="process-container">
                        <div class="process-line"></div>

                        <?php foreach ($data['steps']['items'] as $step): ?>
                            <div class="process-step">
                                <div class="step-number"><?= $step['number'] ?></div>
                                <div class="step-content">
                                    <h4 class="step-title"><?= $step['title'] ?></h4>
                                    <p class="step-text">
                                        <?= $step['text'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="cta-title"><?= $data['contact']['title'] ?></h2>
                    <p class="cta-text">
                        <?= $data['contact']['text'] ?>
                    </p>
                    <div class="contact-info">
                        <?php foreach ($data['contact']['info'] as $info): ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="<?= $info['icon'] ?>"></i>
                                </div>
                                <span><?= $info['text'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 mt-5 mt-lg-0">
                    <div class="contact-form">
                        <form id="contactForm">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Nom complet" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <select class="form-select">
                                    <option selected disabled>Comment pouvons-nous vous aider ?</option>
                                    <option>Démo personnalisée</option>
                                    <option>Informations tarifaires</option>
                                    <option>Support technique</option>
                                    <option>Autre demande</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-submit">Envoyer le message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-logo">
                        <img src="<?= IMG_URL ?><?= $data['footer']['logo'] ?>" alt="ArchivAI Logo" height="30">
                        <span class="ms-2 text-white">ArchivAI</span>
                    </div>
                    <p class="footer-tagline">
                        <?= $data['footer']['tagline'] ?>
                    </p>
                    <div class="social-links">
                        <?php foreach ($data['footer']['social'] as $social): ?>
                            <a href="<?= $social['link'] ?>" class="social-icon" aria-label="Suivez-nous sur les réseaux sociaux">
                                <i class="<?= $social['icon'] ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php foreach ($data['footer']['links'] as $linkGroup): ?>
                    <div class="col-lg-2 col-md-4 mb-4">
                        <h4 class="footer-heading"><?= $linkGroup['title'] ?></h4>
                        <div class="footer-links">
                            <?php foreach ($linkGroup['items'] as $item): ?>
                                <a href="#" class="footer-link"><?= $item ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="copyright">
                © 2025 ArchivAI. Tous droits réservés.
            </div>
        </div>

        <div class="back-to-top" >
           <a href="#home" aria-label="Retour en haut"><i class="fas fa-arrow-up"></i></a>  
        </div>
        
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= JS_URL ?>script.js"></script>
</body>
</html>