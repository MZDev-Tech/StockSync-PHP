<?php
session_start();
include('../connection.php');

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

function validateInput($data) {
    return htmlentities(trim(stripslashes($data)));
}

// Array to store validation errors
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name (letters and spaces only)
    $name = validateInput($_POST['name']);
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $error['name'] = "Only letters & spaces are allowed in the name";
    }

    // Validate email
    $email = validateInput($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email format";
    }else {
        // Check if email already exists in the database
        $query = "SELECT id FROM user WHERE email = '$email'";
        $result=mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0) {
            $error['email'] = "Email already exists.";
        }
      
    }

    // Validate phone (exactly 10 digits)
    $phone = validateInput($_POST['phone']);
    if (!preg_match("/^[0-9]{11,13}$/", $phone)) {
        $error['phone'] = "Phone number must be 11 or 13 digits";
    }

    // Validate password (at least 6 characters)
    $password = validateInput($_POST['password']);
    if (strlen($password) < 6) {
        $error['password'] = "Password must be at least 6 characters long";
    }

    // Validate image upload
    if ($_FILES['image']['error'] == 0) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($imageFileType, $allowedExtensions)) {
            $error['image'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) { 
            $error['image'] = "Image size must be less than 2MB.";
        }
    } else {
        $error['image'] = "Image upload is required.";
    }

    // If no errors, insert into database
    if (empty($error)) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $designation = mysqli_real_escape_string($con, $_POST['designation']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $status='Inactive';

        $imagePath = "../Images/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

        $query = "INSERT INTO user(`name`, `email`,`designation`, `phone`,`address`, `password`, `image`,`status`) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssissss', $name, $email,$designation, $phone,$address, $password, $imagePath,$status);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = 'User added successfully.';
            header('Location: View-user.php');
            exit();
        } else {
            $_SESSION['message'] = 'Something went wrong while adding.';
        }

        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
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
       <?php include('Header.php')?>


        <!----------------Main Page Design--------------------->
        <main id="page-content">
           

            <!-- Record Table -->
            <div class="form-parent">

            <div class="form-records">
                <form method="POST" action="" enctype="multipart/form-data">
                    <h4>Add New User</h4><br>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Username " value="<?php echo (isset($_POST['name'])? htmlspecialchars($_POST['name']) :'' )?>" class="form-control" required>
                        <?php if(isset($error['name']))  echo "<p style='font-size:12px; color:red'> {$error['name']} </p>"?>
                    </div>
                   
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email ID" value="<?php echo (isset($_POST['email'])? htmlspecialchars($_POST['email']) : '')?>" class="form-control" required>
                        <?php if (isset($error['email'])) echo "<p style='font-size:12px; color:red;'>{$error['email']}</p>"; ?>

                    </div>
                    <div class="form-group">
                        <input type="text" name="designation" placeholder="Company designation"  class="form-control" required>

                    </div>

                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Phone Number" class="form-control" value="<?php echo (isset($_POST['phone'])? htmlspecialchars($_POST['phone']) : '')?>" required>
                        <?php if(isset($error['phone']))  echo "<p style='font-size:12px; color:red'> {$error['phone']} </p>"?>

                    </div>

                    <div class="form-group">
                        <input type="text" name="address" placeholder="Address"  class="form-control" required>

                    </div>

                    <div class="form-group">
                        <input type="text" name="password" placeholder="Password " value="<?php echo (isset($_POST['password'])? htmlspecialchars($_POST['password']) : '')?>" class="form-control" required>
                        <?php if(isset($error['password']))  echo "<p style='font-size:12px; color:red'> {$error['password']} </p>"?>

                    </div>


                    <div class="form-group">
                        <label style="font-weight:500;">Upload Image</label><br>
                        <input type="file" name="image" class="form-control" required>
                    </div>


                    <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-info">Register User
                    </button>                    </div>
                </form>

            </div>
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