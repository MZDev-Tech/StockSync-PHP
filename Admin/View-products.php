<?php
session_name("ADMIN_SESSION");
session_start();

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Products</title>
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
  <!-- External CSS File Link -->
  <link rel="stylesheet" href="../CSS/style.css">
  <!-- Font Icons Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet"
    href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="sweetalert2.min.css">

  <script>
    $(document).ready(function() {
      setTimeout(function() {
        $('#alertMessage').fadeOut('slow')
      }, 2000)
    })
  </script>

  <style>


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
        <h2>Products</h2>
        <h5>Home / Product</h5>
      </div>
      <!-----------alert message------------->
      <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:10px 25px">
          <strong>Product! </strong>
          <?php echo $_SESSION['message'] ?>
          <button type="button" data-dismiss="alert" class="close" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php unset($_SESSION['message']);
      } ?>

      <!---------------top Record Table ------------------------->

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

      <!---------------report generation part ------------------------->

      <div class="row" style="margin:12px 25px">
        <div class="col-12 bg-white">

          <div class=" py-3 top-recordParent">
            <h4><span class="las la-sort"></span> Generate Inventory Report</h4>
            <form action="generateReport.php" method="GET">
              <div class="row d-flex flex-wrap" style="margin: 0;">

                <div class="col-12 col-sm-6 col-md-3" style="padding-right:0">
                  <label>Choose products</label>
                  <select name="category" class="form-control">

                    <option value="">select</option>
                    <?php
                    $categoryResult = mysqli_query($con, "SELECT DISTINCT category FROM laptops");
                    while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                      echo "<option value='{$categoryRow['category']}'>{$categoryRow['category']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3" style="padding-right:0">
                  <label>Choose Processor</label>
                  <select name="processor" class="form-control">
                    <option value="">select</option>
                    <?php
                    $processorQuery = "SELECT DISTINCT processor FROM laptops";
                    $processorResult = mysqli_query($con, $processorQuery);
                    while ($processorRow = mysqli_fetch_assoc($processorResult)) {
                      echo "<option value='{$processorRow['processor']}'>{$processorRow['processor']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3" style="padding-right:0">
                  <label>Choose Person</label>
                  <select name="person_name" class="form-control">
                    <option value="">select</option>
                    <?php
                    $Query = "SELECT DISTINCT person_name FROM laptops";
                    $Result = mysqli_query($con, $Query);
                    while ($Row = mysqli_fetch_assoc($Result)) {
                      echo "<option value='{$Row['person_name']}'>{$Row['person_name']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3" style="padding-right:0">
                  <button type="submit" class="btn mt-4" style=" color:#fff; background: #729b8c; border:0; " title="Download Report">
                    <i class="fas fa-download" style=" font-size:16px"></i>
                  </button>
                </div>
            </form>
          </div>
        </div>
      </div>
      </div>

      <div class="records">
        <div class="record-header">
          <div>
            <h4>Product Details</h4>
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

            <a href="AddProducts.php" class="add-topbtn insert-link"> + Add Product</a>
          </div>
        </div>
        <?php
        include('../connection.php');
        $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        $searchQueryData = mysqli_real_escape_string($con, $searchQuery);
        // Modify the query to include the search functionality
        $query = "SELECT * FROM laptops WHERE category LIKE '%$searchQueryData%' OR brand LIKE '%$searchQueryData%' OR model LIKE '%$searchQueryData%' OR processor LIKE '%$searchQueryData%'OR RAM LIKE '%$searchQueryData%'OR storage LIKE '%$searchQueryData%' OR price LIKE '%$searchQueryData%'OR quantity LIKE '%$searchQueryData%'OR serialNumber LIKE '%$searchQueryData%'OR date LIKE '%$searchQueryData%'OR delivery_date LIKE '%$searchQueryData%'OR total_age LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR person_name LIKE '%$searchQueryData%' OR status LIKE '%$searchQueryData%' ORDER BY id LIMIT {$offset}, {$limit}";
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
                <option value="30" <?php echo $limit == 30 ? 'selected' : '' ?>>30</option>
              </select> entries</label>
          </div>
        </form>

        <div class="table-section">
          <table width="100%">
            <thead>
              <tr>
                <th>S-N</th>
                <th><span class="las la-sort"></span>Brand</th>
                <th><span class="las la-sort"></span>Category</th>
                <th><span class="las la-sort"></span>Serial No.</th>
                <th><span class="las la-sort"></span>Image</th>
                <th><span class="las la-sort"></span>Action</th>
            </thead>


            <tbody id="productTable">
              <?php
              $Sr = 1;
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
              ?>
                  <tr>
                    <td>#
                      <?php echo $Sr ?>
                    </td>
                    <td>

                      <?php echo $row['brand']; ?>
                    </td>
                    <td>
                      <?php echo $row['category']; ?>
                    </td>
                    <td>
                      <?php echo $row['serialNumber']; ?>
                    </td>

                    <td>
                      <?php if (!empty($row['image']) && file_exists($row['image'])) {
                        echo '<img src="../Images/' . $row['image'] . ' ">';
                      } else {
                        echo '<img src="../Images/productdefault.png ">';
                      } ?>

                    </td>

                    <td class="action">

                      <a href="update-product.php?id=<?php echo $row['id']; ?>" class="update-link" data-id="<?php echo $row['id']; ?>"><i
                          class="fa-solid fa-pen-to-square"></i></a>
                      <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i
                          class="fa-solid fa-trash"></i></a>
                      <a href="single-product.php?id=<?php echo $row['id']; ?>" class="singlePage-link"><i class="fa-solid fa-eye"></i></a>

                    </td>
                  </tr>







              <?php $Sr++;
                }
              } else {
                echo "<tr><td colspan='6' style='text-align:center; color:#130f40;'>No Product record available at a moment</td></tr>";
              }
              ?>
            </tbody>

        </div>
        </table>
        <?php
        // Fetch search term if it's present
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $query = "SELECT * FROM laptops WHERE category LIKE '%$searchQueryData%' OR brand LIKE '%$searchQueryData%' OR model LIKE '%$searchQueryData%' OR processor LIKE '%$searchQueryData%'OR RAM LIKE '%$searchQueryData%'OR storage LIKE '%$searchQueryData%' OR price LIKE '%$searchQueryData%'OR quantity LIKE '%$searchQueryData%'OR serialNumber LIKE '%$searchQueryData%'OR date LIKE '%$searchQueryData%'OR delivery_date LIKE '%$searchQueryData%'OR total_age LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR person_name LIKE '%$searchQueryData%' OR status LIKE '%$searchQueryData%' ORDER BY id LIMIT {$offset}, {$limit}";
        $result = mysqli_query($con, query: $query);
        // Fetch the total number of records based on search query
        $total_query = "SELECT COUNT(*) as total FROM laptops WHERE category LIKE '%$searchQueryData%' OR brand LIKE '%$searchQueryData%' OR model LIKE '%$searchQueryData%' OR processor LIKE '%$searchQueryData%'OR RAM LIKE '%$searchQueryData%'OR storage LIKE '%$searchQueryData%' OR price LIKE '%$searchQueryData%'OR quantity LIKE '%$searchQueryData%'OR serialNumber LIKE '%$searchQueryData%'OR date LIKE '%$searchQueryData%'OR delivery_date LIKE '%$searchQueryData%'OR total_age LIKE '%$searchQueryData%' OR designation LIKE '%$searchQueryData%' OR person_name LIKE '%$searchQueryData%' OR status LIKE '%$searchQueryData%'";
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
      const selectedLimit = $("#selectlimit").val();
      const currentSearchQuery = $("#searchTable").val();
      const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

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
            url: 'delete-product.php',
            type: 'GET',
            data: {
              id: productId,
              page: currentPage,
              search: currentSearchQuery,
              "select-record": selectedLimit
            },
            success: function(response) {
              let res;
              try {
                res = JSON.parse(response);
              } catch (e) {
                Swal.fire("Error!", "Invalid response from server.", "error");
                return;
              }

              if (res.status === 'success') {
                Swal.fire("Deleted!", "Your record has been deleted.", "success");
                setTimeout(() => {
                  window.location.href = `View-products.php?page=${res.redirectPage}&select-record=${selectedLimit}&search=${encodeURIComponent(currentSearchQuery)}`;
                }, 1500);
              } else {
                Swal.fire("Error!", res.message || "Failed to delete the product.", "error");
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
  <!-- External jquery, popper File Link for bootstrap 4 -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Bootstrap 4 (JS) -->
  <script src="../Bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="script.js"></script>
  <script src="ajax-product.js"></script>

  <script>
    //ajax code tpo fetch product data on dashboard
    $(document).ready(function() {
      function fetchData(page = 1, limit = $("#selectlimit").val(), searchQuery = $("#searchTable").val()) {
        $.ajax({
          url: "View-products.php",
          type: "GET",
          data: {
            "page": page,
            "select-record": limit,
            "search": searchQuery // Pass the search query here
          },
          success: function(response) {
            var updatedTable = $(response).find("#productTable").html();
            $("#productTable").html(updatedTable);

            var updatedPagination = $(response).find(".pagination-part").html();
            $(".pagination-part").html(updatedPagination);

            // Update the URL without reloading the page
            var newUrl = "View-products.php?page=" + page + "&select-record=" + limit + "&search=" + searchQuery;
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
        url: "update-product.php",
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

          // Perform AJAX request to load the Add Category page content
          $.ajax({
            url: 'AddProducts.php',
            method: 'GET',
            dataType: 'html',
            success: function(response) {
              // Replace the page content with the response from AddCategory.php
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
  </script>

</body>

</html>