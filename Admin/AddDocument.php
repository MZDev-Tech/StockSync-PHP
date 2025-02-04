<?php
session_start();
include('../connection.php');

// code to not allow admin to directly access admin panel until they are login

if (!isset($_SESSION['id']) && empty($_SESSION['id'])) {
    header('Location:../admin-login.php');
    exit();

}

// code to check if admin has submit form

if (isset($_POST['submit'])) {

    $filename = mysqli_real_escape_string($con, $_POST['filename']);
    $barcode = uniqid(); //will generate unique barcode
    $created_by = $_SESSION['id'];

    $detail = mysqli_real_escape_string($con, $_POST['detail']);


    $query = "Insert into documents(`filename`, `barcode`, `created_by`,`description`) values(?,?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'ssis', $name, $barcode, $created_by, $detail);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        $_SESSION['message'] = 'Document created successfully..';

    } else {
        $_SESSION['message'] = 'Something went wrong while creating..';

    }
    //close the statement
    mysqli_stmt_close($stmt);
    header('Location:view-document.php');
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>
    <!-- Summernote CSS -->
    <link href="summernote-bs5.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <!-- External CSS File Link -->

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
                        <h4>Create New Document</h4><br>
                        <div class="form-group">
                            <input type="text" name="filename" placeholder="File Name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <textarea id="summernote" name="detail" placeholder="Description"
                                class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info">Create Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </section>

    <!-- Summerote Links -->
  <!-- include libraries(jQuery, bootstrap) -->
  <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
      <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="summernote-bs5.js"></script>

    <!-- Other JS file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <!-- Initialize Summernote -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                placeholder: 'Enter Description',
                height: 200,
                tabsize: 2,
            });
        });
    </script>
</body>

</html>