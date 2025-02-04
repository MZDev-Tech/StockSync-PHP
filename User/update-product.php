<?php
session_start();
include('../connection.php');
// Code to not allow admin to directly access admin panel until they are logged in
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location:../user-login.php');
    exit();
}

// Code to check if admin has submitted data
if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $brand = mysqli_real_escape_string($con, $_POST['brand']);
    $model = mysqli_real_escape_string($con, $_POST['model']);
    $processor = mysqli_real_escape_string($con, $_POST['processor']);
    $RAM = mysqli_real_escape_string($con, $_POST['RAM']);
    $storage = mysqli_real_escape_string($con, $_POST['storage']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $serialNumber = mysqli_real_escape_string($con, $_POST['serialNumber']);
    $delivery_date = mysqli_real_escape_string($con, $_POST['delivery_date']);
    $person_name = mysqli_real_escape_string($con, $_POST['person_name']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

     // Calculate total_age
     $currentDate = new DateTime();
     $deliveryDateObject = new DateTime($delivery_date);
     $interval = $currentDate->diff($deliveryDateObject);
 
     $totalYears = $interval->y;
     $totalMonths = $interval->m;
 
     // Create total_age in years and months with singular/plural terms
     $yearLabel = ($totalYears == 1) ? 'year' : 'years';
     $monthLabel = ($totalMonths == 1) ? 'month' : 'months';
 
     if ($totalYears > 0 && $totalMonths > 0) {
         $total_age = "{$totalYears} {$yearLabel}, {$totalMonths} {$monthLabel}";
     } elseif ($totalYears > 0) {
         $total_age = "{$totalYears} {$yearLabel}";
     } elseif ($totalMonths > 0) {
         $total_age = "{$totalMonths} {$monthLabel}";
     } else {
         $total_age = "Less than 1 month";
     }


    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $_POST['img'];
    }

    $query = "UPDATE laptops SET category='$category', brand='$brand', model='$model', processor='$processor', RAM='$RAM', storage='$storage', price='$price', quantity='$quantity', serialNumber='$serialNumber',delivery_date='$delivery_date',total_age='$total_age',person_name='$person_name',designation='$designation',status='$status', description='$description', image='$imagePath' WHERE id='$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $_SESSION['message'] = 'Record Updated successfully..';
        header('Location: View-products.php');
        exit();
    } else {
        $_SESSION['message'] = 'Something went wrong while updating..';
        header('Location: View-products.php');
        exit();
    }
}
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
<style>
    label {
        font-size: 16px;
        color: #000;
        font-weight: 500;

        padding-left: 6px;

    }
