<!-- code to not allow admin to directly access admin panel until they are login -->
<?php
session_start();
include '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!isset($_SESSION['id']) && empty($_SESSION['id'])) {
    header('Location:../admin-login.php');
    exit();
}

//code to verify jwt token
$secret_key = "Zarnat12$&10";
if (isset($_COOKIE['access_token'])) {
    $token = $_COOKIE['access_token'];
    try {
        $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));
        $admin_id = $decoded_token->data->id;
        $admin_name = $decoded_token->data->name;
        $admin_email = $decoded_token->data->email;
        if (isset($decoded_token->iat)) {
            $login_time = date('Y-m-d H:i:s', $decoded_token->iat);
        } else {
            $login_time = 'Unknown';
        }


    } catch (Exception $e) {
        // Token is invalid or expired
        $_SESSION['message'] = 'Session expired. Please log in again.';
        header('Location:../admin-login.php');
        exit();
    }
} else {
    // No token found in cookies
    $_SESSION['message'] = "Unauthorized access.";
    header('Location:../admin-login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#alertMessage').fadeOut('slow');
            }, 2000);
        });
    </script>
    <style>
        label{
            font-size: 14px !important;
            color: #131313d8;
        }

        input {
            font-size: 13px !important;
            text-transform: none !important;
            transition: .3s all ease;
            padding: 18px 0 18px 8px;
        }

        input:hover {
            padding-left: 12px!important;
        }
        
    </style>
</head>

<body>


    <!-----------SideBar Section------------------->
    <?php include('sidebar.php'); ?>


    <!----------------Main Header Section--------------------->
    <section id="main-page">

        <?php include('Header.php'); ?>



        <!----------------Main Page Design--------------------->
        <main id="page-content">

            <div class="col-lg-12 mb-6 page-name">
                <h2>Admin Data</h2>
                <h5>Home / Profile</h5>
            </div>

            <!---------------Admin Record Table ------------------------->
            <div class="row" style="margin:10px 25px">
                <div class="col-12 bg-white">
                    <div class="d-flex justify-content-between align-items-center py-3 top-recordParent">
                        <div class="d-flex align-items-center top-recordPart">
                            <i class="fa-solid fa-tablet-screen-button"></i>
                            <div>
                                <h2 class="mb-1">Table Data</h2>
                                <p class="mb-0">Manage your records efficiently</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-----------alert message------------->
            <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:10px 25px">
                <strong>Admin! </strong>
                <?php echo $_SESSION['message'] ?>
                <button type="button" data-dismiss="alert" class="close" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <?php unset($_SESSION['message']);
            } ?>

            <?php
            include('../connection.php');
            $query = "select * from admin where id=?";
            $stmt = mysqli_prepare($con, $query);
            //bind parameters
            mysqli_stmt_bind_param($stmt, 'i', $admin_id);
            //excute query
            mysqli_stmt_execute($stmt);
            //get result
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_array($result)) {
                ?>

            <div class="adminprofile-part" style="margin-left:20px; margin-right:30px">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-lg-4 pb-3 adminprofile-part1">
                            <!-- Admin profile Sidebar-->
                                <div class="admin-card pb-3">
                                    <div class="admin-card-cover"
                                        style="background-image: url(https://picsum.photos/400/300);">
                                        <a class="btn btn-style-1 btn-white btn-sm" href="#" data-toggle="tooltip" title=""
                                            data-original-title="You currently have 290 Reward points to spend"><i
                                                class="fa fa-award text-md"></i>&nbsp;active</a>
                                    </div>
                                    <div class="admin-card-profile">
                                        <div class="admin-card-avatar"><img src="../Images/<?php echo $row['image'] ?>"
                                                alt="img">
                                        </div>
                                        <div class="admin-card-details">
                                            <h5 class="admin-card-name text-lg"><?php echo $row['name'] ?></h5><span
                                                class="admin-card-position">Login: <?php echo $login_time ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-sidebar">
                                    <ul class="list-group">
                                        <div class="list-group-item profile-sidebar-item" data-target="profileInfo">
                                            <li>Profile setting</li>
                                        </div>
                                        <div class="list-group-item profile-sidebar-item" data-target="updateProfile">
                                            <li>Update Profile</li>
                                        </div>

                                        <div class="list-group-item profile-sidebar-item" data-target="profileLogout">
                                            <li>Logout</li>
                                        </div>
                                    </ul>
                                </div>


                            </div>
                            <!-- Profile Settings-->
                            <div class="col-lg-8 pb-4 adminprofile-part2">
                                <div class="profile-section" id="profileInfo">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h4>Profile Information</h4>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0"><span class="las la-sort"> </span> Full Name</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary text-data">
                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0"><span class="las la-sort"> </span> Email ID</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary text-data">
                                                    <?php echo htmlspecialchars($row['email']); ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0"><span class="las la-sort"> </span> Authority</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary text-data">Admin
                                                </div>
                                            </div>
                                            <hr>


                                            <a href="update-profile.php" class="btn btn-info" style="font-size:14px">Update
                                                Data</a>


                                        </div>
                                    </div>
                                </div>

                                <!-- Update profile section -->
                                <div class="profile-section" id="updateProfile"
                                    style="display: none; background:#fff; padding: 18px 24px;">
                                    <form method="POST" action="update-profile.php" enctype="multipart/form-data">
                                        <h4>Update Admin Profile</h4>
                                        <div class="row" style="align-items:center">
                                            <div class="form-group">
                                                <input type="hidden" name="id" class="form-control"
                                                    value="<?php echo $row['id']; ?>">
                                            </div>

                                            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                                <label style="color:black">Full Name</label>

                                                <input type="text" name="name" class="form-control"
                                                    value="<?php echo $row['name']; ?>" required>
                                            </div>


                                            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                                <label style="color:black">Email ID</label>

                                                <input type="text" name="email" class="form-control"
                                                    value="<?php echo $row['email']; ?>" required>
                                            </div>

                                        </div>
                                        <div class="row" style="align-items:center">

                                            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                                <label style="color:black">Password</label>

                                                <input type="text" name="password" class="form-control"
                                                    placeholder="Enter new password (optional)">
                                            </div>



                                        <?php } ?>
                                        <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                            <label>Upload Image</label><br>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-info">Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- profile logout section -->
                            <div id="profileLogout" class="profile-section" style="display: none;">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4>Logout from Admin panel</h4>
                                        <p>Click below to log out.</p>
                                        <a href="logout.php" class="btn btn-danger">Logout</a>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>


        </main>

    </section>

    <script src="script.js"></script>
    <script>
        document.querySelectorAll('input').forEach(field => {
            if (field.value.trim() !== '') {
                field.classList.add('has-value');
            }

            field.addEventListener('input', () => {
                if (field.value.trim() !== '') {
                    field.classList.add('has-value');
                } else {
                    filed.classList.remove('has-value');
                }
            })
        });



    </script>
</body>

</html>