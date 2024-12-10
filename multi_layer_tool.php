<?php
session_start();

function encrypt_multi_layer($text, $key) {
    // 1. AES Encryption
    $aes_key = substr(hash('sha256', $key), 0, 16);
    $aes_encrypted = openssl_encrypt($text, 'AES-128-CBC', $aes_key, 0, $aes_key);

    // 2. Caesar Cipher
    $caesar_encrypted = '';
    foreach (str_split($aes_encrypted) as $char) {
        $caesar_encrypted .= chr((ord($char) + 3) % 256);
    }

    // 3. Base64 Encoding
    return base64_encode($caesar_encrypted);
}

function decrypt_multi_layer($encrypted_text, $key) {
    // 3. Base64 Decoding
    $decoded_base64 = base64_decode($encrypted_text);

    // 2. Caesar Cipher Decryption
    $caesar_decrypted = '';
    foreach (str_split($decoded_base64) as $char) {
        $caesar_decrypted .= chr((ord($char) - 3 + 256) % 256);
    }

    // 1. AES Decryption
    $aes_key = substr(hash('sha256', $key), 0, 16);
    return openssl_decrypt($caesar_decrypted, 'AES-128-CBC', $aes_key, 0, $aes_key);
}

$result = '';
$master_key_generated = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_text = $_POST['input_text'];
    $operation = $_POST['operation'];
    $master_key = $_POST['master_key'];

    if (!$master_key) {
        $master_key = bin2hex(random_bytes(12)); // Auto-generate 24-char key
        $master_key_generated = "Generated Master Key: $master_key";
    }

    try {
        if ($operation === 'encrypt') {
            $result = "Encrypted Text: " . encrypt_multi_layer($input_text, $master_key);
        } else {
            $result = "Decrypted Text: " . decrypt_multi_layer($input_text, $master_key);
        }
    } catch (Exception $e) {
        $result = "Error: {$e->getMessage()}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Layer Encryption Tool</title>
    <link rel="stylesheet" href="multi_layerstyle.css">
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

<div class="tool-container">
    <h1>Multi-Layer Encryption Tool</h1>
    <p class="description">Encrypt and decrypt text using multiple layers of security. Provide a master key or let the system generate one for you!</p>
    <form method="POST">
        <textarea name="input_text" placeholder="Enter text to encrypt or decrypt..." required></textarea>
        <input type="text" name="master_key" placeholder="Enter a master key (optional)">
        <select name="operation">
            <option value="encrypt">Encrypt</option>
            <option value="decrypt">Decrypt</option>
        </select>
        <button type="submit">Process</button>
    </form>

    <?php if ($master_key_generated): ?>
        <p class="generated-key"><?php echo $master_key_generated; ?></p>
    <?php endif; ?>
    <?php if ($result): ?>
        <p class="result"><?php echo $result; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
