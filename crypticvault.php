<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrypticVault Dashboard</title>
    <link rel="stylesheet" href="dashstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

</head>
<body>
<?php
session_start();
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : null;
?>

<header>
    <div class="container">
        <div class="logo">
            <a href="#">CrypticVault</a>
        </div>
        <nav>
            <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
                <li><a href="multi_layer_tool.php">Multi-Layer Encryption</a></li>
                <li><a href="algorithms.php">Algorithms</a></li>
                <li><a href="image_tool.php">Image Encryption</a></li>
            
            </ul>
            <?php if ($user_name): ?>
                <div class="user-menu">
                    <span class="user-email" title="<?php echo htmlspecialchars($user_name); ?>">Hi <?php echo htmlspecialchars($user_name); ?>!</span>
                    <ul class="dropdown">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="login/logout.php">Logout</a></li>

                    </ul>
                </div>
            <?php else: ?>
                <a href="login.php" class="cta-btn">Login</a>
            <?php endif; ?>
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </div>
</header>

<!-- Main Content Section -->
<div class="main-content">
    <div class="glass-container">
        <h1>CrypticVault: Multi-Algorithm Encryption & Decryption</h1>

        <div class="form-section">
            <!-- Algorithm Selection -->
            <label for="algorithm-select">Choose Algorithm:</label>
            <select id="algorithm-select">
                <option value="caesar">Caesar Cipher</option>
                <option value="aes">AES</option>
                <option value="des">DES</option>
                <option value="rsa">RSA</option>
                <option value="vigenere">Vigenère Cipher</option>
                <option value="xor">XOR Encryption</option>
                <option value="blowfish">Blowfish</option>
                <option value="twofish">Twofish</option>
                <option value="md5">MD5</option>
                <option value="sha1">SHA-1</option>
                <option value="sha256">SHA-256</option>
                <option value="rc4">RC4</option>
                <option value="elgamal">ElGamal</option>
                <option value="ecc">Elliptic Curve Cryptography (ECC)</option>
                <option value="hill">Hill Cipher</option>
                <option value="multi-layer">Multi-Layer Encryption</option>
            </select>

            <!-- Input Area -->
            <label for="input-text">Input Text:</label>
            <textarea id="input-text" rows="5" placeholder="Enter text to encrypt/decrypt"></textarea>

            <!-- Key/Shift Input -->
            <label for="key-input">Key/Shift:</label>
            <input type="text" id="key-input" placeholder="Enter key or shift (if applicable)">

            <!-- Encrypt or Decrypt Selection -->
            <div class="radio-section">
                <label><input type="radio" name="operation" value="encrypt" checked> Encrypt</label>
                <label><input type="radio" name="operation" value="decrypt"> Decrypt</label>
            </div>

            <!-- Button to Perform Operation -->
            <button id="submit-btn">Submit</button>

            <!-- Output Area -->
            <label for="output-text">Output:</label>
            <textarea id="output-text" rows="5" readonly></textarea>
        </div>
    </div>
</div>


    <script src="scripts.js"></script>
</body>
</html>
