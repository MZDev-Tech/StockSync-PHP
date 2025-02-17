<?php
session_name("USER_SESSION");
session_start();
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $document_id = mysqli_real_escape_string($con, $_POST['document_id']);
    $from_user = mysqli_real_escape_string($con, $_POST['from_user']);
    $to_user = mysqli_real_escape_string($con, $_POST['to_user']);
    $status = mysqli_real_escape_string($con, $_POST['action_type']);
    $remark = mysqli_real_escape_string($con, $_POST['remark']);
    $filename = mysqli_real_escape_string($con, $_POST['filename']);
    // Insert new record to keep history
    $query = "INSERT INTO document_tracking (document_id,document_name, from_user, to_user, status, remark, date) 
              VALUES (?, ?,?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'isiiss', $document_id, $filename, $from_user, $to_user, $status, $remark);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
