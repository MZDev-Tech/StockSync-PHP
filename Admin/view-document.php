<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['id']) && empty($_SESSION['id'])) {
    header('Location:../admin-login.php');
    exit();
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Documents</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Make sure Bootstrap CSS and JS are included -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
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
                            <a href="TrackRecord.php" class="btn btn-info trackfile-btn">Track File</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="records">
                <div class="record-header">
                    <div>
                        <h4>Files Record</h4>
                    </div>

                    <a href="AddDocument.php" class="add-topbtn"> + Create File</a>
                </div>

                <?php
                //query to fetch data with the select box
                $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                $query = "select * from documents ORDER BY id LIMIT {$offset}, {$limit}";
                $result = mysqli_query($con, $query);

                ?>
                <form method="GET" action="View-user.php">
                    <div class="select-box">
                        <label>Show
                            <select name="select-record" class="select-btn" onchange="this.form.submit()">
                                <option value="3" <?php echo $limit == 3 ? 'selected' : '' ?> >3</option>
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
                                <th style="width:190px"><span class="las la-sort"></span>Filename</th>
                                <th style="width:260px"><span class="las la-sort"></span>Title</th>
                                <th style="width:210px; padding-left:40px"><span class="las la-sort"></span>Date</th>
                                <th style="width:160px"><span class="las la-sort"></span>Operations</th>
                                <th><span class="las la-sort"></span>Action</th>
                            </tr>
                        </thead>

                        <?php
                        include('../connection.php');
                        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;
                        $CountNumber = 1;
                        $query = "select * from documents ORDER BY id LIMIT {$offset},{$limit}";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <tbody>
                            <tr>
                                <td>#
                                    <?php echo $CountNumber ?>.
                                </td>
                                <td>
                                    <?php echo $row['filename']; ?>
                                </td>
                                <td class="des">
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
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-qrcode"></i> Barcode
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-pen"></i> Remark
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
                                        <a href="update-document.php?id=<?php echo $row['id']; ?>"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i
                                                class="fa-solid fa-trash"></i></a>

                                        <a href="single-document.php?id=<?php echo $row['id']; ?>"><i
                                                class="fa-solid fa-eye"></i></a>


                                    </td>
                                </tr>

                            </tbody>

                    </div>

                    <?php $CountNumber++;

                        }
                        // Close the statement
                        mysqli_stmt_close($stmt);
                        ?>
                </table>

                <?php
                $query = "select COUNT(*) as total from documents";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                $total_records = $row['total'];
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
                    if ($page > 1) {
                        echo ' <a class="paginate_button previous " href="View-category.php?page=' . ($page - 1) . '"><i class="fas fa-chevron-left"></i></a>';
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {

                        if ($i == $page) {
                            $active = 'current';
                        } else {
                            $active = '';
                        }
                        echo '<a class="paginate_button ' . $active . '" href="View-user.php?page=' . $i . '">' . $i . '</a>';
                    }
                    if ($total_pages > $page) {
                        echo '<a class="paginate_button next" href="View-user.php?page=' . ($page + 1) . '"><i class="fas fa-chevron-right"></i></a>';
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
                        url: 'delete-document.php',
                        type: 'GET',
                        data: { id: productId },
                        success: function (response) {
                            if (response.trim() == 'success') {
                                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire("Error!", "Failed to delete the product.", "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire("Error!", "An unexpected error occurred.", "error");
                        }
                    });
                }
            });
        }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>