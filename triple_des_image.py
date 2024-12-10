# from Crypto.Cipher import DES3
# from Crypto.Random import get_random_bytes
# import os
# import sys

# def pad(data):
#     return data + b"\0" * (8 - len(data) % 8)

# def encrypt_image(input_file, output_file, key):
#     with open(input_file, 'rb') as file:
#         data = file.read()
#     cipher = DES3.new(key, DES3.MODE_ECB)
#     padded_data = pad(data)
#     encrypted_data = cipher.encrypt(padded_data)
#     with open(output_file, 'wb') as file:
#         file.write(encrypted_data)

# def decrypt_image(input_file, output_file, key):
#     with open(input_file, 'rb') as file:
#         encrypted_data = file.read()
#     cipher = DES3.new(key, DES3.MODE_ECB)
#     decrypted_data = cipher.decrypt(encrypted_data).rstrip(b"\0")
#     with open(output_file, 'wb') as file:
#         file.write(decrypted_data)

# if __name__ == "__main__":
#     mode = sys.argv[1]
#     input_file = sys.argv[2]
#     output_file = sys.argv[3]
#     key = b'Sixteen byte key!!'  # Replace with a secure key

#     if len(key) != 24:
#         print("Key must be exactly 24 bytes.")
#         sys.exit(1)

#     if mode == "encrypt":
#         encrypt_image(input_file, output_file, key)
#         print("Encryption complete.")
#     elif mode == "decrypt":
#         decrypt_image(input_file, output_file, key)
#         print("Decryption complete.")
#     else:
#         print("Invalid mode. Use 'encrypt' or 'decrypt'.")
