<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../connection.php');

// code to not allow admin to directly access admin panel until they are login

if (!isset($_SESSION['id']) && empty($_SESSION['id'])) {
    header('Location:../admin-login.php');
    exit();
}


//get the current file name
 $current_page = basename($_SERVER['PHP_SELF']);
 $is_category_page = ($current_page == 'View-category.php' || $current_page == 'AddCategory.php' || $current_page == 'update-category.php');
 $is_product_page = ($current_page == 'View-products.php' || $current_page == 'AddProducts.php' || $current_page == 'update-product.php' || ($current_page == 'single-products.php' && isset($_GET['id'])));
 $is_Admin_page = ($current_page == 'Admin-Profile.php' || $current_page == 'update-profile.php');
 $is_user_page = ($current_page == 'View-user.php' ||$current_page == 'single-user.php'|| $current_page == 'AddUser.php' || $current_page == 'update-user.php');
 $is_document_page = ($current_page == 'view-document.php' ||$current_page == 'single-document.php'|| $current_page == 'AddDocument.php' || $current_page == 'update-document.php');




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


</head>

<body>
    <section class="sidebar-part">
        <span class="cross-icon"><i class="fa fa-close" id="crossbtn"></i></span>
        <a href="#" class="brand">
            <img src="../Images/log11.png" alt="">
            <span class="link-text">Inventory</span>
            <span class="link-text li-brand">System</span></a>
        </a>

        <?php
        include('../connection.php');
        $query = "select * from admin where id='1'";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="admin-part">
                <a href="admin-profile.php">
                    <img src="../Images/<?php echo $row['image']; ?>" alt="Profile Img">
                    <div class="profile-data">
                        <h5>
                            <?php echo $row['name']; ?>
                        </h5>
                        <span><?php echo $row['email']; ?></span>
                    </div>
                </a>

            <?php } ?>



        </div>
        <ul class="side-menu">
            <li class="list-item <?php echo ($current_page == 'Dashboard.php') ? 'active' : '' ?>" >
                <i class="fa-brands fa-windows"></i>
                <a href="Dashboard.php">Dashboard</a>
            </li>

            
            <li class="list-item <?php echo  $is_category_page ? 'active' : '' ?>" >
                <i class="far fa-plus"></i>
                <a href="View-category.php"> Categories</a>
            </li>

            <li class="list-item <?php echo  $is_product_page ? 'active' : '' ?>" >
                <i class="fas fa-list"></i>
                <a href="View-products.php"> View Products</a>
            </li>

            <li class="list-item <?php echo ($is_user_page == 'View-user.php') ? 'active' : '' ?>" >
                <i class="fas fa-users"></i>
                <a href="View-user.php"> User Record</a>
            </li>

            <li class="list-item <?php echo ($is_document_page == 'view-document.php') ? 'active' : '' ?>" >
                <i class="far fa-folder"></i>
                <a href="view-document.php"> Files Record</a>
            </li>

            <li class="list-item <?php echo  $is_Admin_page ? 'active' : '' ?>" >
                <i class="far fa-user"></i>
                <a href="Admin-Profile.php"> Manage Profile</a>
            </li>

            <li class="list-item" <?php echo ($current_page == 'logout.php') ? 'active' : '' ?>>
                <i class="far fa-arrow-alt-circle-right"></i>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>