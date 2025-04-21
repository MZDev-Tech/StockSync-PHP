<?php
session_name("ADMIN_SESSION");
session_start();
include "../connection.php";

$Id = $_GET['id'] ?? null;
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = $_GET['select-record'] ?? 3;

if (!$Id) {
	echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
	exit;
}

// Dependency check
$dependencyDetails = [];

$result1 = mysqli_query($con, "SELECT COUNT(*) AS total FROM document_tracking WHERE to_user = '$Id'");
$row1 = mysqli_fetch_assoc($result1);
if ($row1['total'] > 0) {
	$dependencyDetails[] = "{$row1['total']} record in 'document_tracking'";
}

$result2 = mysqli_query($con, "SELECT COUNT(*) AS total FROM messages WHERE receiver_id = '$Id' OR sender_id = '$Id'");
$row2 = mysqli_fetch_assoc($result2);
if ($row2['total'] > 0) {
	$dependencyDetails[] = "{$row2['total']} record in 'messages'";
}

$result3 = mysqli_query($con, "SELECT COUNT(*) AS total FROM documents WHERE created_by = '$Id'");
$row3 = mysqli_fetch_assoc($result3);
if ($row3['total'] > 0) {
	$dependencyDetails[] = "{$row3['total']} record in 'documents'";
}

if (!empty($dependencyDetails)) {
	$dependencyMessage = "<ol style='text-align: left; padding-left: 80px; font-size: 15px; margin-top: 6px;'>";
	foreach ($dependencyDetails as $detail) {
		$dependencyMessage .= "<li style='list-style: inside; text-transform:none;'>$detail</li>";
	}
	$dependencyMessage .= "</ol>";
	echo json_encode([
		'status' => 'hasDependencies',
		'message' => $dependencyMessage
	]);
	exit;
}

// Delete user if no dependencies
$delete = mysqli_query($con, "DELETE FROM user WHERE id = '$Id'");
if (!$delete) {
	echo json_encode(['status' => 'error', 'message' => 'SQL Error: ' . mysqli_error($con)]);
	exit;
}

// Recalculate pagination
$searchQueryData = mysqli_real_escape_string($con, $search);
$total_query = "SELECT COUNT(*) as total FROM user WHERE role='user' AND (name LIKE '%$searchQueryData%' OR email LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR phone LIKE '%$searchQueryData%' OR address LIKE '%$searchQueryData%')";
$result_count = mysqli_query($con, $total_query);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $limit);

if ($page > $total_pages && $total_pages > 0) {
	$page = $total_pages;
} elseif ($total_pages == 0) {
	$page = 1;
}

header('Content-Type: application/json');
echo json_encode([
	'status' => 'success',
	'redirectPage' => $page
]);
exit;
