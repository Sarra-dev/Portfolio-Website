

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Realm - Portfolio</title>
    <link rel="stylesheet" href="style.css">
   
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
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="portfolio.php">Portfolio</a></li>
                <li><a href="contact.php">Contact Me</a></li>
                <li><a href="profile.php">My Profile</a></li>
                <li class="user-greeting">
                </li>
            </ul>
        </nav>
    </header>
    
    <!-- Hero Section -->
    <main class="hero">
        <div class="video-background">
            <video autoplay loop muted>
                <source src="assets/video.mp4" type="video/mp4">
            </video>
        </div>
        <div class="content">
            <h2>Hi! <br> I am <span>Sarra Bettaieb</span></h2>
            <p>Artist</p>
            <p>"Art washes away from the soul the dust of everyday life."</p>
            <a href="portfolio.php" class="btn-primary">Visit My Works</a>
        </div>
    </main>

    <!-- Featured Artwork Section -->
    <section class="featured-artwork">
        <div class="artwork-image">
            <img src="assets/IMG_8564 (2).jpg" alt="Featured Artwork Title">
        </div>
        <div class="artwork-description">
            <h2 class="artwork-title">The Journey</h2>
            <p class="artwork-story">This portrait pays tribute to the iconic figure, Sofien Chaari, capturing his warmth and charisma through detailed pencil strokes.</p>
            <p class="artwork-medium"><strong>Medium:</strong> Pencil on paper</p>
            <p class="artwork-dimensions"><strong>Dimensions:</strong> 24"x36"</p>
            <a href="portfolio.php" class="btn-primary">See More of My Work</a>
        </div>
    </section>
    
    <!-- Image Background Section -->
    <section class="image-background-section">
        <div class="content">
            <h2>Art</h2>
            <p>"Painting is poetry that is seen rather than felt, and poetry is painting that is felt rather than seen."</p> 
            <p>Leonardo da Vinci</p>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="section" id="pricing">
        <div class="container1">
            <p class="artwork-title">How Much I Charge?</p>
            <br><br>
            
            <div class="pricing-wrapper">

                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <img class="pricing-card-icon" src="<?php echo htmlspecialchars($plan['icon']); ?>" alt="<?php echo htmlspecialchars($plan['name']); ?> Plan Icon">
                    </div>
                    <div>
                        <h6 class="pricing-card-title"><?php echo htmlspecialchars($plan['name']); ?></h6>
                        <ul class="pricing-card-list">
                            <?php foreach($plan['features'] as $feature): ?>
                                <li><?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div>
                        <span>/Month</span>
                    </div>
                    <button type="button" 
                            class="btn-primary <?php echo ($_SESSION['subscription_type'] ?? null) === $plan['name'] ? 'current-plan-btn' : 'subscribe-btn'; ?>" 
                            data-plan="<?php echo htmlspecialchars($plan['name']); ?>"
                            
                    </button>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- Confirmation Modal -->
    <div id="subscriptionModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Subscription</h3>
            <p id="modal-message">Are you sure you want to subscribe to the <span id="plan-name"></span> plan for $<span id="plan-price"></span>/month?</p>
            <form id="subscriptionForm" method="POST">
                <input type="hidden" name="plan" id="modal-plan-input">
                <div class="modal-buttons">
                    <button type="button" class="modal-btn cancel" id="cancel-btn">Cancel</button>
                    <button type="submit" name="confirm_subscription" class="modal-btn confirm">Confirm</button>
                </div>
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

    </footer>

  
</body>
</html>
