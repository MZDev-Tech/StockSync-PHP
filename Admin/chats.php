<?php
session_name("ADMIN_SESSION");
session_start();
include '../connection.php';
// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Chats</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">

    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alertMessage').fadeOut('slow')
            }, 2000)
        })
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
                <h2>Chats</h2>
                <h5>Home / chat</h5>
            </div>


            <!---------------Admin Record Table ------------------------->

            <div class="row" style="margin:10px 25px">
                <div class="col-12 bg-white">
                    <div class="d-flex justify-content-between align-items-center py-3 top-recordParent">
                        <div class="d-flex align-items-center top-recordPart">
                            <i class="fa-solid fa-tablet-screen-button"></i>
                            <div>
                                <h2 class="mb-1">Chat Data</h2>
                                <p class="mb-0">Manage your records efficiently</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class=" chat-record">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="chat-card chat-app">
                            <div id="userList" class="people-list-sidebar">
                                <?php
                                include('../connection.php');
                                $id = $_SESSION['id'];
                                $role = 'admin';
                                $query = "select * from user where id='$id' && role='$role'";
                                $result = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <div class="usermain-data">
                                        <a href="admin-profile.php">
                                            <?php if (!empty($row['image']) && file_exists('../Images/' . $row['image'])) {
                                                echo '<img src="../Images/' . $row['image'] . '">';
                                            } else {
                                                echo '<img src="../Images/user-profile.jpg">';
                                            } ?>
                                            <div class="profile-data">
                                                <h5>
                                                    <?php echo $row['name']; ?>
                                                </h5>
                                                <span style="text-transform:none;"><?php echo $row['email']; ?> </span>
                                            </div>
                                        </a>

                                    <?php } ?>

                                    </div>

                                    <div class="input-group chat-search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        </div>
                                        <input type="text" id="searchUser" class=" form-control" placeholder="Search...">
                                    </div>

                                    <ul class="chat-ul chat-list ">
                                        <?php
                                        $id = $_SESSION['id'];
                                        $query1 = "SELECT * from user where id !='$id' && role='user' ";
                                        $result1 = mysqli_query($con, $query1);
                                        while ($row = mysqli_fetch_array($result1)) {
                                        ?>

                                            <li class="chat-user-list">
                                                <img src="../images/<?php echo $row['image'] ?>" alt="avatar">
                                                <div class="about">
                                                    <div class="name"><?php echo $row['name']; ?></div>
                                                    <div class="status">
                                                        <?php
                                                        if ($row['status'] === 'active') {
                                                            echo '<i class="fa fa-circle online"></i> Online';
                                                        } else {
                                                            echo '<i class="fa fa-circle offline"></i> Offline';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                            </li>

                                        <?php } ?>
                                    </ul>
                            </div>
                            <div class="chat-leftpart">
                                <div class="chat-header">
                                    <div>

                                        <div class="user-info ">
                                            <img src="../Images/menu-bar.png" alt="" class="chat-menu">


                                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                            <div class="chat-about">
                                                <h6 class="m-b-0">Aiden Chavez</h6>
                                                <small>Last seen: 2 hours ago</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="header-dots">
                                        <div class="dropdown">
                                            <!-- Dots Icon (Dropdown Toggle) -->
                                            <a href="#" class="dropdown-toggle no-btn" id="dotsDropdown"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>

                                            <!-- Dropdown Menu -->
                                            <ul class="dropdown-menu" aria-labelledby="dotsDropdown">

                                                <li>
                                                    <a class="dropdown-item" href="TrackRecord.php">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-history">
                                    <ul class="m-b-0">
                                        <li class="clearfix">
                                            <div class="message-data text-right">
                                                <span class="message-data-time">10:10 AM, Today</span>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                            </div>
                                            <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:12 AM, Today</span>
                                            </div>
                                            <div class="message my-message">Are we meeting today?</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:15 AM, Today</span>
                                            </div>
                                            <div class="message my-message">Project has been already finished and I have results to show you.</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="chat-message clearfix">
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-send"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Enter text here...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </section>
    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete-category.php',
                        type: 'GET',
                        data: {
                            id: productId
                        },
                        success: function(response) {
                            if (response.trim() == 'success') {
                                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire("Error!", "Failed to delete the product.", "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("Error!", "An unexpected error occurred.", "error");
                        }
                    });
                }
            });
        }
        //search user from chat sidebar

        document.getElementById("searchUser").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let users = document.querySelectorAll(".chat-user-list");

            users.forEach(user => {
                let name = user.querySelector(".name").textContent.toLowerCase();
                if (name.includes(filter)) {
                    user.style.display = "";
                } else {
                    user.style.display = "none";
                }
            });
        });
    </script>
    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>