<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("USER_SESSION");

    session_start();
}

include('../connection.php');

// file to not allow user to directly access user panel until they are login
include('Check_token.php');
include('file_counts.php');


//get the current file name
$current_page = basename($_SERVER['PHP_SELF']);
$is_product_page = ($current_page == 'View-products.php' || $current_page == 'AddProducts.php' || $current_page == 'update-product.php' || ($current_page == 'single-product.php'));
$is_user_page = ($current_page == 'User-Profile.php' || $current_page == 'update-profile.php');
$is_document_page = ($current_page == 'view-document.php'  || $current_page == 'AllFiles.php'  ||  $current_page == 'TrackRecord.php' || $current_page == 'single-document.php' || $current_page == 'AddDocument.php' || $current_page == 'view-document.php'  || $current_page == 'OutgoingFile.php'  || $current_page == 'OnholdFile.php'  || $current_page == 'ReceivedFile.php'  || $current_page == 'CancelFile.php'   || $current_page == 'IncomingFile.php'  || $current_page == 'CompleteFile.php'  || $current_page == 'update-document.php');




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sidebar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/print.css" media="print">


</head>

<body>
    <section class="sidebar-part">
        <span class="cross-icon"><i class="fa fa-close" id="crossbtn"></i></span>
        <div class="login-header">
            <img src="../Images/loginGif.gif" alt="">
            <div class="headerContent">
                <h3 class="admin-heading">Stocksync</h3>
                <p>Inventory & file management Sys.</p>
            </div>
        </div>

        <?php
        include('../connection.php');
        $id = $_SESSION['id'];
        $role = 'user';
        $query = "select * from user where id='$id' ";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <div class="admin-part">
                <a href="user-profile.php">
                    <?php if (!empty($row['image']) && file_exists('../Images/' . $row['image'])) {
                        echo '<img src="../Images/' . $row['image'] . '" >';
                    } else {
                        echo '<img src="../Images/user-profile.jpg" >';
                    }
                    ?>
                    <div class="profile-data">
                        <h5>
                            <?php echo $row['name']; ?>
                        </h5>
                        <span style="text-transform:capitalize;"><?php echo $row['designation']; ?> <span style="font-size: 13px; text-transform:capitalize;">(User)</span></span>
                    </div>
                </a>

            <?php } ?>



            </div>
            <ul class="side-menu">
                <li>
                    <a href="Dashboard.php"
                        class="list-item <?php echo ($current_page == 'Dashboard.php') ? 'active' : '' ?>"><i
                            class="fa-brands fa-windows list-icon"></i> Dashboard</a>
                </li>




                <li>

                    <a href="View-products.php" class="list-item <?php echo $is_product_page ? 'active' : '' ?>"><i
                            class="fas fa-list list-icon"></i> View Products</a>
                </li>



                <li class="list-dropdown">

                    <a href="view-document.php"
                        class="list-item <?php echo ($is_document_page == 'view-document.php') ? 'active' : '' ?>"><i
                            class="far fa-folder list-icon"></i> Files Record <span>
                            <i class="fas fa-caret-right arrow-right" id="arrowIcon"></i></span></a>

                    <div class="sub-listItems">
                        <div class="list-menu">
                            <a href="IncomingFile.php"><i class="fa fa-inbox"></i> Incoming </a><span class="fileCount"><?php echo $counts['incoming'] ?></span>
                        </div>
                        <div class="list-menu">
                            <a href="ReceivedFile.php"><i class="fa fa-download"></i> Received </a><span class="fileCount"><?php echo $counts['received'] ?></span>
                        </div>
                        <div class="list-menu">
                            <a href="OutgoingFile.php"><i class="far fa-paper-plane"></i> Outgoing</a><span class="fileCount"><?php echo $counts['outgoing'] ?></span>
                        </div>
                        <div class="list-menu">
                            <a href="OnholdFile.php"><i class="far fa-pause-circle"></i> Onhold</a><span class="fileCount"><?php echo $counts['onhold'] ?></span>
                        </div>
                        <div class="list-menu">
                            <a href="CompleteFile.php"><i class="far fa-check-circle"></i> Complete</a><span class="fileCount"><?php echo $counts['complete'] ?></span>
                        </div>
                        <div class="list-menu">
                            <a href="CancelFile.php"><i class=" far fa-times-circle"></i> Cancelled</a><span class="fileCount"><?php echo $counts['cancelled'] ?></span>
                        </div>
                        <div class="list-menu">
                            <a href="AllFiles.php"><i class="far fa-file-alt"></i> All Files</a><span class="fileCount"><?php echo $counts['all'] ?></span>
                        </div>
                    </div>


                </li>

                <li>

                    <a href="User-Profile.php" class="list-item <?php echo $is_user_page ? 'active' : '' ?>"><i
                            class="far fa-user list-icon"></i> Manage Profile</a>
                </li>

                <li>

                    <a href="#" onclick="Logout(event)" class="list-item <?php echo ($current_page == 'logout.php') ? 'active' : '' ?>"><i
                            class="far fa-arrow-alt-circle-right list-icon"></i> Logout</a>
                </li>
            </ul>
            <div class="setting-btn">
                <i class="fas fa-gear" id="settingsIcon"></i>
                <div class="theme-dropdown" id="themeDropdown">
                    <p class="theme-option" id="default"> <span> <i class="fas fa-sun"></i>
                        </span> Light Mode(Default)</p>
                    <p class="theme-option" id="dark-mode"> <span><i class="fas fa-moon"></i></span> Dark Mode</p>
                    <p class="theme-option" id="light-darkmode"> <span><i class="fas fa-cloud-moon"></i></span> Dark Purple Mode </p>
                </div>
            </div>
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script>
        let dropdownMenu = document.querySelector('.sub-listItems');
        let arrowIcon = document.getElementById('arrowIcon');
        document.querySelector('.arrow-right').onclick = (e) => {
            e.preventDefault();
            dropdownMenu.classList.toggle('active');
            if (dropdownMenu.classList.contains("active")) {
                arrowIcon.classList.remove("fa-caret-right");
                arrowIcon.classList.add("fa-caret-down");
            } else {
                arrowIcon.classList.remove("fa-caret-down");
                arrowIcon.classList.add("fa-caret-right");
            }
        };

        //file count logic here
        function updateFileCounts() {
            fetch('file_counts.php')
                .then(response => response.json())
                .then(data => {
                    document.querySelector(".sub-listItems a[href='IncomingFile.php'] .fileCount").textContent = data.incoming;
                    document.querySelector(".sub-listItems a[href='ReceivedFile.php'] .fileCount").textContent = data.received;
                    document.querySelector(".sub-listItems a[href='OutgoingFile.php'] .fileCount").textContent = data.outgoing;
                    document.querySelector(".sub-listItems a[href='OnholdFile.php'] .fileCount").textContent = data.onhold;
                    document.querySelector(".sub-listItems a[href='CompleteFile.php'] .fileCount").textContent = data.complete;
                    document.querySelector(".sub-listItems a[href='CancelFile.php'] .fileCount").textContent = data.cancelled;
                    document.querySelector(".sub-listItems a[href='AllFiles.php'] .fileCount").textContent = data.all;
                })
                .catch(error => console.error('Error fetching counts:', error));
        }



        //js select themeOptions of sidebar
        document.addEventListener("DOMContentLoaded", function() {
            const settingsBtn = document.querySelector(".setting-btn");
            const themeDropdown = document.getElementById("themeDropdown");
            const themeOptions = document.querySelectorAll(".theme-option");
            const sidebar = document.querySelector(".sidebar-part");

            // Toggle dropdown on settings button click
            settingsBtn.addEventListener("click", function(event) {
                themeDropdown.style.display = themeDropdown.style.display === "block" ? "none" : "block";
                event.stopPropagation(); // Prevent closing immediately
            });

            // Apply theme on selection
            themeOptions.forEach(option => {
                option.addEventListener("click", function() {
                    let theme = this.id; // Get ID of clicked option

                    // Remove all theme classes
                    sidebar.classList.remove("dark-mode", "light-darkmode");

                    // Add the selected theme as a class
                    if (theme !== "default") {
                        sidebar.classList.add(theme);
                    }

                    // Delay hiding the dropdown to ensure the class is applied
                    setTimeout(() => {
                        themeDropdown.style.display = "none";
                    }, 100)
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function(event) {
                if (!settingsBtn.contains(event.target) && !themeDropdown.contains(event.target)) {
                    themeDropdown.style.display = "none";
                }
            });

        });

        //sweet alert for logout

        function Logout(event) {
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
    </script>
</body>

</html>