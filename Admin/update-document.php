<?php
session_start();
include('../connection.php');
// code to not allow admin to directly access admin panel until they are login

if (!isset($_SESSION['id']) && empty($_SESSION['id'])) {
    header('Location:../admin-login.php');
    exit();

}

// code to check if admin has submit data
if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $filename = mysqli_real_escape_string($con, $_POST['filename']);
    $fileTitle = mysqli_real_escape_string($con, $_POST['fileTitle']);
    $detail = mysqli_real_escape_string($con, $_POST['detail']);
     // Removing zero-width space and BOM characters
     $detail = preg_replace('/\x{200B}|\x{FEFF}/u', '', $detail);

     // Remove extra spaces or line breaks if necessary
     $detail = trim($detail);

    $query = "update documents set filename=?, fileTitle=?, description=? where id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $filename, $fileTitle, $detail, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        $_SESSION['message'] = 'Record Updated successfully..';
    } else {
        $_SESSION['message'] = 'Something went wronh while updating..';
    }
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
    <title>Update Document</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Summernote CSS (Bootstrap 4 compatible) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
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
            <?php

            include('../connection.php');
            $id = $_GET['id'];
            $query = "select * from documents where id='$id'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="form-parent">
                    <div class="form-records">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <h4 style="text-align:center; margin:10px 0 14px 0">Update Document</h4>
                            <div class="form-group">
                                <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                            </div>

                            <div class="section">
                                <p class="sec-title"><span class="las la-sort"></span> File Specification</p>
                                <div class="row">

                            <div class="col-md-6 mb-3">
                                <label style="color:black">File Name</label>
                                <input type="text" name="filename" placeholder="Enter name" class="form-control"
                                    value="<?php echo $row['filename']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label style="color:black">File Title</label>
                                <input type="text" name="fileTitle" placeholder="Enter title" class="form-control"
                                    value="<?php echo $row['fileTitle']; ?>" required>
                            </div>
                            </div>
                            </div>

<div class="section">
                                <p class="sec-title"><span class="las la-sort"></span> File Details</p>
                                <div class="row">

                            <div class="col-md-12 mb-3">
                            <textarea name="detail" id="summernote" placeholder="Type Details.." class="form-control"><?php echo $row['description']; ?></textarea>

                            </div>

</div>
</div>


                        <?php } ?>



                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info">Update Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </main>

    </section>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

    <!-- Popper.js (required for Bootstrap 4) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

    <!-- Summernote JS (Bootstrap 4 compatible) -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>

    <!-- Other JS files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>

    <!-- Initialize Summernote -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                placeholder: 'Enter Description',
                height: 400,
                tabsize: 2,
                toolbar: [
                ['style', ['style']], 
                ['font', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],  // Font size
                ['fontname', ['fontname']],  // Font family
                ['color', ['color']],  // Text color
                ['para', ['ul', 'ol', 'paragraph']],  // Lists & Paragraph format
                ['height', ['height']],  // Line height
                ['table', ['table']],  // Table
                ['insert', ['link', 'picture', 'video']],  // Insert options
            ]
            });
        });
    </script>

    <script>
        document.querySelectorAll('input,textarea').forEach(field => {
            if (field.value.trim() !== '') {
                field.classList.add('has-value');
            }

            field.addEventListener('input', () => {
                if (field.value.trim() !== '') {
                    field.classList.add('has-value');
                } else {
                    field.classList.remove('has-value');
                }
            })
        });
    </script>

</body>

</html>