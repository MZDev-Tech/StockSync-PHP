<?php
session_name("ADMIN_SESSION");
session_start();
include '../vendor/autoload.php';
include('../connection.php');

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">

  <!-- External CSS File Link -->
  <link rel="stylesheet" href="../CSS/style.css">
  <!-- Font Icons Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <script>
    $(document).ready(function() {
      setTimeout(function() {
        $('#alertMessage').fadeOut('slow')
      }, 3000)
    })
  </script>
</head>

<body>

  <style>
    .card-grid .card {
      cursor: pointer;

    }

    .card-grid .card:hover {
      background-color: rgb(213, 238, 248);
    }

    a.btn-profile {
      font-size: 14px;
      color: #729b8c;
      border: 1px solid #729b8c;
      margin-right: 12px;
      transition: all .3s ease;
    }

    a.btn-profile:hover {
      background: #729b8c;
      color: #fff;
    }

    h5.admin-welcome {
      color: #729b8c !important;
    }
  </style>
  <!-----------SideBar Section------------------->
  <?php include('sidebar.php'); ?>

  <!----------------Main Header Section--------------------->
  <section id="main-page">

    <?php include("Header.php"); ?>
    <main id="page-content">


      <div class="row">
        <div class="col-lg-12 mb-6 page-name">
          <h2>Dashboard</h2>
          <h5>Home / Dashboard</h5>
        </div>


        <!-----------alert message------------->
        <?php if (isset($_SESSION['message'])) { ?>
          <div class="alert alert-success alert-dismissible fade show" id="alertMessage"
            style="width: 100%; margin: 10px 40px 16px 40px; padding:16px; font-size:14px">
            <strong>Success! </strong>
            <?php echo $_SESSION['message'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

        <?php unset($_SESSION['message']);
        } ?>

        <div class="dashboard-parent">
          <div class="dashboard-left">

            <div class="col-lg-12 mb-6" style="padding-left:0;padding-right:0">
              <div class="card welcome-card" style="margin: 0 25px !important; padding:2px 12px">
                <div class="row align-items-start">
                  <!-- Text Section -->
                  <div class="col-sm-7">
                    <div class="card-body">
                      <h5 class="card-title mb-3 admin-welcome">Welcome
                        <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin' ?>
                        !
                      </h5>
                      <p class="mb-6">We're glad to have you here. Explore your profile to see updates and personalized
                        features.</p>
                      <a href="Admin-profile.php" class="btn btn-sm btn-profile">Go to Profile</a>
                    </div>
                  </div>
                  <!-- Image Section -->
                  <div class="col-sm-5 text-center">
                    <img src="../Images/dashboard.gif" alt="Badge Image" height="185" class="w-100">

                  </div>
                </div>
              </div>
            </div>

            <!---------Card design------>
            <?php
            // Fetch total number of products
            $query = "SELECT COUNT(*) as total_products FROM laptops";
            $product_result = mysqli_query($con, $query);
            $product_count = mysqli_fetch_assoc($product_result)['total_products'];

            // Fetch total number of categories
            $query = "SELECT COUNT(*) as total_categories FROM category";
            $category_result = mysqli_query($con, $query);
            $category_count = mysqli_fetch_assoc($category_result)['total_categories'];

            //fetch total number of registered users
            $query = "SELECT COUNT(*) as total_users FROM user where role='user'";
            $user_result = mysqli_query($con, $query);
            $user_count = mysqli_fetch_assoc($user_result)['total_users'];

            //fetch total number of files
            $query = "SELECT COUNT(*) as total_file FROM documents";
            $file_result = mysqli_query($con, $query);
            $file_count = mysqli_fetch_assoc($file_result)['total_file'];
            ?>
            <div class="card-grid">
              <div class="card-wrapper">
                <div class="card ">
                  <div class="child-content">
                    <h2 style="color: #db825c;" id="product-count">0</h2>
                    <p>Total Products</p>
                  </div>
                  <div class="icon-wrap">
                    <img src="../Images/box.gif" alt="" width="50" height="50">
                  </div>
                </div>
                <div class="card-footer bg-c-yellow">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <a href="View-products.php" class="text-white m-b-0">View</a>
                    </div>
                    <div class="col-3 text-right">
                      <span class="material-icons" style="color:#fff">trending_up</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-wrapper">
                <div class="card ">
                  <div class="child-content">
                    <h2 style="color: #1e8d66;" id="category-count">0</h2>
                    <p>Total Categories</p>
                  </div>
                  <div class="icon-wrap">
                    <img src="../Images/checklist.gif" alt="" width="50" height="50">
                  </div>
                </div>
                <div class="card-footer bg-c-yellow">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <a href="View-category.php" class="text-white m-b-0">View</a>
                    </div>
                    <div class="col-3 text-right">
                      <span class="material-icons" style="color:#fff">trending_up</span>
                    </div>
                  </div>
                </div>

              </div>

              <div class="card-wrapper">
                <div class="card ">
                  <div class="child-content">
                    <h2 style="color:#692377" id="file-count">0</h2>
                    <p>Total Documents</p>
                  </div>
                  <div class="icon-wrap">
                    <img src="../Images/document.gif" alt="" width="50" height="50">
                  </div>
                </div>
                <div class="card-footer bg-c-yellow">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <a href="view-document.php" class="text-white m-b-0">View</a>
                    </div>
                    <div class="col-3 text-right">
                      <span class="material-icons" style="color:#fff">trending_up</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-wrapper">
                <div class="card ">
                  <div class="child-content">
                    <h2 id="user-count" style="color:#368d8f">0</h2>
                    <p>Total Users</p>
                  </div>
                  <div class="icon-wrap">
                    <img src="../Images/user.gif" alt="" width="50" height="50">
                  </div>
                </div>
                <div class="card-footer bg-c-yellow">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <a href="View-user.php" class="text-white m-b-0">View</a>
                    </div>
                    <div class="col-3 text-right">
                      <span class="material-icons" style="color:#fff">trending_up</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="widget-container dashboard-right">
            <div class=" white_card_body pt_25">
              <div class="project_complete">
                <div class="single_pro d-flex">
                  <div class="probox"></div>
                  <div class="box_content">
                    <h4>5685</h4>
                    <span>Project completed</span>
                  </div>
                </div>
                <div class="single_pro d-flex">
                  <div class="probox blue_box"></div>
                  <div class="box_content">
                    <h4 class="bluish_text">5685</h4>
                    <span class="grayis_text">Project completed</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!------------------Recent Product Design----------------------->

        <div class="records">
          <div class="record-header">
            <div>
              <h4>Recent Products</h4>
              <p>Reviewing the entries to make the required updates</p>
            </div>
            <a href="view-products.php" class="add-topbtn">View Record</a>
          </div>

          <?php
          include('../connection.php');
          $limit = isset($_GET['select-record']) ? (int) $_GET['select-record'] : 3;
          $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
          $offset = ($page - 1) * $limit;
          $query = "select * from laptops ORDER BY id LIMIT {$offset},{$limit}";
          $stmt = mysqli_prepare($con, $query);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          ?>

          <form method="GET" action="">

            <div class="select-box">
              <label>Show
                <select name="select-record" class="select-btn" onchange="this.form.submit()">
                  <option value="3" <?php echo $limit == 3 ? 'selected' : '' ?>>3</option>
                  <option value="5" <?php echo $limit == 5 ? 'selected' : '' ?>>5</option>
                  <option value="10" <?php echo $limit == 10 ? 'selected' : '' ?>>10</option>

                </select> entries</label>
            </div>
          </form>

          <div class="table-section">
            <table width="100%" class="table">
              <thead>
                <tr>
                  <th>S-N</th>
                  <th><span class="las la-sort"></span>Product</th>
                  <th><span class="las la-sort"></span>Model</th>
                  <th><span class="las la-sort"></span>RAM</th>

              </thead>

              <?php
              include('../connection.php');
              $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
              $Sr = 1;
              $offset = ($page - 1) * $limit;
              $query = "select * from laptops ORDER BY id LIMIT {$offset},{$limit}";
              $result = mysqli_query($con, $query);
              while ($row = mysqli_fetch_array($result)) {
              ?>
                <tbody>
                  <tr>
                    <td>#
                      <?php echo $Sr ?>
                    </td>

                    <td class="product-data">
                      <img src="../Images/<?php echo $row['image']; ?>">
                      <?php echo $row['brand']; ?>
                    </td>

                    <td>
                      <?php echo $row['model']; ?>
                    </td>

                    <td>
                      <?php echo $row['RAM']; ?>
                    </td>



                  </tr>

                </tbody>




          </div>

        <?php $Sr++;
              } ?>
        </table>

        <?php

        $query = "select COUNT(*) as total from laptops";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $total_records = $row['total'];
        $total_pages = ceil($total_records / $limit);
        ?>
        <div class="pagination-part">
          <div class="pagination-info">Showing <?php echo ($offset + 1) ?> to <?php echo min($offset + $limit, $total_records) ?> of <?php echo $total_records ?> entries</div>
          <?php
          echo '<div class="pagination-btns">';
          if ($page > 1) {
            echo ' <a class="paginate_button previous " href="Dashboard.php?page=' . ($page - 1) . '"><i class="fas fa-chevron-left"></i></a>';
          }
          for ($i = 1; $i <= $total_pages; $i++) {

            if ($i == $page) {
              $active = 'current';
            } else {
              $active = '';
            }
            echo '<a class="paginate_button ' . $active . '" href="Dashboard.php?page=' . $i . '">' . $i . '</a>';
          }
          if ($total_pages > $page) {
            echo '<a class="paginate_button next" href="Dashboard.php?page=' . ($page + 1) . '"><i class="fas fa-chevron-right"></i></a>';
          }
          echo '</div>';

          ?>
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
  <script>
    //traget where we will show the animated value in HTML and finalvalue is value coming from DB
    function animateCount(target, finalValue) {
      let start = 0;
      let end = 200;
      let duration = 5000; // (5 seconds)
      let intervalTime = duration / end; // Time per increment is 20ms

      let interval = setInterval(() => {
        start++;
        target.textContent = (start < 10 ? "0" : "") + start + "+"; // Ensures '0' appears if <10

        if (start >= end) {
          clearInterval(interval);
          // Ensure proper formatting of final value
          let formattedFinalValue = finalValue < 10 ? "0" + finalValue : finalValue;
          target.textContent = formattedFinalValue + "+";
        }
      }, intervalTime);
    }

    // Get original DB values from PHP
    let productCount = <?php echo $product_count; ?>;
    let categoryCount = <?php echo $category_count; ?>;
    let fileCount = <?php echo $file_count; ?>;
    let userCount = <?php echo $user_count; ?>;

    // Start animation
    animateCount(document.getElementById("product-count"), productCount);
    animateCount(document.getElementById("category-count"), categoryCount);
    animateCount(document.getElementById("file-count"), fileCount);
    animateCount(document.getElementById("user-count"), userCount);
  </script>


</body>

</html>