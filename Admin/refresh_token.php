<?php
session_name("ADMIN_SESSION");
session_start();
require '../connection.php';
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secret_key = "Zarnat12$&10";
$issuer = "http://localhost";
$audience = "http://localhost";
$issued_at = time();

if (isset($_COOKIE['access_token'])) {
    $token = $_COOKIE['access_token'];
    try {
        $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));
        $user_id = $decoded_token->data->id;

        require '../connection.php'; // Ensure database connection

        $query = "UPDATE user SET status='active' WHERE id='$user_id'";
        mysqli_query($con, $query);

        $new_expTime = time() + 3600;
        $payload = [
            'iss' => $issuer,
            'aud' => $audience,
            'ist' => $issued_at,
            'exp' => $new_expTime,
            'data' => $decoded_token->data,
        ];

        $new_token = JWT::encode($payload, $secret_key, 'HS256');
        setcookie('access_token', $new_token, $new_expTime, '/', "", false, true);

        echo json_encode(['success' => true]);
        exit; // Ensure no extra output

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Token not found in cookie']);
    exit;
}
