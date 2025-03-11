<?php
// Enable output buffering
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_name("ADMIN_SESSION");
    session_start();
}

include '../vendor/autoload.php';
include('../connection.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Code to verify JWT token generated after admin login
$secret_key = "Zarnat12$&10";
$show_refreshToken = false; // Initialize the variable

if (isset($_COOKIE["access_token"])) {
    $token = $_COOKIE['access_token'];

    try {
        // Decode & verify the token
        $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));

        // Get expiration time for the token
        $expiration_time = $decoded_token->exp;

        // Check if the token is about to expire (within 10 minutes)
        if ($expiration_time - time() <= 600) {
            $show_refreshToken = true;
        }
        if ($expiration_time < time()) {
            $id = $_SESSION['id'];
            $role = 'admin';
            $query = "UPDATE user SET status='inactive' where id='$id' && role='$role'";
            mysqli_query($con, $query);
            session_destroy();
            setcookie('access_token', time() - 3600, "/");

            $_SESSION['message'] = 'Session expired. Please log in again.';
            header('Location:../admin-login.php');
            exit();
        }
    } catch (Exception $e) {
        // Token is invalid or expired
        $_SESSION['message'] = 'Session expired. Please log in again.';
        header('Location:../admin-login.php');
        exit();
    }
} else {
    // No token found in cookies
    $_SESSION['message'] = "Unauthorized access. Please log in first.";
    header('Location:../admin-login.php');
    exit();
}

// Flush the output buffer
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">


</head>

