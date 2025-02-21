<?php
// file to not allow user to directly access user panel until they are login
include('Check_token.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Products</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- External CSS File Link -->
  <link rel="stylesheet" href="../CSS/style.css">
  <!-- Font Icons Link -->
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
      $query = "select * from laptops where id='$id'";
      $result = mysqli_query($con, $query);
      while ($row = mysqli_fetch_array($result)) {
      ?>

        <div class="detail-part">
          <div class="details-sec">
            <div class="product-details">
              <div class="part-left">
                <?php if (!empty($row['image']) && file_exists($row['image'])) {
                  echo '<img src="../Images/' . $row['image'] . '" >';
                } else {
                  echo '<img src="../Images/productdefault.png " >';
                } ?> <ul class="left-downpart">
                  <h3> System Overview</h3>
                  <div class="part2">
                    <li class="line1">
                      <p class="parah1"> <span><i class="fas fa-check"></i></span> Designation:</p>
                      <p class="parah2"><?php echo $row['designation'] ?></p>
                    </li>
                    <li class="line1">
                      <p class="parah1"> <span><i class="fas fa-check"></i></span> Person:</p>
                      <p class="parah2"> <?php echo $row['person_name'] ?></p>
                    </li>

                    <li class="line1">
                      <p class="parah1"><span><i class="fas fa-check"></i></span> Status:</p>
                      <p class="parah2"> <?php echo $row['status'] ?></p>
                    </li>
                  </div>


                </ul>
              </div>

              <div class="detail-part-right">
                <div class="top-heading">
                  <h2><?php echo $row['brand'] ?></h2>
                </div>
                <h3><?php echo $row['price'] ?>/-</h3>

                <div class="detail-btns">
                  <a class="btn btn-info" style="font-size:14px" href="update-product.php?id=<?php echo $row['id'] ?>">Update Data</a>
                  <a class="btn btn-secondary" style="font-size:14px" href="View-products.php">Go Back</a>
                </div>

                <ul class="data-product">
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> Processor</p>
                    <p class="parah2">: <?php echo $row['processor'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span>Quantity</p>
                    <p class="parah2">: <?php echo $row['quantity'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> RAM</p>
                    <p class="parah2">: <?php echo $row['RAM'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> Storage</p>
                    <p class="parah2">: <?php echo $row['storage'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> Serial No.</p>
                    <p class="parah2">: <?php echo $row['serialNumber'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> Delivery Date</p>
                    <p class="parah2">: <?php echo $row['delivery_date'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> Total Age</p>
                    <p class="parah2">: <?php echo $row['total_age'] ?></p>
                  </li>
                  <li class="line1">
                    <p class="parah1"><span class="las la-sort"></span> Entry Data:</p>
                    <p class="parah2"> <?php echo $row['date'] ?></p>
                  </li>

                </ul>
              </div>
            </div>
            <div class="detail-parah">
              <h4>More About Product</h4>
              <p class="parah-data"><?php echo $row['description'] ?></p>
            </div>
          </div>
        </div>




      <?php } ?>



      </div>


    </main>

  </section>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="script.js"></script>
</body>

</html>