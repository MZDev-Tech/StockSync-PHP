<?php

if (session_status() === PHP_SESSION_NONE) {
    session_name("USER_SESSION");
    session_start();
}
include('../connection.php');
include('../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// file to not allow user to directly access admin panel until they are login
include('Check_token.php');

// Code to verify JWT token generated after admin login
$secret_key = "Zaviyan88$&90";
$show_refreshToken = false; // Initialize the variable

if (isset($_COOKIE["user_access_token"])) {
    $token = $_COOKIE['user_access_token'];

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
            $role = 'user';
            $query = "UPDATE user SET status='inactive' where id='$id' && role='$role'";
            mysqli_query($con, $query);
            session_destroy();
            setcookie('user_access_token', time() - 3600, "/");

            $_SESSION['message'] = 'Session expired. Please log in again.';
            header('Location:../user-login.php');
            exit();
        }
    } catch (Exception $e) {
        // Token is invalid or expired
        $_SESSION['message'] = 'Session expired. Please log in again.';
        header('Location:../user-login.php');
        exit();
    }
} else {
    // No token found in cookies
    $_SESSION['message'] = "Unauthorized access. Please log in first.";
    header('Location:../user-login.php');
    exit();
}
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

        <div class="header-icons">
            <button id="refreshTokenBtn" class="btn token-btn btn-sm">Refresh Token</button>
            <div class="icon1">
                <i class="fas fa-bars" id="menuIcon"></i>
            </div>

            <?php

            include('../connection.php');
            $id = $_SESSION['id'];
            $role = "user";
            $query = "SELECT * FROM user WHERE id='$id' && role='$role'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="admin">
                    <a href="User-profile.php">
                        <img src="../Images/<?php echo $row['image']; ?>" alt="Profile Img">
                        <div class="bg-wrapper1">
                            <span></span>
                        </div>
                    </a>
                </div>
            <?php } ?>


        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('header-part');
            const menuIcon = document.getElementById('menuIcon');
            let isMenuActive = false;

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
                // Send AJAX request to refresh token
                $.ajax({
                    type: 'POST',
                    url: 'refresh_token.php',
                    success: function(response) {
                        console.log("Response from server:", response); // Log the response
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
    </script>

    <!-- External JS File Link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>