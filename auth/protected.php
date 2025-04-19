<!-- Pour protéger les pages et n'y donner accès qu'aux utilisateurs connectés -->
<?php
// auth/protected.php
require_once 'auth_functions.php';

if(!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>