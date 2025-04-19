<?php
require_once 'auth_functions.php';

if(isLoggedIn()) {
    header("Location: ../home.php");
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if(empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $result = loginUser($email, $password);
        // Si loginUser ne redirige pas, c'est qu'il y a une erreur
        $error = $result;
    }
}

// include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <main class="auth-container">
        <section class="auth-form">
            <h2>Connexion</h2>
            
            <?php if($error): ?>
                <div class="auth-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="auth-submit-btn">Se connecter</button>
            </form>
            
            <p class="auth-switch">Pas encore de compte? <a href="register.php">Inscrivez-vous</a></p>
        </section>
    </main>
</body>
</html>