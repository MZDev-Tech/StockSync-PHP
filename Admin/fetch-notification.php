<?php
include("../connection.php");
// Function to convert timestamp to "time ago" format
function timeAgo($timestamp)
{
    $time = strtotime($timestamp);
    $diff = time() - $time;
    if ($diff < 5) return "just now";
    if ($diff < 60) return $diff . " s ago";
    if ($diff < 3600) return floor($diff / 60) . "m ago";
    if ($diff < 86400) return floor($diff / 3600) . "h ago";
    return floor($diff / 86400) . "d ago";
}

// Fetch unread notifications
$query = "SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC LIMIT 5";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="list-group">
                <a href="#" class="list-item-notify">
                    <div class="row g-0 align-items-center">
                        <div class="notify-img">
                            <img src="../Images/' . $row['image'] . '" alt="">
                        </div>
                        <div class="col-10">
                            <div class="title" style="font-size: 14px; color: #736f6f;">' . $row['title'] . '</div>
                            <div class="text-muted">' . $row['message'] . '</div>
                            <div class="text-muted time-notify">' . timeAgo($row['created_at']) . '</div>
                        </div>
                    </div>
                </a>
            </div>';
    }
} else {
    echo "
    <div style='display:flex;  gap:8px;padding:22px 8px 10px 20px;'>
    <img src='../Images/no-notify.gif' style='width:35px; height:35px'>
    <p style='color: #6c757d; font-size:13px; '>No new notifications available at the moment ...</p>
    </div>";
}
