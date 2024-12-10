<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit;
}

// Database configuration
$server = "localhost";
$username = "root";
$password = "";
$database = "crypticvault";

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result_message = '';
$result_file = null;
$key = '';

// Fetch the latest key if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT key_value FROM user_keys WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($key);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST['operation'];
    $key = $_POST['key'] ?: $key; // Use the fetched key if not provided in the form

    if (empty($key) || strlen($key) !== 24) {
        $result_message = "Error: Key must be 24 characters long.";
    } else {
        // Removed the save key logic, now only focus on file encryption/decryption
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $outputDir = 'uploads/';
            $outputFile = $outputDir . ($operation === 'encrypt' ? 'encrypted_image.bin' : 'decrypted_image.jpg');

            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $cipher = "des-ede3";
            $iv = str_repeat("\0", openssl_cipher_iv_length($cipher));

            if ($operation === "encrypt") {
                if (!in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $result_message = "Error: Please upload a valid image file for encryption.";
                } else {
                    $data = file_get_contents($image);
                    $encryptedData = openssl_encrypt($data, $cipher, $key, 0, $iv);
                    if ($encryptedData === false) {
                        $result_message = "Error: Encryption failed.";
                    } else {
                        file_put_contents($outputFile, $encryptedData);
                        $result_message = "Encryption Successful!";
                        $result_file = $outputFile;
                    }
                }
            } elseif ($operation === "decrypt") {
                if ($fileExtension !== "bin") {
                    $result_message = "Error: Please upload a valid .bin file for decryption.";
                } else {
                    $data = file_get_contents($image);
                    $decryptedData = openssl_decrypt($data, $cipher, $key, 0, $iv);
                    if ($decryptedData === false) {
                        $result_message = "Error: Decryption failed. Please check your key.";
                    } else {
                        file_put_contents($outputFile, $decryptedData);
                        $result_message = "Decryption Successful!";
                        $result_file = $outputFile;
                    }
                }
            } else {
                $result_message = "Error: Invalid operation.";
            }
        } else {
            $result_message = "Error: No file uploaded or upload error occurred.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Encryptor & Decryptor</title>
    <link rel="stylesheet" href="style_image.css">
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

<section class="image-encryptor">
    <div class="glass-container">
        <h2>Image Encryptor & Decryptor</h2>
        <p>Secure your images with advanced encryption. Choose an image, enter a key, and encrypt or decrypt with ease.</p>
        <form method="POST" enctype="multipart/form-data">
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*,.bin" required>

            <label for="key">Encryption/Decryption Key:</label>
            <div class="key-input-group">
                <input type="text" id="key" name="key" placeholder="Enter a 24-character key" value="<?php echo htmlspecialchars($key); ?>" required>
                <button type="button" id="generateKey" class="btn-small">Generate Key</button>
            </div>
            <p id="generatedKey" class="generated-key"></p>


            <label for="operation">Operation:</label>
            <select id="operation" name="operation" required>
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>

            <div class="btn-group">
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>

        <?php if ($result_message): ?>
            <p class="result-message"><?php echo htmlspecialchars($result_message); ?></p>
        <?php endif; ?>

        <?php if ($result_file): ?>
            <p class="result-link">
                <a href="<?php echo htmlspecialchars($result_file); ?>" download>Download File</a>
            </p>
        <?php endif; ?>
    </div>
</section>

<script>
    const generateKeyBtn = document.getElementById("generateKey");
    const keyInput = document.getElementById("key");
    const generatedKeyDisplay = document.getElementById("generatedKey");

    // Generate a random 24-character key
    generateKeyBtn.addEventListener("click", () => {
        const randomKey = Array.from(crypto.getRandomValues(new Uint8Array(24)))
            .map(b => b.toString(16).padStart(2, "0"))
            .join("")
            .slice(0, 24);
        keyInput.value = randomKey;
        generatedKeyDisplay.textContent = "Generated Key: " + randomKey;
    });
</script>
</body>
</html>
