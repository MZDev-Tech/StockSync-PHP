<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');


// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

// code to check if admin has submit form

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_data'])) {
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
    $totalDays = $interval->d;

    // // Create total_age in years and months with singular/plural terms
    // $yearLabel = ($totalYears == 1) ? 'y' : 'years';
    // $monthLabel = ($totalMonths == 1) ? 'month' : 'months';

    if ($totalYears > 0 && $totalMonths > 0) {
        $total_age = "{$totalYears}y, {$totalMonths}m";
    } elseif ($totalYears > 0) {
        $total_age = "{$totalYears}y";
    } elseif ($totalMonths > 0) {
        $total_age = "{$totalMonths}m";
    } elseif ($totalDays > 0) {
        $total_age = "{$totalDays}d";
    } else {
        $total_age = "Today";
    }


    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $image;
    }

    $query = "Insert into laptops(`category`,`brand`, `model`, `processor`,`RAM`,`storage`,`price`, `quantity`,`serialNumber`, `description`, `image`,`delivery_date`,`person_name`,`designation`,`status`,`total_age`) values('$category','$brand','$model','$processor','$RAM','$storage','$price','$quantity','$serialNumber','$description','$imagePath','$delivery_date','$person_name','$designation','$status','$total_age')";
    $result = mysqli_query($con, $query);
    if ($result) {
        // Get the last inserted product ID
        $product_id = mysqli_insert_id($con);

        // Insert notification into the database
        $notify_title = "Inventory Revamped! ";
        $notify_message = " New '$category' from $brand brand added";
        $image = '../Images/notify-product.gif';

        $notify_query = "INSERT INTO notifications (`type`,`image`, `related_id`, `title`,`message`, `status`) VALUES ('product', ?, ?,?,?, 'unread')";
        $notify_stmt = mysqli_prepare($con, $notify_query);
        mysqli_stmt_bind_param($notify_stmt, 'siss', $image, $product_id, $notify_title, $notify_message);
        mysqli_stmt_execute($notify_stmt);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'New product record added successfully.', 'redirect' => 'View-products.php']);
    } else {

        echo json_encode(['status' => 'error', 'message' => 'Something went wrong while adding..']);
    }
    exit();
}

?>




<!-- Record Table -->
<div class="form-parent">

    <div class="form-records">
        <div class="container mt-4">
            <form method="POST" id="insertForm" action="" enctype="multipart/form-data">
                <h4 class="mb-4 text-center">Add New Product</h4>

                <!-- Information Section -->
                <div class="section">
                    <p class="sec-title"><span class="las la-sort"></span> System Overview</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="brand" placeholder="Brand name"
                                    name="brand" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="" selected> Select </option>
                                <?php
                                $list = mysqli_query($con, 'select * from category');
                                while ($row = mysqli_fetch_assoc($list)) {
                                ?>
                                    <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="processor" class="form-label">Processor</label>
                            <input type="text" name="processor" class="form-control"
                                placeholder="Enter processor" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="RAM" class="form-label">RAM</label>
                            <input type="text" name="RAM" class="form-control" placeholder="Enter RAM"
                                required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Enter price"
                                required>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" class="form-control" required>

                        </div>


                    </div>



                    <div class="section">
                        <p class="sec-title"><span class="las la-sort"></span> Product Information</p>
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" class="form-control" placeholder="Enter model"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="storage" class="form-label">Storage</label>
                                <input type="text" name="storage" class="form-control"
                                    placeholder="Enter storage" required>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="text" name="quantity" class="form-control"
                                    placeholder="Enter quantity" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="serialNumber" class="form-label">Serial No.</label>
                                <input type="text" name="serialNumber" class="form-control"
                                    placeholder="Serial number" required>

                            </div>
                        </div>
                    </div>


                    <div class="section">
                        <p class="sec-title"><span class="las la-sort"></span> System Status</p>
                        <div class="row">


                            <div class="col-md-4 mb-3">
                                <label for="designation">Designation</label>
                                <input type="text" name="designation" class="form-control"
                                    placeholder="Enter designation" required>

                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status">Status</label>
                                <input type="text" name="status" class="form-control" placeholder="Enter status"
                                    required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="person_name">Person Name</label>
                                <input type="text" name="person_name" class="form-control"
                                    placeholder="Enter person" required>
                            </div>
                        </div>


                        <div class="section">
                            <p class="sec-title"><span class="las la-sort"></span> File Upload Section</p>
                            <div class="row">

                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" placeholder="Type here.."
                                        required></textarea>

                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label class="form-label">Upload Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>

                                <br>

                                <div class="form-group col-md-12 mb-3 mt-2">
                                    <button type="submit" name="submit" class="btn btn-info">Add
                                        Product</button>
                                    <button onclick="window.location.href='View-products.php'" class="btn btn-secondary ml-2">Move Back</button>

                                </div>
                            </div>
                        </div>
                    </div>





                    <!-- Full Width Inputs -->





            </form>
        </div>

    </div>
</div>