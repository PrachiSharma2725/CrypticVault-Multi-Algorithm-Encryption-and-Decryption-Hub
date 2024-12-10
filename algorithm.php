<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encryption Algorithms</title>
    <link rel="stylesheet" href="style_algorithm.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="#">CrypticVault</a>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="multi_layer_tool.php">Multi-Layer Encryption</a></li>
                <li><a href="algorithm.php">Algorithms</a></li>
                <li><a href="image_tool.php">Image Encryption</a></li>
            </ul>
            <?php if (isset($_SESSION['name'])): ?>
                <div class="user-menu">
                    <span class="user-email">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                    <ul class="dropdown">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="login/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="login.php" class="cta-btn">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>


<section class="algorithm-section">
    <div class="container">
        <h2>Learn Encryption Algorithms</h2>
        <div class="flip-card-container">
            <!-- Symmetric Encryption Card -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>Symmetric Encryption</h3>
                    </div>
                    <div class="flip-card-back">
                        <p>Symmetric encryption uses the same key for both encryption and decryption. It's fast and efficient, but key management can be a challenge.</p>
                    </div>
                </div>
            </div>
            
            <!-- Asymmetric Encryption Card -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>Asymmetric Encryption</h3>
                    </div>
                    <div class="flip-card-back">
                        <p>Asymmetric encryption uses two keys: a public key for encryption and a private key for decryption. It's more secure but slower than symmetric encryption.</p>
                    </div>
                </div>
            </div>

            <!-- 3DES Encryption Card -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>3DES (Triple DES)</h3>
                    </div>
                    <div class="flip-card-back">
                        <p>3DES applies the DES algorithm three times to each data block, offering enhanced security. However, it is slower compared to newer algorithms like AES.</p>
                    </div>
                </div>
            </div>

            <!-- Encryption Challenges Card -->
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <h3>Encryption Challenges</h3>
                    </div>
                    <div class="flip-card-back">
                        <p>Challenges in encryption include key management, brute force attacks, and balancing security with performance. Explore various techniques to optimize encryption.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



</body>
</html>
