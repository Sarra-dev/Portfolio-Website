<?php

require_once 'auth/config.php';
require_once 'auth/auth_functions.php';

// Récupérer les données utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT username, email, subscription_type, subscription_date FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$username = htmlspecialchars($user['username']);
$email = htmlspecialchars($user['email']);
$subscription = htmlspecialchars($user['subscription_type'] ?? 'No subscription');
$subscription_date = $user['subscription_date'] ? date('F j, Y', strtotime($user['subscription_date'])) : 'N/A';

// Traitement du changement de mot de passe
$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    try {
        // Vérifier le mot de passe actuel
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $db_user = $stmt->fetch();
        
        if(!password_verify($current_password, $db_user['password'])) {
            $message = '<div class="alert error">Current password is incorrect</div>';
        } elseif($new_password !== $confirm_password) {
            $message = '<div class="alert error">New passwords do not match</div>';
        } else {
            // Mettre à jour le mot de passe
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);
            
            $message = '<div class="alert success">Password changed successfully!</div>';
        }
    } catch(PDOException $e) {
        $message = '<div class="alert error">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Art Realm</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
<header class="header">
        <div class="logo">
            <img src="assets/logi1.png" alt="Logo">
        </div>
        <input type="checkbox" id="menuToggle" class="menu-checkbox">
        <label for="menuToggle" class="menu-icon">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <nav class="nav">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="portfolio.php" class="active">Portfolio</a></li>
                <li><a href="contact.php">Contact Me</a></li>
                <li><a href="profile.php">My Profile</a></li>
                <?php if(isLoggedIn()): ?>
                <li class="user-greeting">
                    <span>Welcome, <?php echo $username; ?></span>
                    <a href="auth/logout.php" class="logout-btn">Logout</a>
                </li>
            <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($username, 0, 1)); ?>
            </div>
            <h1>My Profile</h1>
        </div>
        
        <?php echo $message; ?>
        
        <div class="profile-info">
            <div class="info-group">
                <div class="info-label">Username</div>
                <div class="info-value"><?php echo $username; ?></div>
            </div>
            
            <div class="info-group">
                <div class="info-label">Email</div>
                <div class="info-value"><?php echo $email; ?></div>
            </div>
            
            <div class="info-group">
                <div class="info-label">Subscription Plan</div>
                <div class="info-value">
                    <?php echo $subscription; ?>
                    <?php if($subscription !== 'No subscription'): ?>
                        <br><small>Since <?php echo $subscription_date; ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="password-form">
            <h2>Change Password</h2>
            <form method="POST">
                <input type="hidden" name="change_password" value="1">
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn-primary">Update Password</button>
            </form>
        </div>
    </div>
    
    <!-- Footer Section -->
    <footer class="footer">
        <div class="social-links">
            <a href="https://www.facebook.com/sarra.btb.9" target="_blank" aria-label="Facebook">
                <img src="assets/facebook (1).png" alt="Facebook">
            </a>
            <a href="https://www.instagram.com/sarah_s_art_realm/" target="_blank" aria-label="Instagram">
                <img src="assets/instagram.png" alt="Instagram">
            </a>
            <a href="https://www.tiktok.com/@sarrabettaieb2?is_from_webapp=1&sender_device=pc" target="_blank" aria-label="LinkedIn">
                <img src="assets/social-media.png" alt="LinkedIn">
            </a>
        </div>
        <p>© <?php echo date('Y'); ?> Art Realm. All Rights Reserved.</p>
    </footer>
</body>
</html>