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
    <title>View Documents</title>

    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!-- Summernote CSS (Bootstrap 4 compatible) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alertMessage').fadeOut('slow')
            }, 2000)
        })
    </script>
    <style>
        td {
            padding-top: 18px !important;
            padding-bottom: 18px !important;

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
                    <h2>Documents </h2>
                    <h5>Home / Files Data</h5>
                </div>
                <!-----------alert message------------->
                <?php if (isset($_SESSION['message'])) { ?>
                    <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:10px 25px">
                        <strong>Document! </strong>
                        <?php echo $_SESSION['message'] ?>
                        <button type="button" data-dismiss="alert" class="close" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php unset($_SESSION['message']);
                } ?>

                <!--------------- Record Table ------------------------->

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
                            <div class="mr-5">
                                <a href="TrackRecord.php" class="btn btn-info trackfile-btn" style="font-size:14px;color:#fff;background: #729b8c !important; border: 0; margin-right: 12px;">Track File</a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="records">
                    <div class="record-header">
                        <div>
                            <h4>Files Record</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-center  ">

                            <form method="POST" action="" style="margin-right:10px">
                                <div class="input-group search-box1">

                                    <input type="text" id="searchTable" style="text-decoration:none;" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="form-control" placeholder="Search...">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                </div>
                            </form>
                            <a href="AddDocument.php" class="add-topbtn1 insert-link" style="margin-right:10px">+Upload <span class="table-name1">File</span></a>

                            <a href="AddDocument.php" class="add-topbtn1 insert-link"> +Create <span class="table-name1">File</span></a>
                        </div>
                    </div>


                    <?php
                    //query to fetch data with the select box
                    $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    $userId = $_SESSION['id'];
                    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
                    $searchQueryData = mysqli_real_escape_string($con, $searchQuery);
                    $query = "SELECT * FROM documents WHERE created_by='$userId' AND (fileNumber LIKE '%$searchQueryData%' OR fileTitle LIKE '%$searchQueryData%' OR barcode LIKE '%$searchQueryData%' OR created_at LIKE '%$searchQueryData%') ORDER BY id LIMIT {$offset}, {$limit}";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    ?>
                    <form method="GET" action="view-document.php">
                        <div class="select-box">
                            <label>Show
                                <select name="select-record" class="select-btn" id="selectlimit">
                                    <option value="3" <?php echo $limit == 3 ? 'selected' : '' ?>>3</option>
                                    <option value="5" <?php echo $limit == 5 ? 'selected' : '' ?>>5</option>
                                    <option value="10" <?php echo $limit == 10 ? 'selected' : '' ?>>10</option>
                                    <option value="15" <?php echo $limit == 15 ? 'selected' : '' ?>>15</option>
                                    <option value="20" <?php echo $limit == 20 ? 'selected' : '' ?>>20</option>

                                </select> entries</label>
                        </div>
                    </form>
                    <div class="table-section">
                        <table width="100%">
                            <thead width="100%">
                                <tr>
                                    <th style="width:90px">S-N</th>
                                    <th style="width:190px"><span class="las la-sort"></span>FileNumber</th>
                                    <th style="width:260px"><span class="las la-sort"></span>Title</th>
                                    <th style="width:210px; padding-left:40px"><span class="las la-sort"></span>Date</th>
                                    <th style="width:160px"><span class="las la-sort"></span>Operations</th>
                                    <th><span class="las la-sort"></span>Action</th>
                                </tr>
                            </thead>


                            <tbody id="documentTable">
                                <?php
                                $CountNumber = 1;
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>
                                        <tr>
                                            <td>#
                                                <?php echo $CountNumber ?>.
                                            </td>
                                            <td style="font-size: 13px;">
                                                <?php echo $row['fileNumber']; ?>
                                            </td>
                                            <td class="des filedes">
                                                <?php echo $row['fileTitle']; ?>
                                            </td>



                                            <td style="padding-left:40px">
                                                <?php echo $row['created_at']; ?>
                                            </td>
                                            <td class="dots-btn" style="padding-left:60px">
                                                <!-- Dropdown Container -->
                                                <div class="dropdown">
                                                    <!-- Dots Icon (Dropdown Toggle) -->
                                                    <a href="#" class="dropdown-toggle no-btn" id="dotsDropdown"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h dots"></i>
                                                    </a>

                                                    <!-- Dropdown Menu -->
                                                    <ul class="dropdown-menu" aria-labelledby="dotsDropdown">
                                                        <li>
                                                            <a class="dropdown-item" href="#barcodeModal<?php echo $row['id'] ?>"
                                                                data-toggle="modal"
                                                                data-target="#barcodeModal<?php echo $row['id'] ?>">
                                                                <i class="fas fa-qrcode"></i> Barcode
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#sendfileModal<?php echo $row['id'] ?>"
                                                                data-toggle="modal" data-target="#sendfileModal<?php echo $row['id'] ?>">
                                                                <i class="far fa-paper-plane"></i> Send File
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="TrackRecord.php">
                                                                <i class="far fa-folder"></i> Track File
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                            <td class="action">

                                                <a href="update-document.php?id=<?php echo $row['id']; ?>" class="update-link" data-id="<?php echo $row['id']; ?>"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i
                                                        class="fa-solid fa-trash"></i></a>
                                                <a href="single-document.php?id=<?php echo $row['id']; ?>" class="singlePage-link" data-id="<?php echo $row['id'] ?>"><i class="fa-solid fa-eye"></i></a>


                                            </td>
                                        </tr>


                                        <!----------------Barcode selection Model For File-------------------->

                                        <div class="container">
                                            <div class="modal fade" id="barcodeModal<?php echo $row['id']; ?>" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-md">

                                                    <!-- Modal content-->
                                                    <div class="modal-content barcode-modal">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="barcodeText<?php echo $row['id'] ?>">
                                                                <?php echo $row['barcode'] ?>
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Please click select button if you want to copy the document barcode.

                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-info"
                                                                onclick="copyBarcode('barcodeText<?php echo $row['id']; ?>')">Select</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!----------------send file Model For document-------------------->

                                        <div class="container">
                                            <div class="modal fade" id="sendfileModal<?php echo $row['id']; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content sendfile-modal">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><i class="fas fa-cog file-icon"></i> Send File</h4>
                                                            <button type="button" data-dismiss="modal" class="close">&times; </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="" id="sendFileForm<?php echo $row['id'] ?>" enctype="multipart/form-data" action="sendFile.php">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="document_id" class="form-control" value="<?php echo $row['id']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="from_user" class="form-control" value="<?php echo $_SESSION['id']; ?>">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="actionType">Action: <span>*</span></label>
                                                                    <select id="actionType" name="action_type" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <option value="release">Release</option>

                                                                    </select>
                                                                </div>

                                                                <!-- Receiver field, initially hidden -->
                                                                <div class="form-group" id="receiverField">
                                                                    <label for="receiver">Receiver: <span>*</span></label>
                                                                    <select id="receiver" name="to_user" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <?php
                                                                        $query1 = "SELECT * FROM user WHERE role='user'";
                                                                        $result1 = mysqli_query($con, $query1);
                                                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                                                            echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>File Title: <span>*</span></label>
                                                                    <input type="text" name="filename" class="form-control" value="<?php echo $row['fileTitle']; ?>" readonly>
                                                                </div>



                                                                <div class="form-group">
                                                                    <label>Remark: <span>*</span></label>
                                                                    <textarea type="text" name="remark" rows="4" placeholder="Type Message .." class="form-control" required></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-info sendFileBtn" data-id="<?php echo $row['id'] ?>">Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                <?php $CountNumber++;
                                    }
                                } else {
                                    echo "<tr><td colspan='6' style='text-align:center; color:#130f40;'>No file record available at a moment</td></tr>";
                                }
                                ?>
                            </tbody>

                    </div>
                    </table>



                    <?php
                    // Fetch search term if it's present
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $id = $_SESSION['id'];
                    $query = "SELECT * FROM documents WHERE created_by='$id' AND (fileNumber LIKE '%$search%' OR fileTitle LIKE '%$search%' OR barcode LIKE '%$search%' OR created_at LIKE '%$search%')";
                    $result = mysqli_query($con, $query);

                    // Fetch the total number of records based on search query
                    $total_query = "SELECT COUNT(*) as total FROM documents WHERE created_by='$id' AND (fileNumber LIKE '%$search%' OR fileTitle LIKE '%$search%' OR barcode LIKE '%$search%' OR created_at LIKE '%$search%')";
                    $result_count = mysqli_query($con, $total_query);
                    $row_count = mysqli_fetch_assoc($result_count);
                    $total_records = $row_count['total'];

                    $total_pages = ceil($total_records / $limit);
                    ?>
                    <div class="pagination-part">
                        <div class="pagination-info">Showing
                            <?php echo ($offset + 1) ?> to
                            <?php echo min($offset + $limit, $total_records) ?> of total
                            <?php echo $total_records ?> entries
                        </div>

                        <div class="pagination-btns">
                            <!-- Previous Button -->
                            <a class="paginate_button previous <?php echo ($page > 1) ? '' : 'disabled'; ?>"
                                href="javascript:void(0)" data-page="<?php echo $page - 1; ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>

                            <!-- Page Number Buttons -->
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <a class="paginate_button <?php echo ($i == $page) ? 'current' : ''; ?>"
                                    href="javascript:void(0)" data-page="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php } ?>

                            <!-- Next Button -->
                            <a class="paginate_button next <?php echo ($page < $total_pages) ? '' : 'disabled'; ?>"
                                href="javascript:void(0)" data-page="<?php echo $page + 1; ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
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
                            url: 'delete-document.php',
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

            // Function to copy barcode to clipboard and show Bootstrap alert
            function copyBarcode(barcodeId, rowId) {
                var barcodeText = document.getElementById(barcodeId).innerText;

                // Copy the barcode text to the clipboard
                navigator.clipboard.writeText(barcodeText).then(function() {
                    // Hide the modal using Bootstrap's native API
                    var modal = new bootstrap.Modal(document.getElementById('barcodeModal' + rowId));
                    modal.hide();
                    console.log('modal id:', rowId);

                    // Display SweetAlert2 notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Barcode Copied to clipboard!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            title: 'swal2-title',
                        }
                    });
                }, function(err) {
                    console.error('Failed to copy barcode: ', err);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to copy barcode!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }

            //ajax code to send file

            $(document).ready(function() {
                $(".sendFileBtn").click(function() {
                    var documentId = $(this).data("id");

                    var form = $("#sendFileForm" + documentId)[0];
                    var formData = new FormData(form); // Automatically collects form data

                    $.ajax({
                        url: "Update-fileStatus.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            try {
                                var result = JSON.parse(response);

                                if (result.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "File Sent!",
                                        text: "The file has been successfully sent.",
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error!",
                                        text: result.error || "Something went wrong!",
                                    });
                                }
                            } catch (e) {
                                console.error("Invalid JSON response:", response);
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Invalid response from the server.",
                                });
                            }
                        }
                    });
                });
            });


            //ajax code to fetch document data and perform search
            $(document).ready(function() {
                function fetchData(page = 1, limit = $("#selectlimit").val(), searchQuery = $("#searchTable").val()) {
                    $.ajax({
                        url: "view-document.php",
                        type: "GET",
                        data: {
                            "page": page,
                            "select-record": limit,
                            "search": searchQuery // Pass the search query here
                        },
                        success: function(response) {
                            var updatedTable = $(response).find("#documentTable").html();
                            $("#documentTable").html(updatedTable);

                            var updatedPagination = $(response).find(".pagination-part").html();
                            $(".pagination-part").html(updatedPagination);

                            // Update the URL without reloading the page
                            var newUrl = "view-document.php?page=" + page + "&select-record=" + limit + "&search=" + searchQuery;
                            window.history.pushState({
                                path: newUrl
                            }, '', newUrl);
                        },
                        error: function(error) {
                            console.error("AJAX Error:", error);
                        }
                    });
                }

                // Fetch new data when selecting a different limit
                $("#selectlimit").change(function() {
                    var limit = $(this).val(); // The selected limit
                    var searchQuery = $("#searchTable").val(); // The current search term
                    fetchData(1, limit, searchQuery); // Always start from page 1 when the limit is changed
                });

                // Event delegation for pagination links
                $(document).on("click", ".paginate_button", function(e) {
                    e.preventDefault();
                    if (!$(this).hasClass("disabled")) {
                        var page = $(this).attr("data-page");
                        var limit = $("#selectlimit").val();
                        var searchQuery = $("#searchTable").val(); // Get the current search term
                        fetchData(page, limit, searchQuery);
                    }
                });

                // Trigger search on keyup event (when the user types something)
                $("#searchTable").keyup(function() {
                    var searchQuery = $(this).val();
                    fetchData(1, $("#selectlimit").val(), searchQuery); // Always start from page 1 on search
                });
            });

            //access update page through ajax code
            $(document).on('click', '.update-link', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                $.ajax({
                    url: "update-document.php",
                    method: "GET",
                    data: {
                        id: id
                    },
                    dataType: "html",
                    success: function(response) {
                        $('#page-content').html(response);
                        // Wait until the DOM is updated, then initialize Summernote
                        $('#summernote').ready(function() {
                            $('#summernote').summernote({
                                placeholder: 'Enter Description',
                                height: 200,
                                tabsize: 2,
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                                    ['fontsize', ['fontsize']],
                                    ['fontname', ['fontname']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['height', ['height']],
                                    ['table', ['table']],
                                    ['misc', ['undo', 'redo']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ],
                                callbacks: {
                                    onImageUpload: function(files) {
                                        var data = new FormData();
                                        data.append("file", files[0]);

                                        $.ajax({
                                            url: 'handleFileMedia.php',
                                            type: 'POST',
                                            data: data,
                                            contentType: false,
                                            processData: false,
                                            success: function(response) {
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
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });

                        setTimeout(() => {
                            applyHasValueClass(); // function to style fields with values
                        }, 100);

                        bindUpdateForm(); // Bind form update handler
                    },
                    error: function(error) {
                        console.error('Error fetching content:', error);
                    }
                });
            });

            //ajax code to get add form 
            document.addEventListener('DOMContentLoaded', function() {
                const addCategoryLinks = document.querySelectorAll('.insert-link');

                addCategoryLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Perform AJAX request to load the Add Category page content
                        $.ajax({
                            url: 'AddDocument.php',
                            method: 'GET',
                            dataType: 'html',
                            success: function(response) {
                                // Replace the page content with the response from AddCategory.php
                                $('#page-content').html(response);
                                // Wait until the DOM is updated, then initialize Summernote
                                $('#summernote').ready(function() {
                                    $('#summernote').summernote({
                                        placeholder: 'Enter Description',
                                        height: 200,
                                        tabsize: 2,
                                        toolbar: [
                                            ['style', ['style']],
                                            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                                            ['fontsize', ['fontsize']],
                                            ['fontname', ['fontname']],
                                            ['color', ['color']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                            ['height', ['height']],
                                            ['table', ['table']],
                                            ['misc', ['undo', 'redo']],
                                            ['view', ['fullscreen', 'codeview', 'help']]
                                        ],
                                        callbacks: {
                                            onImageUpload: function(files) {
                                                var data = new FormData();
                                                data.append("file", files[0]);

                                                $.ajax({
                                                    url: 'handleFileMedia.php',
                                                    type: 'POST',
                                                    data: data,
                                                    contentType: false,
                                                    processData: false,
                                                    success: function(response) {
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
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth'
                                });


                                bindInsertForm();

                            },
                            error: function(error) {
                                console.log('Error fetching form data', error);
                            }
                        });
                    });
                });
            });


            //ajax code to display single file 
            $(document).on('click', '.singlePage-link', function(e) {
                e.preventDefault();

                const id = $(this).data('id');

                $.ajax({
                    url: "single-document.php",
                    method: "GET",
                    data: {
                        id: id
                    },
                    dataType: "html",
                    success: function(response) {
                        $('#page-content').html(response);
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });


                    },
                    error: function(error) {
                        console.error('Error fetching content:', error);
                    }
                });
            });
        </script>

        <!-- External jquery, popper File Link for bootstrap 4 -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Bootstrap 4 (JS) -->
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <!-- Summernote JS (Bootstrap 4 compatible) -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="script.js"></script>
        <script src="ajax-document.js"></script>


    </body>

</html>