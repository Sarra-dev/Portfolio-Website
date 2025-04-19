<?php
// auth/config.php

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_auth');

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la table users si elle n'existe pas
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        subscription_type VARCHAR(20) DEFAULT NULL,
        subscription_date DATETIME DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Vérifier et ajouter les colonnes manquantes (méthode compatible avec toutes versions MySQL)
    $columns = $db->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('subscription_type', $columns)) {
        $db->exec("ALTER TABLE users ADD COLUMN subscription_type VARCHAR(20) DEFAULT NULL");
    }
    
    if (!in_array('subscription_date', $columns)) {
        $db->exec("ALTER TABLE users ADD COLUMN subscription_date DATETIME DEFAULT NULL");
    }
               
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialisation de la session
session_start();
?>