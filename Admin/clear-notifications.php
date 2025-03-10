<?php
include('../connection.php');
$query = "UPDATE notifications SET status = 'read' WHERE status = 'unread'";
$result = mysqli_query($con, $query);

if ($result) {
    echo "success";
} else {
    echo "error";
}
