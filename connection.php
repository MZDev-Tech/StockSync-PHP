<?php
$server="localhost";
$db="inventory-system";
$username="root";
$password="maria@10";
$con=mysqli_connect($server,$username,$password,$db);
if(!$con){
    die('connection failed'. mysqli_connect_error());
}


?>