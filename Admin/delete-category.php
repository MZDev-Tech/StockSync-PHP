<?php 
session_start();
include "../connection.php";
$Id=$_GET['id'];
$query="delete from category where id='$Id'";
$msg= mysqli_query($con, $query);
if($msg)
{
	echo "success";
}
else
{
	echo "error";
}

