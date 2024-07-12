<?php
require 'vendor/autoload.php'; // Include the Composer autoloader for Twilio

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $phone = $_POST['phone'];

    // Generate encryption key
    $key = bin2hex(random_bytes(16)); // 32 characters
    $encrypted_message = openssl_encrypt($message, 'aes-256-cbc', $key, 0, substr($key, 0, 16));

    // Send decryption key and encrypted message via SMS using Twilio
    $account_sid = 'ACc486ae915748f4012a493370d435fdc3';
    $auth_token = '070ba47144c15d741094283a7da02958';
    $twilio_number = '+13613092837';

    $client = new Client($account_sid, $auth_token);

    $sms_body = "Your decryption key is: " . $key . "\nHere is your encrypted message: " . $encrypted_message;

    try {
        $client->messages->create(
            $phone,
            [
                'from' => $twilio_number,
                'body' => $sms_body
            ]
        );

        echo "Message sent successfully.";
    } catch (Exception $e) {
        echo "Failed to send message: " . $e->getMessage();
    }
}
?>
