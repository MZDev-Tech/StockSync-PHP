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
                    <div class="d-flex align-items-center justify-content-center ">

                        <form method="POST" action="" style="margin-right:10px">
                            <div class="input-group search-box1">

                                <input type="text" id="searchTable" style="text-decoration:none;" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="form-control" placeholder="Search...">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </form>

                        <a href="AddUser.php" class="add-topbtn insert-link"> + Add <span class="table-name">User</span></a>
                    </div>
                </div>

                <?php
                //query to fetch data with the select box
                $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;
                $role = 'user';
                $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
                $searchQueryData = mysqli_real_escape_string($con, $searchQuery);
                $query = "SELECT * FROM user WHERE role='$role' AND (name LIKE '%$searchQueryData%' OR email LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR phone LIKE '%$searchQueryData%'OR address LIKE '%$searchQueryData%') ORDER BY id LIMIT {$offset}, {$limit}";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                ?>
                <form method="GET" action="">
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


                        <tbody id="userTable">
                            <?php
                            $Sr = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td>#
                                            <?php echo $Sr ?>.
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
                                            <?php if (!empty($row['image']) && file_exists('../Images/' . $row['image'])) {
                                                echo '<img src="../Images/' . $row['image'] . '">';
                                            } else {
                                                echo '<img src="../Images/user-profile.jpg">';
                                            } ?>

                                        </td>


                                        <td class="action">
                                            <a href="update-user.php?id=<?php echo $row['id']; ?>" class="update-link" data-id="<?php echo $row['id']; ?>"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i
                                                    class="fa-solid fa-trash"></i></a>
                                            <a href="single-user.php?id=<?php echo $row['id']; ?>" class="singlePage-link" data-id="<?php echo $row['id'] ?>"><i class="fa-solid fa-eye"></i></a>



                                        </td>
                                    </tr>





                            <?php
                                    $Sr++;
                                }
                                // Close the statement
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center; color:#130f40;'>No User record available at a moment</td></tr>";
                            }
                            ?>
                </div>
                </tbody>
                </table>

                <?php
                // Fetch search term if it's present
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                $query = "SELECT * FROM user WHERE role='$role' AND (name LIKE '%$searchQueryData%' OR email LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR phone LIKE '%$searchQueryData%'OR address LIKE '%$searchQueryData%')";
                $result = mysqli_query($con, query: $query);
                // Fetch the total number of records based on search query
                $role = 'user';
                $total_query = "SELECT COUNT(*) as total FROM user WHERE role='$role' AND (name LIKE '%$searchQueryData%' OR email LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR phone LIKE '%$searchQueryData%'OR address LIKE '%$searchQueryData%')";
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



        </main>

    </section>

    <!-- External jquery, popper File Link for bootstrap 4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="ajax-user.js"></script>

    <script>
        function confirmDelete(userId) {
            const selectedLimit = $("#selectlimit").val();
            const currentSearchQuery = $("#searchTable").val();
            const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

            // Display confirmation popup for deletion
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
                    // Proceed with checking for dependencies
                    $.ajax({
                        url: 'delete-user.php',
                        type: 'GET',
                        data: {
                            id: userId,
                            page: currentPage,
                            search: currentSearchQuery,
                            "select-record": selectedLimit
                        },
                        success: function(response) {
                            console.log('server response:', response);
                            let res;
                            try {
                                res = JSON.parse(response);
                            } catch (e) {
                                Swal.fire("Error!", "Invalid response from server.", "error");
                                return;
                            }

                            if (res.status === 'hasDependencies') {
                                Swal.fire({
                                    title: "<strong>Warning!  Can't Delete User</strong>",
                                    html: `
		<p style="font-size: 15px; text-align: left; margin: 0 12px 10px 30px; text-transform:none;">
			This user is linked to the following records please delete these before removing this user:
		</p>
            ${res.message}
	`,
                                    icon: "warning",
                                    confirmButtonText: "OK"
                                });

                            } else if (res.status === 'success') {
                                Swal.fire("Deleted!", "User has been deleted successfully.", "success");
                                setTimeout(() => {
                                    window.location.href = `View-user.php?page=${res.redirectPage}&select-record=${selectedLimit}&search=${encodeURIComponent(currentSearchQuery)}`;
                                }, 1500);
                            } else {
                                Swal.fire("Error!", res.message || "Failed to delete the user.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error!", "An unexpected error occurred.", "error");
                        }
                    });
                }
            });
        }
    </script>

    <script>
        //ajax code tpo fetch user data on dashboard
        $(document).ready(function() {
            function fetchData(page = 1, limit = $("#selectlimit").val(), searchQuery = $("#searchTable").val()) {
                $.ajax({
                    url: "View-user.php",
                    type: "GET",
                    data: {
                        "page": page,
                        "select-record": limit,
                        "search": searchQuery // Pass the search query here
                    },
                    success: function(response) {
                        console.log("delete Response:", response); // <-- Add this line

                        var updatedTable = $(response).find("#userTable").html();
                        $("#userTable").html(updatedTable);

                        var updatedPagination = $(response).find(".pagination-part").html();
                        $(".pagination-part").html(updatedPagination);

                        // Update the URL without reloading the page
                        var newUrl = "View-user.php?page=" + page + "&select-record=" + limit + "&search=" + searchQuery;
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
                url: "update-user.php",
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

                    // Perform AJAX request to load the Add user page content
                    $.ajax({
                        url: 'AddUser.php',
                        method: 'GET',
                        dataType: 'html',
                        success: function(response) {
                            // Replace the page content with the response from add user.php
                            $('#page-content').html(response);
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });


                            // Call the function to bind the insert form (after the content is loaded)
                            bindInsertForm();
                        },
                        error: function(error) {
                            console.log('Error fetching form data', error);
                        }
                    });
                });
            });
        });

        $(document).on('click', '.singlePage-link', function(e) {
            e.preventDefault();

            const id = $(this).data('id');

            $.ajax({
                url: "single-user.php",
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
</body>

</html>