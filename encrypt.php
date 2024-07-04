<?php
require 'vendor/autoload.php'; // Include the Composer autoloader for Twilio

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Generate encryption key
    $key = bin2hex(random_bytes(16)); // 32 characters
    $encrypted_message = openssl_encrypt($message, 'aes-256-cbc', $key, 0, substr($key, 0, 16));

    // Send encrypted message via email
    $subject = "Encrypted Message";
    $body = "Here is your encrypted message: " . $encrypted_message;
    $headers = "From: sender@example.com";

    if (mail($email, $subject, $body, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Failed to send email.";
    }

    // Send decryption key via SMS using Twilio
    $account_sid = 'ACc486ae915748f4012a493370d435fdc3';
    $auth_token = '070ba47144c15d741094283a7da02958';
    $twilio_number = '+13613092837';

    $client = new Client($account_sid, $auth_token);

    $client->messages->create(
        $phone,
        [
            'from' => $twilio_number,
            'body' => "Your decryption key is: " . $key
        ]
    );

    echo "Message sent successfully.";
}
?>
