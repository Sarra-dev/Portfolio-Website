<?php
// auth/auth_functions.php

require_once 'config.php';

// Fonction d'inscription
function registerUser($username, $email, $password) {
    global $db;
    
    try {
        // Vérifier si l'utilisateur existe déjà
        $query = $db->prepare("SELECT id FROM users WHERE email = ?");
        $query->execute([$email]);
        
        if($query->rowCount() > 0) {
            return "Cet email est déjà utilisé.";
        }
        
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer le nouvel utilisateur
        $query = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $query->execute([$username, $email, $hashedPassword]);
        
        return true;
    } catch(PDOException $e) {
        return "Erreur lors de l'inscription: " . $e->getMessage();
    }
}

function loginUser($email, $password) {
    global $db;
    
    try {
        // Récupérer l'utilisateur
        $query = $db->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        $user = $query->fetch();
        
        if(!$user || !password_verify($password, $user['password'])) {
            return "Email ou mot de passe incorrect.";
        }
        
        // Créer la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        
        // Redirection vers home.php
        header("Location: ../home.php");
        exit(); // Important pour arrêter l'exécution du script
        
    } catch(PDOException $e) {
        return "Erreur lors de la connexion: " . $e->getMessage();
    }
}

// Fonction de déconnexion
function logout() {
    session_destroy();
    header("Location: ../home.php");
    exit();
}

// Vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>