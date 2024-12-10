<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST['operation'];
    $key = $_POST['key'];

    if (empty($key) || strlen($key) !== 24) {
        die("Error: Key must be 24 characters long.");
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name']; // Original file name
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // Get file extension
        $outputDir = 'uploads/';
        $outputFile = $outputDir . ($operation === 'encrypt' ? 'encrypted_image.bin' : 'decrypted_image.jpg');

        // Ensure uploads directory exists
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $cipher = "des-ede3";
        $iv = str_repeat("\0", openssl_cipher_iv_length($cipher));

        if ($operation === "encrypt") {
            // Validate input file is an image
            if (!in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                die("Error: Please upload a valid image file for encryption.");
            }

            $data = file_get_contents($image);
            $encryptedData = openssl_encrypt($data, $cipher, $key, 0, $iv);
            if ($encryptedData === false) {
                die("Error: Encryption failed.");
            }
            file_put_contents($outputFile, $encryptedData);
            echo "Encryption Successful! <a href='$outputFile' download>Download Encrypted File</a>";
        } elseif ($operation === "decrypt") {
            // Validate input file is a .bin file based on its extension
            if ($fileExtension !== "bin") {
                die("Error: Please upload a valid .bin file for decryption.");
            }

            $data = file_get_contents($image);
            $decryptedData = openssl_decrypt($data, $cipher, $key, 0, $iv);
            if ($decryptedData === false) {
                die("Error: Decryption failed. Please check your key.");
            }
            file_put_contents($outputFile, $decryptedData);
            echo "Decryption Successful! <a href='$outputFile' download>Download Decrypted File</a>";
        } else {
            die("Error: Invalid operation.");
        }
    } else {
        die("Error: No file uploaded or upload error occurred.");
    }
}
?>
