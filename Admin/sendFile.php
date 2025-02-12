<?php
session_start();
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $document_id = mysqli_real_escape_string($con,  $_POST['document_id']);
    $sender =  mysqli_real_escape_string($con, $_POST['sender']);
    $filename =  mysqli_real_escape_string($con, $_POST['filename']);
    $receiver =  mysqli_real_escape_string($con, $_POST['receiver']);
    $remarks =  mysqli_real_escape_string($con, $_POST['remarks']);
    $action_type =  mysqli_real_escape_string($con, $_POST['action_type']);


    // Insert into document_tracking table
    $query = "INSERT INTO document_tracking (document_id,document_name, from_user, to_user, remark,status,date)
              VALUES (?, ?, ?, ?, ?, ?,NOW())";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'isisss', $document_id,$filename, $sender, $receiver, $remarks, $action_type);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