<body>
    <!----------------Header Section--------------------->
    <header id="header-part">
        <div class="dashboard">
            <form method="POST" action="">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="search" name="search" style="border:none" placeholder="Search here..">
                </div>
            </form>
        </div>
        <div class="d-flex align-items-center">
            <div class="icon1 nav-menu">
                <!-- <img src="../images/menu.gif" id="menuIcon" style="width:30px; height:30px; margin-right:8px;"> -->
                <i class="fas fa-bars" id="menuIcon1"></i>
            </div>
            <div class="icon1">
                <img src="../images/arrowDown.gif" id="subNavIcon">
            </div>
        </div>

        <div class="sub-navbar" id="subNavbar">
            <div class="header-icons">

                <button id="refreshTokenBtn" class="btn token-btn btn-sm">Refresh Token</button>
                <div class="icon1 menuBar">
                    <i class="fas fa-bars" id="menuIcon"></i>
                </div>

                <div class="icon1 messIcon">
                    <i class="fa-solid fa-envelope" id="messageIcon"></i>
                    <div class="bg-wrapper">
                        <span class="notification">1</span>
                    </div>
                    <!-- Message dropdown -->
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 message-dropdown" id="MessageMenu" aria-labelledby="alertsDropdown" data-bs-popper="static">
                        <div class="dropdown-menu-header1">
                            <span style="font-size:18px;color:rgba(65, 64, 64, 0.96)"> <img src="../images/chat.png" style="width:30px; height:30px; margin-right:10px;">User Messages</span>
                            <span class="count-message">5 new</span>
                        </div>
                        <ul class="list-group1">
                            <li class="message-li">
                                <a href="#" class="list-group-item1">
                                    <div class="row g-0 align-items-center">
                                        <div class="notify-img">
                                            <img src="../Images/7.jpg" alt="">
                                        </div>
                                        <div class="col-10">
                                            <div style="font-size: 14px; color:rgb(58, 57, 57);">Ali Ahmand</div>
                                            <div class="text-muted">Send you a new message</div>
                                        </div>
                                        <span class="time">3m ago</span>

                                    </div>
                                </a>
                            </li>

                            <li class="message-li">
                                <a href="#" class="list-group-item1">
                                    <div class="row g-0 align-items-center">
                                        <div class="notify-img">
                                            <img src="../Images/7.jpg" alt="">
                                        </div>
                                        <div class="col-10" style="display:inline-block">
                                            <div style="font-size: 14px; color:rgb(58, 57, 57);">Update completed</div>
                                            <div class="text-muted">Send you a new message.</div>
                                        </div>
                                        <span class="time">2h ago</span>
                                    </div>
                                </a>
                            </li>

                        </ul>
                        <div class="dropdown-menu-footer">
                            <a href="chats.php" class="footer-btn">View All Messages</a>
                        </div>
                    </div>
                </div>

                <div class="icon2 messIcon">
                    <i class="fa-solid fa-bell" id="notificationIcon"></i>
                    <div class="bg-wrapper wrapper1">
                        <?php
                        $query = "SELECT COUNT(*) as total from notifications where status='unread'";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        $totalunread = $row['total'];

                        ?>
                        <span class="notification"><?php echo $totalunread ?></span>
                    </div>
                    <!-- notification dropdown -->
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 notification-dropdown" id="notificationMenu" aria-labelledby="alertsDropdown" data-bs-popper="static">
                        <div class="dropdown-menu-header d-flex align-items-center justify-content-center g-10">
                            <img src="../Images/exclamation.png" width="25px" height="25px" style="margin-right:10px">
                            <span style="font-size:18px;color: #fbf9f9f5"> New Notifications</span>
                        </div>

                        <div id="notificationList">
                            <!-- Notifications will be loaded here using AJAX -->
                        </div>

                        <div class="dropdown-notify-footer" id="clearNotifications">
                            <a href="#" class="clear-notify">Clear All notifications</a>
                        </div>
                    </div>

                </div>




                <?php
                include('../connection.php');
                $query = "SELECT * FROM admin WHERE id='1'";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="admin">
                        <a href="admin-profile.php">
                            <?php if (!empty($row['image']) && file_exists('../Images/' . $row['image'])) {
                                echo '<img src="../Images/' . $row['image'] . '">';
                            } else {
                                echo '<img src="../Images/user-profile.jpg">';
                            } ?> <div class="bg-wrapper1">
                                <span></span>
                            </div>
                        </a>

                        <div class="header-dropdown">
                            <!-- Dropdown Container -->
                            <div class="dropdown">
                                <!-- Dots Icon (Dropdown Toggle) -->
                                <a href="#" class="dropdown-toggle no-btn" id="dotsDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-angle-down angleicon"></i>
                                </a>

                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu" aria-labelledby="dotsDropdown">
                                    <li>
                                        <a class="dropdown-item" href="Admin-profile.php">
                                            <i class="far fa-user"></i> Manage Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="update-profile.php">
                                            <i class="fas fa-unlock-alt"></i> Handle Password
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="confirmLogout(event)">
                                            <i class="fas fa-arrow-right-from-bracket"></i> Logout
                                        </a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>


    </header>


    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('header-part');
            const menuIcon = document.getElementById('menuIcon');
            let isMenuActive = false; // Track menu state

            // Toggle menu event
            menuIcon.addEventListener('click', () => {
                isMenuActive = !isMenuActive;
                adjustHeaderOnScroll();
            });

            // Scroll event listener
            window.addEventListener('scroll', adjustHeaderOnScroll);
            window.addEventListener('resize', adjustHeaderOnScroll); // Adjust on screen resize

            function adjustHeaderOnScroll() {
                const scrolled = window.scrollY > 10;
                const isSmallScreen = window.innerWidth <= 768; // Adjust threshold as needed

                if (isSmallScreen) {
                    // Small screen styles
                    header.style.borderRadius = '0';
                    header.style.top = '0';
                    header.style.borderBottom = '1px solid rgb(43, 144, 151)';
                    header.style.left = '0';
                    header.style.width = '100%';
                    header.style.position = 'fixed';
                    header.style.zIndex = '999';

                    if (isMenuActive) {
                        // Keep header fixed when sidebar is over it
                        header.style.left = '0';
                        header.style.width = '100%';
                    }
                } else {
                    // Large screen styles
                    if (scrolled) {
                        header.style.borderRadius = '0';
                        header.style.top = '0';
                        header.style.borderBottom = '1px solid rgb(43, 144, 151)';

                        if (isMenuActive) {
                            header.style.left = '0';
                            header.style.width = '100%';
                        } else {
                            header.style.left = '245px';
                            header.style.width = 'calc(100% - 245px)';
                        }
                    } else {
                        header.style.borderRadius = '4px';
                        header.style.top = '8px';
                        header.style.borderBottom = 'none';

                        if (isMenuActive) {
                            header.style.left = '40px';
                            header.style.width = 'calc(100% - 80px)';
                        } else {
                            header.style.left = '260px';
                            header.style.width = 'calc(100% - 280px)';
                        }
                    }
                }
            }

            adjustHeaderOnScroll(); // Apply styles on page load
        });

        // Pass token expiration details from PHP to JS
        const expirationTime = <?php echo isset($expiration_time) ? $expiration_time : 0; ?>;

        // Script to show if refresh token button needs to be shown
        window.addEventListener('DOMContentLoaded', () => {
            const refreshButton = document.getElementById('refreshTokenBtn');

            const checkTokenTime = () => {
                const currentTimeClientSide = Math.floor(Date.now() / 1000); // Convert to seconds
                const timeLeftClientSide = expirationTime - currentTimeClientSide;

                // 600 seconds = 10 minutes
                if (timeLeftClientSide <= 600 && timeLeftClientSide > 0) {
                    refreshButton.style.display = "inline-block";
                } else {
                    refreshButton.style.display = "none";
                }
            };

            checkTokenTime();
            // Check token remaining time every minute
            setInterval(checkTokenTime, 60000);

            // Refresh Token Button Script
            refreshButton.addEventListener('click', () => {
                $.ajax({
                    type: 'POST',
                    url: 'refresh_token.php',
                    success: function(response) {
                        console.log("refresh token Response from server:", response);
                        let res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire({
                                title: "Good job!",
                                text: "Token refreshed successfully!",
                                icon: "success"
                            }).then(() => {
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Error refreshing token.",
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Error refreshing token.",
                        });
                    }
                });
            });
        });

        //sweet alert for logout

        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancel",
                confirmButtonText: "Yes, Logout!",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
        }

        //script to show notification dropdown
        let notificationIcon = document.getElementById('notificationIcon');
        let dropdown = document.getElementById('notificationMenu');

        notificationIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            let isOpen = dropdown.classList.contains('show');

            document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));

            if (!isOpen) {
                dropdown.classList.add('show');
            } else {
                dropdown.classList.remove('show');
            }
        });

        // Close notification dropdown when clicking anywhere else
        document.addEventListener('click', () => {
            dropdown.classList.remove('show');
        });

        //script to show message dropdown
        let messageIcon = document.getElementById('messageIcon');
        let messageDropdown = document.getElementById('MessageMenu');
        messageIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            let messageOpen = messageDropdown.classList.contains('show');
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
            if (!messageOpen) {
                messageDropdown.classList.add('show');
            } else {
                messageDropdown.classList.remove('show');
            }
        });

        //show sub navbar in small screens
        document.getElementById("subNavIcon").addEventListener("click", function() {
            document.querySelector(".sub-navbar").classList.toggle("show");
        });

        $(document).ready(function() {
            function loadNotifications() {
                $.ajax({
                    url: 'fetch-notification.php',
                    type: 'GET',
                    success: function(data) {
                        $('#notificationList').html(data);
                        // Hide "Clear All Notifications" if no notifications exist
                        if ($("#notificationList").text().includes("No new notifications")) {
                            $('#clearNotifications').hide();
                        } else {
                            $('#clearNotifications').show();
                        }
                    }
                });
            }

            // Auto-refresh notifications every 10 seconds 1000ms=10s(bcz 1000ms =1s)
            setInterval(loadNotifications, 10000);
            loadNotifications();

            // Clear all notifications (Event Delegation Fix)
            $(document).on('click', '#clearNotifications', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'clear-notifications.php',
                    type: 'POST',
                    success: function(response) {
                        if (response.trim() === 'success') {
                            loadNotifications();
                        } else {
                            alert("Error clearing notifications.");
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>