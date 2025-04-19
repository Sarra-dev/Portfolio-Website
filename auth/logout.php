<?php
require_once 'auth_functions.php';

// Détruire la session
session_destroy();

// Rediriger vers la page de login
header("Location: ../home.php");
exit();
?>