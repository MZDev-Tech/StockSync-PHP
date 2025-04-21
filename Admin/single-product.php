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
          } ?>
          <ul class="left-downpart">
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
            <a href="update-product.php?id=<?php echo $row['id'] ?>" class="btn btn-info update-link" data-id="<?php echo $row['id'] ?>">Update Data</a>
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