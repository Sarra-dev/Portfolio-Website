<?php
// portfolio.php
require_once 'auth/auth_functions.php';
$isLoggedIn = isLoggedIn();
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Realm - Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
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
                <li><a href="portfolio.php" class="active">Portfolio</a></li>
                <li><a href="contact.php">Contact Me</a></li>
                <li><a href="profile.php">My Profile</a></li>
                <?php if($isLoggedIn): ?>
                    <li class="user-greeting">
                        <span>Welcome, <?php echo $username; ?></span>
                        <a href="auth/logout.php" class="logout-btn">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Gallery Section -->
    <section class="gallery">
        <h2>Explore my vibrant collection that capture the essence of creativity and passion.</h2>
        <div class="gallery-grid">
            <?php
            // Tableau des œuvres d'art
            $artworks = [
                [
                    'image' => 'assets/IMG_1598.JPG',
                    'title' => 'Baby Portrait',
                    'desc' => 'A detailed sketch capturing the innocence of a yawning baby.'
                ],
                [
                    'image' => 'assets/IMG_1599.JPG',
                    'title' => 'Woman in Hat',
                    'desc' => 'A serene portrait of a woman wearing a wide-brimmed hat.'
                ],
                [
                    'image' => 'assets/IMG_1600.JPG',
                    'title' => 'Young Girl',
                    'desc' => 'A soft and expressive sketch of a little girl with braided hair.'
                ],
                [
                    'image' => 'assets/IMG_1601.JPG',
                    'title' => 'Man\'s Profile',
                    'desc' => 'A dramatic portrait of a young man with intense expression.'
                ],
                [
                    'image' => 'assets/IMG_1602.JPG',
                    'title' => 'Stylized Woman',
                    'desc' => 'A minimalist sketch of a woman with bold features and short hair.'
                ],
                [
                    'image' => 'assets/IMG_1603.JPG',
                    'title' => 'Pensive Portrait',
                    'desc' => 'A thoughtful sketch of a young man resting his face on his hand, exuding a calm and reflective mood.'
                ],
                [
                    'image' => 'assets/IMG_1605.JPG',
                    'title' => 'Sunglasses Portrait',
                    'desc' => 'A striking sketch of a woman wearing sunglasses and an edgy hairstyle.'
                ],
                [
                    'image' => 'assets/IMG_1785.JPG',
                    'title' => 'Elegant Woman',
                    'desc' => 'A refined portrait of a woman in a collared jacket.'
                ],
                [
                    'image' => 'assets/IMG_4972.JPG',
                    'title' => 'Braided Girl',
                    'desc' => 'A detailed drawing of a girl with braided pigtails and a gothic vibe.'
                ],
                [
                    'image' => 'assets/IMG_6993.JPG',
                    'title' => 'Action Hero',
                    'desc' => 'A sketch of a man with sharp features and intense energy.'
                ],
                [
                    'image' => 'assets/IMG_8564.jpg',
                    'title' => 'Sofien Chaari',
                    'desc' => 'Sofien Chaari is a talented Tunisian actor whose career includes notable performances in popular Tunisian TV shows, films, and theater productions, where he has been praised for his natural charisma and emotive delivery.'
                ]
            ];

            // Affichage dynamique des œuvres
            foreach($artworks as $art): ?>
                <div class="gallery-item">
                    <img src="<?php echo htmlspecialchars($art['image']); ?>" alt="<?php echo htmlspecialchars($art['title']); ?>">
                    <p class="description">
                        <b><?php echo htmlspecialchars($art['title']); ?>:</b><br>
                        <?php echo htmlspecialchars($art['desc']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

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