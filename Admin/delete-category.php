<?php
session_name("ADMIN_SESSION");
session_start();
include "../connection.php";

// Get the delete ID from the URL
$Id = $_GET['id'];

// Perform deletion
$query = "DELETE FROM category WHERE id = '$Id'";
$msg = mysqli_query($con, $query);

// If deletion is successful
if ($msg) {
	// Check if a search term is set in the URL
	$search = isset($_GET['search']) ? $_GET['search'] : '';

	// If a search query is present, we modify the query accordingly
	$searchQuery = mysqli_real_escape_string($con, $search);

	// Query to count the remaining records after deletion
	$total_query = "SELECT COUNT(*) as total FROM category WHERE name LIKE '%$searchQuery%' OR detail LIKE '%$searchQuery%'";
	$result_count = mysqli_query($con, $total_query);
	$row_count = mysqli_fetch_assoc($result_count);
	$total_records = $row_count['total'];

	// Calculate the total pages
	$limit = isset($_GET['select-record']) ? (int)$_GET['select-record'] : 3;
	$total_pages = ceil($total_records / $limit);

	// Redirect accordingly
	if ($total_records == 0) {
		// If no records are left, redirect to the first page
		header("Location: View-category.php?page=1&select-record=$limit&search=$search");
		exit();
	} else {
		// If there are records left, redirect to the current page or the previous one
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		if ($page > $total_pages) {
			// If the current page is greater than the total pages, redirect to the last page
			$page = $total_pages;
		}
		header("Location: View-category.php?page=$page&select-record=$limit&search=$search");
		exit();
	}
} else {
	echo "Error deleting record";
}
