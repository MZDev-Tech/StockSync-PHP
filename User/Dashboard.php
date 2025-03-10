<?php
session_name("USER_SESSION");
session_start();
include '../vendor/autoload.php';
include('../connection.php');

// file to not allow user to directly access user panel until they are login
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
          <div class="alert alert-success data-dismissible fade show" id="alertMessage"
            style="width: 100%; margin: 10px 20px 16px 40px; padding:16px; font-size:14px">
            <strong>Success! </strong>
            <?php echo $_SESSION['message'] ?>
            <button type="button" data-dismiss="alert" class="close" aria-label="close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>
        <?php unset($_SESSION['message']);
        } ?>



        <div class="col-lg-12 mb-6">
          <div class="card welcome-card" style="margin: 0 25px !important;">
            <div class="row align-items-start">
              <!-- Text Section -->
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title mb-3 admin-welcome">Welcome
                    <?php echo isset($user_name) ? $user_name : 'User' ?>
                    !
                  </h5>
                  <p class="mb-6">We're glad to have you here. Explore your profile to see updates and personalized
                    features.</p>
                  <a href="User-profile.php" class="btn btn-sm btn-profile">Go to Profile</a>
                </div>
              </div>
              <!-- Image Section -->
              <div class="col-sm-5 text-center">
                <img src="../Images/admin.png" alt="Badge Image" height="175" class="w-100">
              </div>
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
      ?>
      <div class="card-grid">
        <div class="card-wrapper">
          <div class="card ">
            <div class="child-content">
              <h2>0<?php echo $product_count ?></h2>
              <p>Total Products</p>
            </div>
            <div class="icon-wrap">
              <i class="fa-regular fa-clipboard"></i>
            </div>
          </div>
        </div>

        <div class="card-wrapper">
          <div class="card ">
            <div class="child-content">
              <h2>0<?php echo $category_count ?></h2>
              <p>Total Categories</p>
            </div>
            <div class="icon-wrap">
              <i class="fa-regular fa-clock"></i>
            </div>
          </div>
        </div>

        <div class="card-wrapper">
          <div class="card ">
            <div class="child-content">
              <h2>200</h2>
              <p>Total Requests</p>
            </div>
            <div class="icon-wrap">
              <i class="fa-regular fa-envelope"></i>
            </div>
          </div>
        </div>

        <div class="card-wrapper">
          <div class="card ">
            <div class="child-content">
              <h2>100</h2>
              <p>Total Feedback</p>
            </div>
            <div class="icon-wrap">
              <i class="fa-regular fa-message"></i>
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
                <th>ID</th>
                <th><span class="las la-sort"></span>Product</th>
                <th><span class="las la-sort"></span>Model</th>
                <th><span class="las la-sort"></span>RAM</th>

            </thead>

            <?php
            include('../connection.php');
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

            $offset = ($page - 1) * $limit;
            $query = "select * from laptops ORDER BY id LIMIT {$offset},{$limit}";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
            ?>
              <tbody>
                <tr>
                  <td>#
                    <?php echo $row['id']; ?>.
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

      <?php } ?>
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

  <script src="../Bootstrap/js/jquery.min.js"></script>
  <script src="../Bootstrap/js/popper.min.js"></script>

  <!-- Bootstrap 4 (JS) -->
  <script src="../Bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="script.js"></script>
</body>

</html>