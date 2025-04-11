<?php
session_name("ADMIN_SESSION");
session_start();
include "../connection.php";
$Id = $_GET['id'] ?? null;
$search = $_GET['search'] ?? '';
$page = $_Get['page'] ?? 1;
$limit = $_GET['search-record'] ?? 3;
if ($Id) {
	$query = "delete from laptops where Id='$Id'";
	$msg = mysqli_query($con, $query);
	if ($msg) {
		$searchQueryData = mysqli_real_escape_string($con, $search);
		$total_query = "SELECT COUNT(*) as total FROM laptops WHERE category LIKE '%$searchQueryData%' OR brand LIKE '%$searchQueryData%' OR model LIKE '%$searchQueryData%' OR processor LIKE '%$searchQueryData%'OR RAM LIKE '%$searchQueryData%'OR storage LIKE '%$searchQueryData%' OR price LIKE '%$searchQueryData%'OR quantity LIKE '%$searchQueryData%'OR serialNumber LIKE '%$searchQueryData%'OR date LIKE '%$searchQueryData%'OR delivery_date LIKE '%$searchQueryData%'OR total_age LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR person_name LIKE '%$searchQueryData%' OR status LIKE '%$searchQueryData%'";
		$result_count = mysqli_query($con, $total_query);
		$row_count = mysqli_fetch_assoc($result_count);
		$total_records = $row_count['total'];

		$total_pages = ceil($total_records / $limit);
		if ($page > $total_pages && $total_pages > 0) {
			$page = $total_pages;
		} elseif ($total_pages === 0) {
			$page = 1;
		}
		echo json_encode(['status' => 'success', 'redirectPage' => $page]);
		exit();
	} else {
		echo json_encode(['status' => 'error', 'message' => 'Deletion Failed..']);
		exit();
	}
} else {
	echo json_encode(['status' => 'error', 'message' => 'Invalid Id']);
	exit();
}
