<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = $_SESSION['id'];
    $receiver_id = $_POST['receiver_id'];
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert message into database
    $query = "INSERT INTO messages (sender_id, receiver_id, message, created_at) 
              VALUES ('$sender_id', '$receiver_id', '$message', NOW())";

    if (mysqli_query($con, $query)) {
        echo "Message sent";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
