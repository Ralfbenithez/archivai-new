<?php
require_once __DIR__ . '/../config/config.php'; // Chemin corrigé

header('Content-Type: application/json');

// Fonction pour valider la syntaxe de l'email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email);
}

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);  
    
    // Récupération et validation de l'email
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'L\'email est requis.']);
        exit;
    }

    if (!validateEmail($email)) {
        echo json_encode(['status' => 'error', 'message' => 'L\'email n\'est pas valide.']);
        exit;
    }

    // Vérification si l'email existe déjà dans la base de données
    $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
        echo json_encode(['status' => 'error', 'message' => 'Cet email est déjà utilisé.']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Cet email est disponible.']);
    }
} 

catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erreur de base de données.']);
} 

catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}