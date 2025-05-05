<?php
require '/../config/config.php'; 

try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    
    // Nettoyage des tokens
    $db->exec("UPDATE utilisateurs SET 
        activation_token = NULL, 
        activation_expires = NULL 
        WHERE activation_expires < NOW()");
    
    $db->exec("UPDATE utilisateurs SET 
        reset_token = NULL, 
        reset_expires = NULL 
        WHERE reset_expires < NOW()");
    
    error_log("[SUCCÈS] Nettoyage des tokens à ".date('Y-m-d H:i:s'));
} catch (Exception $e) {
    error_log("[ERREUR] ".$e->getMessage());
}