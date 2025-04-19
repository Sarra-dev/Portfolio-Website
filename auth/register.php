<?php
// auth/register.php

require_once 'auth_functions.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validation
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif(strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $result = registerUser($username, $email, $password);
        
        if($result === true) {
            $success = "Inscription réussie! Vous pouvez maintenant vous connecter.";
            // Réinitialiser les champs après succès
            $username = $email = '';
        } else {
            $error = $result;
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <main class="auth-container">
        <section class="auth-form">
            <h2>Créer un compte</h2>
            
            <?php if($error): ?>
                <div class="auth-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="auth-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe (8 caractères minimum)</label>
                    <input type="password" id="password" name="password" minlength="8" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" minlength="8" required>
                </div>
                
                <button type="submit" class="auth-submit-btn">S'inscrire</button>
            </form>
            
            <p class="auth-switch">Déjà un compte? <a href="login.php">Connectez-vous</a></p>
        </section>
    </main>
</body>
</html>