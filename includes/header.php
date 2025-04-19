<?php
// includes/header.php
require_once '../auth/auth_functions.php';
?>

<!-- Header Section -->
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
            <li><a href="portfolio.php">Portfolio</a></li>
            <li><a href="contact.php">Contact Me</a></li>
            <?php if(isLoggedIn()): ?>
                <li class="auth-user">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="auth/logout.php" class="logout-btn">Logout</a>
                </li>
            <?php else: ?>
                <li><a href="auth/login.php" class="login-btn">Login</a></li>
                <li><a href="auth/register.php" class="register-btn">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>