</style>

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
            $query = "SELECT * FROM laptops WHERE id='$id'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>


                <div class="form-parent">

                    <div class="form-records">
                        <div class="container mt-4">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <h4 class="mb-4 text-center">Update Product Data</h4>
                                <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                                </div>
                                <!-- Information Section -->
                                <div class="section">
                                    <p class="sec-title"><span class="las la-sort"></span> System Overview</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Brand</label>
                                                <input type="text" class="form-control" id="brand" placeholder="Enter brand"
                                                    name="brand" value="<?php echo $row['brand'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select class="form-control" name="category" id="category">
                                                <?php
                                                if (empty($row['category'])) {
                                                    echo '<option value="" selected> Select category</option>';
                                                }
                                                $list = mysqli_query($con, 'SELECT * FROM category');
                                                while ($category_result = mysqli_fetch_assoc($list)) {
                                                    ?>
                                                    <option value="<?php echo $category_result['name']; ?>" <?php if ($row['category'] == $category_result['name'])
                                                           echo 'selected'; ?>>
                                                        <?php echo $category_result['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="processor" class="form-label">Processor</label>
                                            <input type="text" name="processor" placeholder="Enter processor"
                                                class="form-control" value="<?php echo $row['processor'] ?>" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="RAM" class="form-label">RAM</label>
                                            <input type="text" name="RAM" placeholder="Enter RAM" class="form-control"
                                                value="<?php echo $row['RAM'] ?>" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="text" name="price" class="form-control"
                                                value="<?php echo $row['price'] ?>" placeholder="Enter price" required>

                                        </div>

                                        <di class="col-md-4 mb-3">
                                            <label for="delivery_date" class="form-label">Delivery Date</label>
                                            <input type="date" name="delivery_date" class="form-control"
                                                value="<?php echo date('Y-m-d', strtotime($row['delivery_date'])) ?>"
                                                required>

                                    </div>


                                </div>



                                <div class="section">
                                    <p class="sec-title"><span class="las la-sort"></span> Product Information</p>
                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="model" class="form-label">Model</label>
                                            <input type="text" name="model" class="form-control"
                                                value="<?php echo $row['model'] ?>" placeholder="Enter model" required>

                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="storage" class="form-label">Storage</label>
                                            <input type="text" name="storage" class="form-control"
                                                value="<?php echo $row['storage'] ?>" placeholder="Enter storage" required>

                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="text" name="quantity" placeholder="Enter quantity"
                                                class="form-control" value="<?php echo $row['quantity'] ?>" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="serialNumber" class="form-label">Serial No.</label>
                                            <input type="text" name="serialNumber" class="form-control"
                                                value="<?php echo $row['serialNumber'] ?>" placeholder="Enter Sr-No."
                                                required>

                                        </div>
                                    </div>
                                </div>


                                <div class="section">
                                    <p class="sec-title"><span class="las la-sort"></span> System Status</p>
                                    <div class="row">


                                        <div class="col-md-4 mb-3">
                                            <label for="designation">Designation</label>
                                            <input type="text" name="designation" placeholder="Enter designation"
                                                class="form-control" value="<?php echo $row['designation'] ?>" required>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="status">Status</label>
                                            <input type="text" name="status" placeholder="Enter status" class="form-control"
                                                value="<?php echo $row['status'] ?>" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="person_name">Person Name</label>
                                            <input type="text" name="person_name" placeholder="Enter person"
                                                class="form-control" value="<?php echo $row['person_name'] ?>" required>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <p class="sec-title"><span class="las la-sort"></span> File Upload Section</p>
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" placeholder="Enter details"
                                                    class="form-control" col="4" row="4"
                                                    value="<?php echo $row['description'] ?>"
                                                    required><?php echo $row['description'] ?></textarea>

                                            </div>

                                            <div class="form-group col-md-12 mb-3">
                                                <label for="currentImage">Current Image</label><br>
                                                <img src="../Images/<?php echo $row['image']; ?>"
                                                    style="width:80px; height:80px; border-radius:5px; border: 3px solid #d5d7da;">
                                                <input type="hidden" name="img" value="<?php echo $row['image']; ?>"
                                                    class="form-control" readonly>
                                            </div>

                                            <div class="form-group col-md-12 mb-3">
                                                <label for="image">Upload New Image</label><br>
                                                <input type="file" name="image" class="form-control" id="image">
                                            </div>

                                            <br>

                                            <div class="form-group col-md-12 mb-3 mt-2">
                                                <button type="submit" name="submit" class="btn btn-info">Update
                                                    Product</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <!-- Full Width Inputs -->





                            </form>
                        </div>

                    </div>
                </div>


            <?php } ?>
        </main>
    </section>

    <script>
        //js code to check if input field has value to add bg color in input

        document.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('input', () => {
                if (field.value.trim() !== '') {
                    field.classList.add('has-value');
                } else {
                    field.classList.remove('has-value');
                }
            });

            // Add event listener for select fields
            field.addEventListener('change', () => {
                if (field.value.trim() !== '') {
                    field.classList.add('has-value');
                } else {
                    field.classList.remove('has-value');
                }
            });

            // Initial check when page loads (if there’s already a value)
            if (field.value.trim() !== '') {
                field.classList.add('has-value');
            }
        });

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>