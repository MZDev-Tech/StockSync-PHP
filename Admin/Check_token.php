<?php
ob_start(); // Start output buffering

include '../vendor/autoload.php';
include('../connection.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "Zarnat12$&10";

// Check if the access token is available in cookies
if (isset($_COOKIE['access_token'])) {
    $token = $_COOKIE['access_token'];

    try {
        // Decode & verify the token
        $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));

        // Get expiration time for the token
        $expiration_time = $decoded_token->exp;

        // If the token has expired, redirect to the login page
        if ($expiration_time < time()) {
            // Token expired, clear cookies and session, and redirect
            setcookie('access_token', '', time() - 3600, "/"); 
            session_destroy();
            $_SESSION['message'] = 'Session expired. Please log in again.';
            header('Location: ../admin-login.php');
            exit();
        }

    } catch (Exception $e) {
        // Token is invalid or expired
        $_SESSION['message'] = 'Session expired. Please log in again.';
        header('Location: ../admin-login.php');
        exit();
    }
} else {
    // No token found in cookies
    $_SESSION['message'] = "Unauthorized access. Please log in first.";
    header('Location: ../admin-login.php');
    exit();
}

// Flush the output buffer
ob_end_flush();
?>
