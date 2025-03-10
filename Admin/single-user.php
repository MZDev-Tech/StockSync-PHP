<?php
session_name("ADMIN_SESSION");
session_start();
// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single User Profile</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">


    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alertMessage').fadeOut('slow');
            }, 2000);
        });
    </script>
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
                <h2>User Data</h2>
                <h5>Home / Profile</h5>
            </div>
            <!-----------alert message------------->
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:10px 25px">
                    <strong>User! </strong>
                    <?php echo $_SESSION['message'] ?>
                    <button type="button" data-dismiss="alert" class="close" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            <?php unset($_SESSION['message']);
            } ?>
            <!---------------Admin Record Table ------------------------->
            <div class="row" style="margin:10px 25px">
                <div class="col-12 bg-white">
                    <div class="d-flex justify-content-between align-items-center py-3 top-recordParent">
                        <div class="d-flex align-items-center top-recordPart">
                            <i class="fa-solid fa-tablet-screen-button"></i>
                            <div>
                                <h2 class="mb-1">User Data</h2>
                                <p class="mb-0">Manage your records efficiently</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?php
            include('../connection.php');
            $id = $_GET['id'];

            $query = "select * from user where id=?";
            $stmt = mysqli_prepare($con, $query);
            //bind parameters
            mysqli_stmt_bind_param($stmt, 'i', $id);
            //excute query
            mysqli_stmt_execute($stmt);
            //get result
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="profile-records" style="margin: 30px 28px 20px 28px;">
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <?php if (!empty($row['image']) && file_exists($row['image'])) {
                                            echo '<img src="../Images/' . $row['image'] . '" alt="userImg"  class="rounded-circle" width="150" height="150">';
                                        } else {

                                            echo "<img src='../Images/imgdefault.jpg'  class='rounded-circle' width='150' height='150'>";
                                        } ?>

                                        <div class="mt-3">

                                            <h4>
                                                <?php echo htmlspecialchars($row['name']); ?>
                                            </h4>
                                            <p class="text-secondary mb-1"><?php echo htmlspecialchars($row['designation']) ?></p>
                                            <p class="text-muted font-size-sm" style="text-transform:none">
                                                <?php echo htmlspecialchars($row['email']); ?>
                                            </p>
                                            <a href="update-user.php?id=<?php echo $row['id'] ?>" class="btn btn-info" style="font-size:14px">Update</a>
                                            <a href="View-user.php" class="btn btn-outline-info" style="font-size:14px">Go Back</a>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
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
                                            <h6 class="mb-0"><span class="las la-sort"> </span> Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary text-data">
                                            <?php echo htmlspecialchars($row['email']); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"><span class="las la-sort"> </span> Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary text-data">+92<?php echo htmlspecialchars($row['phone']); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">

                                            <h6 class="mb-0"><span class="las la-sort"> </span> Designation</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary text-data">
                                            <?php echo htmlspecialchars($row['designation']); ?>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"><span class="las la-sort"> </span> Address </h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary text-data">
                                            <?php echo htmlspecialchars($row['address']); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"><span class="las la-sort"> </span> Status </h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary text-data status">
                                            <span>
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </span>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        <?php } ?>

                        </div>

        </main>

    </section>
    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>