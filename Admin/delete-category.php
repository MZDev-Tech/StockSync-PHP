<?php
session_name("ADMIN_SESSION");
session_start();
include "../connection.php";

$Id = $_GET['id'] ?? null;
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = $_GET['select-record'] ?? 3;

if ($Id) {
	$query = "DELETE FROM category WHERE id = '$Id'";
	$msg = mysqli_query($con, $query);

	if ($msg) {
		// Count remaining records
		$searchQuery = mysqli_real_escape_string($con, $search);
		$total_query = "SELECT COUNT(*) as total FROM category WHERE name LIKE '%$searchQuery%' OR detail LIKE '%$searchQuery%'";
		$result_count = mysqli_query($con, $total_query);
		$row_count = mysqli_fetch_assoc($result_count);
		$total_records = $row_count['total'];
		$total_pages = ceil($total_records / $limit);

		// Adjust page if needed
		if ($page > $total_pages && $total_pages > 0) {
			$page = $total_pages;
		} elseif ($total_pages == 0) {
			$page = 1;
		}

		echo json_encode([
			'status' => 'success',
			'redirectPage' => $page
		]);
		exit;
	} else {
		echo json_encode(['status' => 'error', 'message' => 'Deletion failed']);
		exit;
	}
} else {
	echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
	exit;
}
