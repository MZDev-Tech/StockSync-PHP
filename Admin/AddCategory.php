<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

// code to check if admin has submit form

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $detail = mysqli_real_escape_string($con, $_POST['detail']);

    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $image;
    }

    $query = "Insert into category(`name`, `detail`, `image`) values(?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $detail, $imagePath);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        $_SESSION['message'] = 'Record added successfully..';
    } else {
        $_SESSION['message'] = 'Something went wrong while adding..';
    }
    //close the statement
    mysqli_stmt_close($stmt);
    header('Location:View-category.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">


</head>

<body>


    <!-----------SideBar Section------------------->
    <?php include('sidebar.php'); ?>


    <!----------------Main Header Section--------------------->
    <section id="main-page">
        <?php include('Header.php'); ?>


        <!----------------Main Page Design--------------------->
        <main id="page-content">


            <!-- Record Table -->
            <div class="form-parent">

                <div class="form-records">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h4>Add New Category</h4><br>
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Category Name " class="form-control" required>
                        </div>

                        <div class="form-group">
                            <textarea type="text" name="detail" placeholder="Description"
                                class="form-control "></textarea>
                        </div>


                        <div class="form-group">
                            <label style="font-weight:500;">Upload Image</label><br>
                            <input type="file" name="image" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info">Add Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>


        </main>

    </section>

    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>