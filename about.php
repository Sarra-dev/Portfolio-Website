<?php
// Début du script PHP pour gérer l'authentification et la base de données
require_once 'auth/auth_functions.php';

// Vérifier si l'utilisateur est connecté, sinon rediriger vers login.php
if(!isLoggedIn()) {
    header("Location: auth/login.php");
    exit();
}

// Connexion à la base de données et création des tables si elles n'existent pas
try {
    $db = new PDO("mysql:host=localhost", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données si elle n'existe pas
    $db->exec("CREATE DATABASE IF NOT EXISTS portfolio_db");
    $db->exec("USE portfolio_db");
    
    // Créer la table testimonials si elle n'existe pas
    $db->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_name VARCHAR(100) NOT NULL,
        client_role VARCHAR(100) NOT NULL,
        testimonial_text TEXT NOT NULL,
        avatar_path VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insérer des témoignages par défaut si la table est vide
    $stmt = $db->query("SELECT COUNT(*) FROM testimonials");
    if($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO testimonials (client_name, client_role, testimonial_text, avatar_path) VALUES
            ('Emily Reb', 'CEO, Creative Studio', 'Working with Sarra was an absolute delight! Her talent, attention to detail, and passion for her art truly shine through in every piece she creates.', 'assets/avatar3.jpg'),
            ('John Doe', 'Art Enthusiast', 'Sarra''s artwork is nothing short of magical! She captured my vision perfectly and brought it to life with such elegance and creativity.', 'assets/avatar2.jpg')
        ");
    }
    
} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Récupérer les témoignages depuis la base de données
$testimonials = $db->query("SELECT * FROM testimonials")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nom d'utilisateur pour l'affichage
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Art Realm</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    
     <!-- Header Section avec intégration PHP -->
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
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="portfolio.php">Portfolio</a></li>
                <li><a href="contact.php">Contact Me</a></li>
                <li><a href="profile.php">My Profile</a></li>
                <li class="user-greeting">
                    <span>Welcome, <?php echo $username; ?></span>
                    <a href="auth/logout.php" class="logout-btn">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- about section -->
    <section class="section" id="about">
        <!-- container -->
        <div class="container1 text-center">
            <!-- about wrapper -->
            <div class="about">
                <div class="about-img-holder">
                    <img src="assets/avatar.png" class="about-img" alt="Artist portrait">
                </div>
                <div class="about-caption">
                    <p class="section-subtitle">Who Am I ?</p>
                    <h2 class="section-title mb-3">About Me</h2>
                    <p>
                        Hi there! I'm Sarra, a passionate portrait artist who loves capturing emotions, stories, and personalities through art. Whether it's a pencil sketch, digital illustration, or a vibrant oil painting, I aim to create pieces that resonate with the heart and leave a lasting impression.
                        <br>Every stroke I make is a step toward preserving cherished memories, celebrating individuality, and highlighting the beauty in every detail. I take pride in turning photos, moments, and ideas into timeless artworks that my clients can treasure forever.
                        <br>When I'm not drawing, I find inspiration in exploring cultures, stories, and the unique expressions that make each person truly special. Let's create something amazing together—whether it is a portrait for your home, a gift for a loved one, or simply a piece of art that speaks to your soul.
                    </p>
                </div>              
            </div>
        </div>
    </section> 

    <!-- Updated "Hire Me" Section -->
    <section class="section-sm bg-primary hire-section">
        <div class="container1 text-center">
            <div class="row align-items-center">
                <div class="col-sm offset-md-1 mb-4 mb-md-0">
                    <h3>Want to work with me?</h3>
                    <p class="m-0 text-light">Always feel free to contact & hire me for your next masterpiece.</p>
                </div>
                <br>
                <div class="col-sm offset-sm-2 offset-md-3">
                    <a href="contact.php" class="btn-primary">Hire Me</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Updated "Testimonial" Section dynamique -->
    <section class="section" id="testmonial">
        <div class="container1 text-center">
            <h3>What My Clients Think About Me</h3>
            <br><br>
            <div class="testimonial-wrapper">
                <?php foreach($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <div>
                        <img src="<?php echo htmlspecialchars($testimonial['avatar_path']); ?>" class="testimonial-card-img" alt="Client Avatar">
                    </div>
                    <div>
                        <p class="testimonial-card-subtitle">
                            "<?php echo htmlspecialchars($testimonial['testimonial_text']); ?>"
                        </p>
                        <h6 class="testimonial-card-title"><?php echo htmlspecialchars($testimonial['client_name']); ?></h6>
                        <p class="testimonial-card-role"><?php echo htmlspecialchars($testimonial['client_role']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <br><br><br><br>

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