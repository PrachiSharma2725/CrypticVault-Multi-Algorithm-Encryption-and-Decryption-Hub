<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrypticVault - Dark Themed Header</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
<?php

session_start();


$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : null;

function getRedirectUrl($targetPage) {
    return isset($_SESSION['email']) ? $targetPage : 'login/index.php';
}
?>

<header>
    <div class="container">
        <div class="logo">
            <a href="#">CrypticVault</a>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="<?php echo getRedirectUrl('index.php'); ?>">Home</a></li>
                <li><a href="<?php echo getRedirectUrl('multi_layer_tool.php'); ?>">Multi-Layer Encryption</a></li>
                <li><a href="<?php echo getRedirectUrl('algorithm.php'); ?>">Algorithms</a></li>
                <li><a href="<?php echo getRedirectUrl('image_tool.php'); ?>">Image Encryptor</a></li>
            </ul>
            <?php if ($user_name): ?>
                
                <div class="user-menu">
                    <span class="user-email" title="<?php echo htmlspecialchars($user_name); ?>">Hi <?php echo htmlspecialchars($user_name); ?> !!!</span>
                    <ul class="dropdown">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="login/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
               
                <a href="login/index.php" class="cta-btn">Login</a>
            <?php endif; ?>
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="hero-container">
        <h1>Unlock the Power of Advanced Encryption</h1>
        <p>CrypticVault offers real-time multi-layer encryption to secure your data with the strongest algorithms available. Fast, reliable, and easy to use.</p>
        <a href="<?php echo getRedirectUrl('crypticvault.php'); ?>" class="hero-btn">Get Started Now</a>
    </div>
</section>

<script src="script.js"></script>
</body>
</html>
