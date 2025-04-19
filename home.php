<?php
require_once 'auth/auth_functions.php';
require_once 'auth/config.php';

if(!isLoggedIn()) {
    header("Location: auth/login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']); 

// Définir les plans d'abonnement
$subscriptionPlans = [
    [
        'name' => 'Free',
        'price' => 0.00,
        'features' => ['Basic Access', 'Consultations', 'Discount Offers'],
        'icon' => 'assets/scooter.svg'
    ],
    [
        'name' => 'Basic',
        'price' => 9.99,
        'features' => ['Custom Portraits', 'Revision Included', 'Priority Queue'],
        'icon' => 'assets/shipped.svg'
    ],
    [
        'name' => 'Premium',
        'price' => 99.99,
        'features' => ['Exclusive artwork', 'Unlimited Revisions', 'Dedicated Consultation'],
        'icon' => 'assets/startup.svg'
    ]
];

// Traitement de l'abonnement
$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_subscription'])) {
    $selectedPlan = $_POST['plan'];
    
    try {
        // Vérifier si l'utilisateur a déjà ce plan
        if(($_SESSION['subscription_type'] ?? null) === $selectedPlan) {
            $message = '<div class="alert warning">You already have the '.$selectedPlan.' plan</div>';
        } else {
            // Mettre à jour l'abonnement
            $stmt = $db->prepare("UPDATE users SET subscription_type = ?, subscription_date = NOW() WHERE id = ?");
            $stmt->execute([$selectedPlan, $_SESSION['user_id']]);
            
            // Mettre à jour la session
            $_SESSION['subscription_type'] = $selectedPlan;
            $_SESSION['subscription_date'] = date('Y-m-d H:i:s');
            
            $message = '<div class="alert success">Success! You are now subscribed to the '.$selectedPlan.' plan</div>';
        }
    } catch(PDOException $e) {
        $message = '<div class="alert error">Error: '.$e->getMessage().'</div>';
    }
}
?>

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
                <li class="user-greeting">
                    <span>Welcome, <?php echo $username; ?></span>
                    <a href="auth/logout.php" class="logout-btn">Logout</a>
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
            
            <?php echo $message; ?>
            
            <div class="pricing-wrapper">
                <?php foreach($subscriptionPlans as $plan): ?>
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
                        <span>$<?php echo number_format($plan['price'], 2); ?></span>
                        <span>/Month</span>
                    </div>
                    <button type="button" 
                            class="btn-primary <?php echo ($_SESSION['subscription_type'] ?? null) === $plan['name'] ? 'current-plan-btn' : 'subscribe-btn'; ?>" 
                            data-plan="<?php echo htmlspecialchars($plan['name']); ?>"
                            <?php echo ($_SESSION['subscription_type'] ?? null) === $plan['name'] ? 'disabled' : ''; ?>>
                        <?php echo ($_SESSION['subscription_type'] ?? null) === $plan['name'] ? 'Current Plan' : 'Subscribe'; ?>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if(isset($_SESSION['subscription_type'])): ?>
            <div class="current-subscription">
                <p>Your current plan: <strong><?php echo htmlspecialchars($_SESSION['subscription_type']); ?></strong></p>
                <p>Subscribed on: <?php echo htmlspecialchars($_SESSION['subscription_date']); ?></p>
            </div>
            <?php endif; ?>
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
        <p>© <?php echo date('Y'); ?> Art Realm. All Rights Reserved.</p>
    </footer>

    <script>
        // Gestion de la modale d'abonnement
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('subscriptionModal');
            const subscribeButtons = document.querySelectorAll('.subscribe-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const planNameSpan = document.getElementById('plan-name');
            const planPriceSpan = document.getElementById('plan-price');
            const modalPlanInput = document.getElementById('modal-plan-input');
            
            // Prix des plans pour affichage dans la modale
            const planPrices = {
                'Free': '0.00',
                'Basic': '9.99',
                'Premium': '99.99'
            };

            // Activer les boutons d'abonnement
            subscribeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const planName = this.getAttribute('data-plan');
                    
                    // Remplir la modale avec les infos du plan
                    planNameSpan.textContent = planName;
                    planPriceSpan.textContent = planPrices[planName];
                    modalPlanInput.value = planName;
                    
                    // Afficher la modale
                    modal.style.display = 'block';
                });
            });
            
            // Fermer la modale
            cancelBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
            
            // Fermer en cliquant à l'extérieur
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>