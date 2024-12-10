<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_text = $_POST['input_text'];
    $operation = $_POST['operation'];
    $master_key = $_POST['master_key'];

    if (!$master_key) {
        $master_key = bin2hex(random_bytes(12)); // Auto-generate 24-char key
        echo "<p>Generated Master Key: $master_key</p>";
    }

    try {
        if ($operation === 'encrypt') {
            $result = encrypt_multi_layer($input_text, $master_key);
            echo "<p>Encrypted Text: $result</p>";
        } else {
            $result = decrypt_multi_layer($input_text, $master_key);
            echo "<p>Decrypted Text: $result</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error: {$e->getMessage()}</p>";
    }
}
?>
 948d264bdf24c8d906b9d20a