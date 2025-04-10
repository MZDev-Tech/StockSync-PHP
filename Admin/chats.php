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
            <div class="chat-record">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="chat-card chat-app" style="display:flex">
                            <!-- Sidebar with User List -->
                            <div id="userList" class="people-list-sidebar" id="chatSidebar">
                                <?php
                                include('../connection.php');
                                $id = $_SESSION['id'];
                                $role = 'admin';
                                $query = "SELECT * FROM user WHERE id='$id' && role='$role'";
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
                                                <h5><?php echo $row['name']; ?></h5>
                                                <span style="text-transform:none;"><?php echo $row['email']; ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>

                                <div class="input-group chat-search">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" id="searchUser" class="form-control" placeholder="Search...">
                                </div>

                                <ul class="chat-ul chat-list">
                                    <?php
                                    $id = $_SESSION['id'];
                                    $query1 = "SELECT * FROM user WHERE id !='$id' AND role='user'";
                                    $result1 = mysqli_query($con, $query1);
                                    while ($row = mysqli_fetch_array($result1)) {
                                    ?>
                                        <li class="chat-user-list">
                                            <a href="?userId=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                                <img src="../images/<?php echo $row['image']; ?>" alt="avatar">
                                                <div class="about">
                                                    <div class="name"><?php echo $row['name']; ?></div>
                                                    <div class="status">
                                                        <?php
                                                        echo ($row['status'] === 'active') ? '<i class="fa fa-circle online"></i> Online' : '<i class="fa fa-circle offline"></i> Offline';
                                                        ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <!-- Main Chat Area -->
                            <div class="chat-leftpart" id="chatLeftPart" style="flex-grow: 1;">
                                <?php
                                // Check if a user is clicked (userId is passed in the URL)
                                if (isset($_GET['userId'])) {
                                    $userId = $_GET['userId'];
                                    $query = "SELECT * FROM user WHERE id = '$userId'";
                                    $result = mysqli_query($con, $query);
                                    $userData = mysqli_fetch_assoc($result);

                                    if ($userData) {
                                ?>
                                        <div class="selectd-chat">
                                            <div class="chat-header">
                                                <div class="user-info">
                                                    <img src="../Images/menu-bar.png" alt="" id="chatMenuBtn" class="chat-menu">
                                                    <img id="chatUserImage" src="../images/<?php echo $userData['image']; ?>" alt="avatar">
                                                    <div class="chat-about">
                                                        <h6 id="chatUserName" class="m-b-0"><?php echo $userData['name']; ?></h6>
                                                        <small id="chatUserStatus">
                                                            <?php echo ($userData['status'] === 'active') ? 'Online' : 'Offline'; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-history">
                                                <?php
                                                $currentUser = $_SESSION['id'];
                                                $query = "SELECT * FROM messages WHERE (sender_id='$currentUser' AND receiver_id='$userId') OR (sender_id='$userId' AND receiver_id='$currentUser') ORDER BY created_at ASC";
                                                $result = mysqli_query($con, $query);

                                                if (mysqli_num_rows($result) > 0) {
                                                ?>
                                                    <ul class="m-b-0">
                                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                            <li class="clearfix">
                                                                <div class="message-data <?php echo ($row['sender_id'] == $currentUser) ? 'text-right' : ''; ?>">
                                                                    <span class="message-data-time"><?php echo date("h:i A, d M", strtotime($row['created_at'])); ?></span>
                                                                </div>
                                                                <div class="message <?php echo ($row['sender_id'] == $currentUser) ? 'other-message float-right' : 'my-message'; ?>">
                                                                    <?php echo htmlspecialchars($row['message']); ?>
                                                                </div>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } else { ?>
                                                    <div class="no-chat">
                                                        <img src="../images/nochat.png" alt="">
                                                        <h3>No Message Yet</h3>
                                                        <p>Your inbox is empty. Start a conversation 😊, and your messages will show up here!</p>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="chat-message send-chat">
                                                <div class="input-group mb-0 send-message">

                                                    <input type="text" class="form-control" placeholder="Enter text here...">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-paper-plane"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        echo "<p>User not found.</p>";
                                    }
                                } else {
                                    // Default view when no chat is selected
                                    ?>
                                    <div class="start-chat">
                                        <img src="../Images/startchat.gif">
                                        <h2>Connect with Someone</h2>
                                        <p>Click on a user to see previous messages or start a new chat.</p>
                                    </div>
                                <?php } ?>
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




        // Send message to the database

        $(document).ready(function() {
            $(".send-message span").click(function() {
                var message = $(".send-message input").val().trim();
                var receiverId = "<?php echo isset($_GET['userId']) ? $_GET['userId'] : ''; ?>";

                if (message === "" || receiverId === "") {
                    alert("Message or Receiver ID is missing.");
                    return;
                }

                console.log("Sending Message:", message);
                console.log("Receiver ID:", receiverId);

                $.ajax({
                    url: "send-message.php",
                    type: "POST",
                    data: {
                        message: message,
                        receiver_id: receiverId
                    },
                    dataType: "text",
                    success: function(response) {
                        console.log("Server Response:", response);

                        if (response.trim() === "Message sent") {
                            // Append message to chat
                            $(".chat-history ul").append(`
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time">${new Date().toLocaleTimeString()}</span>
                                </div>
                                <div class="message other-message float-right">
                                    ${message}
                                </div>
                            </li>
                        `);
                            $(".send-message input").val(""); // Clear input field
                        } else {
                            alert("Message not sent. Error: " + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert("Error sending message. Check console for details.");
                    }
                });
            });
        });


        let chatMenu = document.getElementById('chatMenuBtn');
        let chatSidebar = document.getElementById('chatSidebar');
        let chatleftPart = document.getElementById('chatLeftPart');
        chatMenu.addEventListener('click', () => {
            console.log('chatbtn clicked');
            chatSidebar.classList.toggle('active');
            chatleftPart.classList.toggle('active');
        })
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>