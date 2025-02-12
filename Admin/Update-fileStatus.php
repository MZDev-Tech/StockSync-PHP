<?php
session_start();
include('../connection.php');
// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');



// code to check if admin has submit data
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $status = mysqli_real_escape_string($con, $_POST['action_type']);
    $remark = mysqli_real_escape_string($con, $_POST['remark']);

    $query = "update document_tracking set status=?,remark=?, date=NOW() where id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $status,$remark, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    mysqli_stmt_close($stmt);
}else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

?>