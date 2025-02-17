<?php
session_name("USER_SESSION");
session_start();
include "../connection.php";
$Id = $_GET['id'];
$query = "delete from laptops where Id='$Id'";
$msg = mysqli_query($con, $query);
if ($msg) {
	echo 'success';
} else {
	echo 'error';
}
