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
    <title>View Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
                <h2>User Record</h2>
                <h5>Home / users</h5>
            </div>
            <!-----------alert message------------->
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:10px 25px">
                    <strong>User! </strong>
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

                    </div>
                </div>
            </div>

            <div class="records">
                <div class="record-header">
                    <div>
                        <h4>User Details</h4>
                    </div>

                    <a href="AddUser.php" class="add-topbtn"> + Add User</a>
                </div>

                <?php
                //query to fetch data with the select box
                $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;
                $role = 'user';
                $query = "select * from user WHERE role='$role' ORDER BY id LIMIT {$offset}, {$limit}";
                $result = mysqli_query($con, $query);

                ?>
                <form method="GET" action="View-user.php">
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
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><span class="las la-sort"></span>Name</th>
                                <th><span class="las la-sort"></span>Email</th>
                                <th><span class="las la-sort"></span>Password</th>
                                <th><span class="las la-sort"></span>Status</th>
                                <th><span class="las la-sort"></span>Image</th>
                                <th><span class="las la-sort"></span>Action</th>
                        </thead>

                        <?php
                        include('../connection.php');
                        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;
                        $role = 'user';
                        $query = "select * from user WHERE role='$role' ORDER BY id LIMIT {$offset},{$limit}";
                        $stmt = mysqli_prepare($con, $query);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                        ?>
                                <tbody>
                                    <tr>
                                        <td>#
                                            <?php echo $row['id']; ?>.
                                        </td>
                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td style="text-transform:none">
                                            <?php echo $row['email']; ?>
                                        </td>



                                        <td style="padding-left:40px">
                                            <?php echo $row['password']; ?>
                                        </td style="padding-left:40px">
                                        <td>

                                            <?php
                                            $status = $row['status'];
                                            $bgcolor = ($status == 'active') ? 'bg-active' : 'bg-inactive';
                                            echo "<span class='status $bgcolor'>$status</span>";

                                            ?>
                                        </td>
                                        <td class="single-img">
                                            <?php if (!empty($row['image']) && file_exists('../Images' . $row['image'])) {
                                                echo '<img src="../Images/' . $row['image'] . '">';
                                            } else {
                                                echo '<img src="../Images/user-profile.jpg">';
                                            }
                                            ?>

                                        </td>


                                        <td class="action">
                                            <a href="update-user.php?id=<?php echo $row['id']; ?>"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i
                                                    class="fa-solid fa-trash"></i></a>

                                            <a href="single-user.php?id=<?php echo $row['id']; ?>"><i
                                                    class="fa-solid fa-eye"></i></a>


                                        </td>
                                    </tr>

                                </tbody>

                </div>

        <?php }
                            // Close the statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center; color:#130f40;'>No User record available at a moment</td></tr>";
                        }
        ?>
        </table>

        <?php
        $query = "select COUNT(*) as total from user";
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

            // Previous Button
            if ($page > 1) {
                echo '<a class="paginate_button previous" href="View-user.php?page=' . ($page - 1) . '"><i class="fas fa-chevron-left"></i></a>';
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
                echo '<a class="paginate_button ' . $active . '" href="View-user.php?page=' . $i . '">' . $i . '</a>';
            }

            // Next Button
            if ($total_pages > $page) {
                echo '<a class="paginate_button next" href="View-user.php?page=' . ($page + 1) . '"><i class="fas fa-chevron-right"></i></a>';
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
                        url: 'delete-user.php',
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
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>