<?php
session_name("USER_SESSION");
session_start();
require 'vendor/autoload.php';
include('connection.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "Zaviyan88$&90";
$issuer = "http://localhost";
$audience = "http://localhost";
$issued_at = time();
$expiration_time = $issued_at + 3600;

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "select * from user where email='$email' && password='$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $query1 = "UPDATE user SET status='active' WHERE id= '" . $row['id'] . "' ";
        $result1 = mysqli_query($con, $query1);

        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];

        //generate JWT
        $payload = [
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "data" => [
                "id" => $row['id'],
                "name" => $row['name'],
                'email' => $row['email'],
            ]
        ];

        //encode JWT
        $jwt = JWT::encode($payload, $secret_key, 'HS256');
        //set JWT in cookies only
        setcookie("user_access_token", $jwt, time() + 3600, "/", "", false, true);


        // Code to store user data in cookies
        if (isset($_POST['remember_me'])) {
            setcookie('email', $_POST['email'], time() + 60 * 60 * 24);
            setcookie('password', $_POST['password'], time() + 60 * 60 * 24);
        } else {
            setcookie('email', '', time() - 3600);
            setcookie('password', '', time() - 3600);
        }

        $_SESSION['message'] = 'User login successfully..';
        header('Location:User/Dashboard.php');
        exit();
    } else {
        $_SESSION['message'] = 'Invalid Crendientials..';
        header('Location:user-login.php');
        exit();
    }
}

// Code to check if cookies data is stored or not
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
    <title>user login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/user-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alertMessage').fadeOut('slow')
            }, 2000)
        })
    </script>

</head>

<body>
    <div class="login-gradient1"></div>
    <!-- <div class="login-gradient2"></div> -->

    <div class="login-header">
        <img src="Images/loginGif.gif" alt="">
        <div class="headerContent">
            <h3 class="admin-heading">Stocksync</h3>
            <p>Inventory & file management System</p>
        </div>
    </div>
    <div class="user-loginParent">
        <div class="container user-subpart">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="Images/bg11.svg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 Userdata-part">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4 bg-radius">
                                <h3> User Sign In! </h3>

                                <p class="mb-4" style="text-transform:none">Welcome back! Sign in to access your account
                                    and manage your preferences seamlessly.</p>

                            </div>
                            <!-----------alert message------------->
                            <?php if (isset($_SESSION['message'])) { ?>
                                <div class="alert alert-warning data-dismissible fade show" id="alertMessage"
                                    style="margin:0 -15px 12px -15px">
                                    <strong>Warning! </strong>
                                    <?php echo $_SESSION['message'] ?>
                                    <button type="button" data-dismiss="alert" class="close" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            <?php unset($_SESSION['message']);
                            } ?>

                            <form action="" method="POST">
                                <div class="form-group first">
                                    <label for="username">Email ID</label>
                                    <input type="text" name="email" class="form-control"
                                        value="<?php echo $cookie_email ?>" placeholder="Enter email" id="username"
                                        required>

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        value="<?php echo $cookie_password ?>" placeholder="Enter password"
                                        id="password" required>

                                </div>

                                <div class="remember mb-4">
                                    <input type="checkbox" name="remember_me" class="py-4 ml-2" autocomplete="off">
                                    <span style="font-size:15px; color:#595959">Remember Me</span>
                                </div>

                                <input type="submit" name="submit" value="Submit" class="btn text-white btn-block btn-info">



                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>

</html>