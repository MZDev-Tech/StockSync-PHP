<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (session_status() === PHP_SESSION_NONE) {
    session_name("ADMIN_SESSION");
    session_start();
}
include('../connection.php');
include('Check_token.php');


// Function to execute SQL query and return the count
function getCount($query)
{
    global $con;
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($con));
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Return the count (if null, return 0)
    return $total ?? 0;
}
$userId = $_SESSION['id'];
$incomingQuery = "WITH latestStatus AS (
                SELECT document_id, from_user, MAX(date) AS latest_date 
                FROM document_tracking WHERE to_user='$userId' 
                GROUP BY document_id, from_user
                ) 
                SELECT COUNT(*) AS total FROM document_tracking dt
                JOIN latestStatus ls ON dt.document_id=ls.document_id
                AND dt.from_user=ls.from_user AND dt.date=ls.latest_date
                WHERE status='release' AND to_user='$userId'";

$receivedQuery = "WITH latestStatus AS(
                SELECT document_id,from_user,MAX(date) AS latest_date 
                FROM document_tracking WHERE to_user= '$userId' 
                GROUP BY document_id, from_user
                ) 
                SELECT count(*) AS total_received FROM document_tracking dt
                JOIN latestStatus ls ON dt.document_id=ls.document_id
                AND dt.from_user=ls.from_user AND dt.date=ls.latest_date
                WHERE status='received' AND to_user='$userId'";

$outgoingQuery = "WITH latestStatus AS(
                SELECT document_id,to_user,MAX(date) AS latest_date 
                FROM document_tracking WHERE from_user= '$userId' 
                GROUP BY document_id, to_user
                ) 
                SELECT count(*) AS total_received FROM document_tracking dt
                JOIN latestStatus ls ON dt.document_id=ls.document_id
                AND dt.to_user=ls.to_user AND dt.date=ls.latest_date
                WHERE status='release' AND from_user='$userId'";


$onholdQuery = "WITH latestStatus AS(
                SELECT document_id,to_user,MAX(date) AS latest_date 
                FROM document_tracking WHERE from_user= '$userId' 
                GROUP BY document_id, to_user
                ) 
                SELECT count(*) AS total_received FROM document_tracking dt
                JOIN latestStatus ls ON dt.document_id=ls.document_id
                AND dt.to_user=ls.to_user AND dt.date=ls.latest_date
                WHERE status='onhold' AND from_user='$userId'";

$cancelledQuery = "WITH latestStatus AS(
                SELECT document_id,to_user,MAX(date) AS latest_date 
                FROM document_tracking WHERE from_user= '$userId' 
                GROUP BY document_id, to_user
                ) 
                SELECT count(*) AS total_received FROM document_tracking dt
                JOIN latestStatus ls ON dt.document_id=ls.document_id
                AND dt.to_user=ls.to_user AND dt.date=ls.latest_date
                WHERE status='cancel' AND from_user='$userId'";

$completeQuery = "SELECT count(*) AS total_received FROM document_tracking dt WHERE status='complete' ";

$allFilesQuery = "SELECT COUNT(*) as total from documents";

// Store counts in an array
$counts = [
    'incoming' => getCount($incomingQuery),
    'received' => getCount($receivedQuery),
    'outgoing' => getCount($outgoingQuery),
    'onhold' => getCount($onholdQuery),
    'complete' => getCount($completeQuery),
    'cancelled' => getCount($cancelledQuery),
    'all' => getCount($allFilesQuery)
];
// echo json_encode($counts);
