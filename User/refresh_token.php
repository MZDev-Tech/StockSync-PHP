<?php
session_name("USER_SESSION");
session_start();
require '../connection.php';
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
// file to not allow user to directly access admin panel until they are login
include('Check_token.php');

$secret_key = "Zaviyan88$&90";
$issuer = "http://localhost";
$audience = "http://localhost";
$issued_at = time();

// Check if the access token is available
if (isset($_COOKIE['user_access_token'])) {
    $token = $_COOKIE['user_access_token'];
    try {
        //decode the token
        $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));
        //update user status to active when token refresh
        $user_id = $decoded_token->data->id;
        $role = 'user';
        $query = "UPDATE user SET status='active' WHERE id='$user_id' && role='$role'";
        mysqli_query($con, $query);
        // Generate a new expiration time (1 hour)
        $new_expTime = time() + 3600;
        // Create a new JWT payload with the updated expiration time
        $payload = [
            'iss' => $issuer,
            'aud' => $audience,
            'ist' => $issued_at,
            'exp' => $new_expTime,
            'data' => $decoded_token->data, //keep same user data
        ];

        //encode the new jwt token
        $new_token = JWT::encode($payload, $secret_key, 'HS256');
        setcookie('user_access_token', $new_token, time() + 3600, '/', "", false, true);
        //return success response
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Token not found in cookie']);
}
