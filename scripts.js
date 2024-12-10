// Get DOM elements
const algorithmSelect = document.getElementById("algorithm-select");
const inputText = document.getElementById("input-text");
const keyInput = document.getElementById("key-input");
const operationRadios = document.getElementsByName("operation");
const submitBtn = document.getElementById("submit-btn");
const outputText = document.getElementById("output-text");

// Event listener for the submit button
submitBtn.addEventListener("click", function() {
    const algorithm = algorithmSelect.value;
    const input = inputText.value;
    const key = keyInput.value;
    const operation = Array.from(operationRadios).find(radio => radio.checked).value;

    let result = "";

    // Execute the selected algorithm
    switch(algorithm) {
        case "caesar":
            result = caesarCipher(input, key, operation);
            break;
        case "aes":
            result = aesEncryption(input, key, operation);
            break;
        case "des":
            result = desEncryption(input, key, operation);
            break;
        case "rsa":
            result = rsaEncryption(input, key, operation);
            break;
        case "vigenere":
            result = vigenereCipher(input, key, operation);
            break;
        case "xor":
            result = xorEncryption(input, key, operation);
            break;
        case "blowfish":
            result = blowfishEncryption(input, key, operation);
            break;
        case "twofish":
            result = twofishEncryption(input, key, operation);
            break;
        case "md5":
            result = md5Hash(input);
            break;
        case "sha1":
            result = sha1Hash(input);
            break;
        case "sha256":
            result = sha256Hash(input);
            break;
        case "rc4":
            result = rc4Encryption(input, key, operation);
            break;
        case "elgamal":
            result = elgamalEncryption(input, key, operation);
            break;
        case "ecc":
            result = eccEncryption(input, key, operation);
            break;
        case "hill":
            result = hillCipher(input, key, operation);
            break;
        case "multi-layer":
            result = multiLayerEncryption(input, key, operation);
            break;
        default:
            result = "Invalid algorithm";
    }

    // Output the result
    outputText.value = result;
});

// Caesar Cipher
function caesarCipher(text, key, operation) {
    let shift = parseInt(key) || 0;
    if (operation === "decrypt") shift = -shift;
    let result = "";
    for (let i = 0; i < text.length; i++) {
        let char = text.charCodeAt(i);
        if (char >= 65 && char <= 90) {
            result += String.fromCharCode(((char - 65 + shift) % 26 + 26) % 26 + 65);
        } else if (char >= 97 && char <= 122) {
            result += String.fromCharCode(((char - 97 + shift) % 26 + 26) % 26 + 97);
        } else {
            result += text[i];
        }
    }
    return result;
}

// AES Encryption
function aesEncryption(text, key, operation) {
    const passphrase = key || "defaultkey";
    if (operation === "encrypt") {
        return CryptoJS.AES.encrypt(text, passphrase).toString();
    } else {
        const bytes = CryptoJS.AES.decrypt(text, passphrase);
        return bytes.toString(CryptoJS.enc.Utf8);
    }
}

// DES Encryption
function desEncryption(text, key, operation) {
    const passphrase = key || "defaultkey";
    if (operation === "encrypt") {
        return CryptoJS.DES.encrypt(text, passphrase).toString();
    } else {
        const bytes = CryptoJS.DES.decrypt(text, passphrase);
        return bytes.toString(CryptoJS.enc.Utf8);
    }
}

// Vigenere Cipher
function vigenereCipher(text, key, operation) {
    let result = "";
    let keyIndex = 0;
    for (let i = 0; i < text.length; i++) {
        let char = text.charCodeAt(i);
        if (char >= 65 && char <= 90) {
            const shift = key.charCodeAt(keyIndex % key.length) - 65;
            result += String.fromCharCode(((char - 65 + (operation === "encrypt" ? shift : -shift)) % 26 + 26) % 26 + 65);
            keyIndex++;
        } else if (char >= 97 && char <= 122) {
            const shift = key.charCodeAt(keyIndex % key.length) - 97;
            result += String.fromCharCode(((char - 97 + (operation === "encrypt" ? shift : -shift)) % 26 + 26) % 26 + 97);
            keyIndex++;
        } else {
            result += text[i];
        }
    }
    return result;
}

// XOR Encryption
function xorEncryption(text, key, operation) {
    let result = "";
    const keyLength = key.length;
    for (let i = 0; i < text.length; i++) {
        result += String.fromCharCode(text.charCodeAt(i) ^ key.charCodeAt(i % keyLength));
    }
    return result;
}

// MD5 Hashing
function md5Hash(text) {
    return CryptoJS.MD5(text).toString();
}

// SHA1 Hashing
function sha1Hash(text) {
    return CryptoJS.SHA1(text).toString();
}

// SHA256 Hashing
function sha256Hash(text) {
    return CryptoJS.SHA256(text).toString();
}

// RC4 Encryption
function rc4Encryption(text, key, operation) {
    const cipher = CryptoJS.RC4.encrypt(text, key || "defaultkey");
    return operation === "decrypt" ? CryptoJS.RC4.decrypt(cipher, key || "defaultkey").toString(CryptoJS.enc.Utf8) : cipher.toString();
}

// Multi-layer Encryption
function multiLayerEncryption(text, key, operation) {
    const aesResult = aesEncryption(text, key, operation);
    return md5Hash(aesResult);
}
