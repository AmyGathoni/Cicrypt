<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Decrypt Message</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .result { margin-top: 20px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Decrypt Message</h2>
        <form action="decrypt.php" method="post">
            <div class="form-group">
                <label for="encrypted_message">Encrypted Message</label>
                <textarea id="encrypted_message" name="encrypted_message" required></textarea>
            </div>
            <div class="form-group">
                <label for="key">Decryption Key</label>
                <input type="text" id="key" name="key" required>
            </div>
            <button type="submit">Decrypt</button>
        </form>
        <?php if (isset($_POST['encrypted_message']) && isset($_POST['key'])): ?>
            <div class="result">
                <h3>Decrypted Message:</h3>
                <p>
                    <?php
                    $encrypted_message = $_POST['encrypted_message'];
                    $key = $_POST['key'];
                    $decrypted_message = openssl_decrypt($encrypted_message, 'aes-256-cbc', $key, 0, substr($key, 0, 16));
                    echo htmlspecialchars($decrypted_message);
                    ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
