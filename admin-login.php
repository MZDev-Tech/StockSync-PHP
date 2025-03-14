<?php
session_name("ADMIN_SESSION");
session_start();
require 'vendor/autoload.php';
include('connection.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "Zarnat12$&10";
$issuer = "http://localhost";
$audience = "http://localhost";
$issued_at = time();
$expiration_time = $issued_at + 3600;


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "select * from user where email='$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        // Check if the user is an admin
        if ($row['role'] === 'admin') {
            $hashed_password = $row['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];

                //update admin status to active when login
                $id = $row['id'];
                $query1 = "update user set status='active' where id ='$id'";
                mysqli_query($con, $query1);
                // Generate JWT
                $payload = [
                    "iss" => $issuer,
                    "aud" => $audience,
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "data" => [
                        "id" => $row['id'],
                        "name" => $row['name'],
                        'email' => $row['email'],
                        'role' => $row['role']
                    ]
                ];

                // Encode JWT
                $jwt = JWT::encode($payload, $secret_key, 'HS256');

                // Set JWT in cookies
                setcookie("access_token", $jwt, time() + 3600, "/", "", false, true);

                // Store admin data in cookies if "Remember Me" is checked
                if (isset($_POST['remember_me'])) {
                    setcookie('email', $_POST['email'], time() + 60 * 60 * 24);
                    setcookie('password', $_POST['password'], time() + 60 * 60 * 24);
                } else {
                    setcookie('email', '', time() - 3600);
                    setcookie('password', '', time() - 3600);
                }

                $_SESSION['message'] = 'Admin login successfully..';
                header('Location:Admin/Dashboard.php');
                exit();
            } else {
                $_SESSION['message'] = 'Invalid Password..';
                header('Location:admin-login.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'Access denied. You are not an admin.';
            header('Location:admin-login.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'User not found..';
        header('Location:admin-login.php');
        exit();
    }
}

// Check if cookies data is stored
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $cookie_email = $_COOKIE['email'];
    $cookie_password = $_COOKIE['password'];
} else {
    $cookie_email = "";
    $cookie_password = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/adminLogin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alertMessage').fadeOut('slow')
            }, 2000)
        })
    </script>
</head>

<body>

    <div class="tp-headerbggradient"></div>
    <div id="admin-loginForm">


        <div class="login-parent container">
            <div class="login-formwrap">

                <div class="admin-top">
                    <img src="Images/adminIcon.gif" alt="">
                    <div class="headerContent">
                        <h3 class="admin-heading">Stocksync</h3>
                        <p>Inventory & file management System</p>
                    </div>
                </div>
                <h4 class="sub-heading">Please enter your admin credentials. </h4>


                <!-----------alert message------------->
                <?php if (isset($_SESSION['message'])) { ?>
                    <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:0 -10px 12px -10px">
                        <strong>Warning! </strong>
                        <?php echo $_SESSION['message'] ?>
                        <button type="button" data-dismiss="alert" class="close" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                <?php unset($_SESSION['message']);
                } ?>


                <form method="POST" action="">

                    <div class="form-group mb-3 field-group">
                        <label>Enter Email ID</label>
                        <div class="input-part">
                            <span> <i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" placeholder="Email" style="text-transform:none"
                                class="form-control " value="<?php echo $cookie_email ?>" autocapitalize="none"
                                required>
                        </div>
                    </div>

                    <div class="form-group mb-4 field-group">
                        <label>Enter Password</label>
                        <div class="input-part">
                            <span><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" style="text-transform:none" placeholder="Password"
                                id="passwordInput" value="<?php echo $cookie_password ?>" class="form-control "
                                autocapitalize="none" required>
                            <i class="fas fa-eye-slash input-icon" id="eyeIcon"></i>
                        </div>
                    </div>

                    <div class="remember">
                        <input type="checkbox" name="remember_me" class="py-4 ml-2" autocomplete="off">
                        <span style="font-size:15px; color:#595959">Remember Me</span>
                    </div>


                    <div class="form-group mb-4">
                        <input type="submit" name="submit" class="btn text-white btn-block btn-info" value="Login">
                    </div>

                    <div class=" user-login">
                        <p style="font-style:italic;">Need to access a <a href="user-login.php">User account?</a></p>

                    </div>

                </form>
            </div>
            <div class="admin-footer">
                <p>© 2025 PTPL Powered by MZDev-Tech</p>
            </div>


        </div>
    </div>

    <script>
        let EyeIcon = document.getElementById('eyeIcon');
        let password = document.getElementById('passwordInput');

        EyeIcon.addEventListener('click', () => {
            if (password.type === 'password') {
                password.type = "text";
                EyeIcon.classList.remove('fa-eye-slash');
                EyeIcon.classList.add('fa-eye');
            } else {
                password.type = "password";
                EyeIcon.classList.remove('fa-eye');
                EyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>

</html>