<?php
session_name("USER_SESSION");
session_start();
include '../connection.php';
//file to check if token expire then redirect us to login 
include('Check_token.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Files</title>

    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
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
                    <h2>Complete Documents </h2>
                    <h5>Home / Files Data</h5>
                </div>


                <!--------------- Record Table ------------------------->

                <div class="row" style="margin:10px 25px">
                    <div class="col-12 bg-white">
                        <div class="d-flex justify-content-between align-items-center py-3 top-recordParent">
                            <div class="d-flex align-items-center top-recordPart">
                                <i class="fa-solid fa-tablet-screen-button"></i>
                                <div>
                                    <h2 class="mb-1">Completed Record</h2>
                                    <p class="mb-0">Manage your records efficiently</p>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="records">
                    <div class="record-header">
                        <div>
                            <h4>Complete Files</h4>
                        </div>

                    </div>

                    <?php
                    //query to fetch data with the select box
                    $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    $userId = $_SESSION['id'];

                    $query = "SELECT dt.* FROM document_tracking dt 
                    WHERE status = 'complete'
                    ORDER BY document_id LIMIT {$offset}, {$limit}";

                    $result = mysqli_query($con, $query);

                    ?>
                    <form method="GET" action="CompleteFile.php">
                        <div class="select-box">
                            <label>Show
                                <select name="select-record" class="select-btn" onchange="this.form.submit()">
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
                                    <th style="width:160px"><span class="las la-sort"></span>FileName</th>
                                    <th style="width:190px"><span class="las la-sort"></span>Send To</th>
                                    <th style="width:120px"><span class="las la-sort"></span>Options</th>
                                    <th style="width:140px"><span class="las la-sort"></span>Status</th>
                                    <th style="width:190px"><span class="las la-sort"></span>Complete Date</th>
                                    <th><span class="las la-sort"></span>Manage</th>
                                </tr>
                            </thead>

                            <?php
                            include('../connection.php');
                            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;
                            $CountNumber = 1;
                            $userId = $_SESSION['id'];
                            $query = "SELECT documents.*,
                            sender.name AS sender_name,  
                            receiver.name AS receiver_name,
                            userDetails.designation AS user_designation,
                            userDetails.image AS user_image,
                            dt.date, dt.remark, dt.status, dt.to_user,
                            dt.from_user FROM document_tracking dt
                        JOIN documents ON dt.document_id = documents.id
                        JOIN user AS sender ON dt.from_user = sender.id  
                        JOIN user AS receiver ON dt.to_user = receiver.id
                        JOIN user AS userDetails ON dt.to_user = userDetails.id 
                        WHERE dt.status = 'complete' ORDER BY dt.document_id, dt.date DESC
                        LIMIT {$offset}, {$limit};";



                            $stmt = mysqli_prepare($con, $query);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tbody>
                                        <tr>
                                            <td>#
                                                <?php echo $CountNumber ?>.
                                            </td>
                                            <td class="des filedes">
                                                <?php echo $row['filename']; ?>
                                            </td>


                                            <td class="user-designation">
                                                <img src="<?php echo file_exists("../Image/" . $row['user_image']) && !empty($row['user_image']) ? "../Image/" . $row['user_image'] : '../Images/ImgIcon.png'; ?>"
                                                    onerror="this.onerror=null; this.src='../Images/ImgIcon.png';">
                                                <div class="fileUser-data">
                                                    <h5><?php echo $row['receiver_name']; ?></h5>
                                                    <p><?php echo $row['user_designation']; ?></p>
                                                </div>

                                            </td>


                                            <td class="dots-btn" style="padding-left:50px">
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
                                                            <a class="dropdown-item" href="#viewRemarkModal<?php echo $row['id'] ?>"
                                                                data-toggle="modal" data-target="#viewRemarkModal<?php echo $row['id'] ?>">
                                                                <i class="fa fa-pencil"></i> Remark
                                                            </a>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </td>
                                            <span>
                                                <td class="status">

                                                    <?php echo $row['status']; ?>

                                                </td>
                                            </span>

                                            <td style="padding-left:30px;">
                                                <?php
                                                echo $row['date']; ?>
                                            </td>
                                            <td class="action">
                                                <a href="single-document.php?id=<?php echo $row['id']; ?>">
                                                    <span class="file-action"><i class="fa-solid fa-eye"></i></span></a>

                                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                    <span class="file-action"><i class="fa-solid fa-trash"></i></span></a>

                                            </td>
                                        </tr>
                                    </tbody>



                    </div>

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

                    <!----------------View Remark Model For File-------------------->

                    <div class="container">
                        <div class="modal fade" id="viewRemarkModal<?php echo $row['id']; ?>" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content remark-modal">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <div class="remark-gif">
                                            <img src="../Images/remark1.gif" alt="">

                                            <h4 class="modal-title">
                                                <p> Review and Comments on this file</p>
                                            </h4>
                                        </div>

                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $row['remark'] ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <a href="single-document.php?id=<?php echo $row['id'] ?>" class="btn btn-info text-white"> Check Document</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


            <?php $CountNumber++;
                                    // Close the statement
                                    mysqli_stmt_close($stmt);
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center; color:#130f40;'>No Complete Files record available at a moment</td></tr>";
                            }


            ?>

            </table>

            <?php
            $userId = $_SESSION['id'];


            $query_count = "SELECT count(*) AS total_received FROM document_tracking dt WHERE status='complete' ";

            $result = mysqli_query($con, $query_count);
            $row = mysqli_fetch_assoc($result);
            $total_records = $row['total_received'];
            $total_pages = ceil($total_records / $limit);
            ?>
            <div class="pagination-part">
                <div class="pagination-info">Showing
                    <?php echo ($offset + 1) ?> to
                    <?php echo min($offset + $limit, $total_records) ?> of total
                    <?php echo $total_records ?> entries
                </div>

                <?php
                echo '<div class="pagination-btns">';

                // Previous Button
                if ($page > 1) {
                    echo '<a class="paginate_button previous" href="CompleteFile.php?page=' . ($page - 1) . '"><i class="fas fa-chevron-left"></i></a>';
                } else {
                    // Disable Previous button if on the first page or only 1 page exists
                    echo '<a class="paginate_button previous disabled" href="javascript:void(0)"><i class="fas fa-chevron-left"></i></a>';
                }

                // Page Number Buttons
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        $active = 'current';
                    } else {
                        $active = '';
                    }
                    echo '<a class="paginate_button ' . $active . '" href="CompleteFile.php?page=' . $i . '">' . $i . '</a>';
                }

                // Next Button
                if ($total_pages > $page) {
                    echo '<a class="paginate_button next" href="CompleteFile.php?page=' . ($page + 1) . '"><i class="fas fa-chevron-right"></i></a>';
                } else {
                    // Disable Next button if on the last page or only 1 page exists
                    echo '<a class="paginate_button next disabled" href="javascript:void(0)"><i class="fas fa-chevron-right"></i></a>';
                }

                echo '</div>';
                ?>

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
                            url: 'delete-fileTracking.php',
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
        </script>

        <!-- External jquery, popper File Link for bootstrap 4 -->

        <script src="../Bootstrap/js/jquery.min.js"></script>
        <script src="../Bootstrap/js/popper.min.js"></script>

        <!-- Bootstrap 4 (JS) -->
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="script.js"></script>
    </body>

</html>