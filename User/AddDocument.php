<?php
session_name("USER_SESSION");
session_start();
include('../connection.php');

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

// Code to check if admin has submitted the form
if (isset($_POST['submit'])) {
    $filename = mysqli_real_escape_string($con, $_POST['filename']);
    $fileTitle = mysqli_real_escape_string($con, $_POST['fileTitle']);

    $barcode = uniqid(); // Will generate a unique barcode
    $created_by = $_SESSION['id'];
    $detail = mysqli_real_escape_string($con, $_POST['detail']);
    // Removing zero-width space and BOM characters
    $detail = preg_replace('/\x{200B}|\x{FEFF}/u', '', $detail);

    // Remove extra spaces or line breaks if necessary
    $detail = trim($detail);

    $query = "INSERT INTO documents(`filename`,`fileTitle`, `barcode`, `created_by`, `description`) VALUES (?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssis', $filename, $fileTitle, $barcode, $created_by, $detail);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['message'] = 'Document created successfully.';
    } else {
        $_SESSION['message'] = 'Something went wrong while creating the document.';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
    header('Location: view-document.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>

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
            <div class="form-parent">
                <div class="form-records">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h4 class="text-center">Create New Document</h4><br>
                        <div class="section">
                            <p class="sec-title"><span class="las la-sort"></span> File Specification</p>
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="Filename" class="form-label">File Name</label>
                                    <input type="text" name="filename" placeholder="Enter Name" class="form-control"
                                        required>

                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="File Title" class="form-label">File Title</label>
                                    <input type="text" name="fileTitle" class="form-control" placeholder="Enter Title"
                                        required>

                                </div>
                            </div>
                        </div>

                        <div class="section">
                            <p class="sec-title"><span class="las la-sort"></span> File Information</p>
                            <div class="row">
                                <div class="form-group">
                                    <textarea id="summernote" name="detail" placeholder="Description"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info">Create Now</button>
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
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Enter Description',
                height: 200,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // Handle image upload
                        var data = new FormData();
                        data.append("file", files[0]); // Append the file to FormData

                        $.ajax({
                            url: 'handleFileMedia.php', // Server-side upload script
                            type: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                // Insert the uploaded image into the editor
                                $('#summernote').summernote('insertImage', response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error uploading file: " + error);
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>