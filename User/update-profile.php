<?php
session_name("USER_SESSION");
session_start();
include('../connection.php');

// file to not allow user to directly access user panel until they are login
include('Check_token.php');

// Check if admin has submitted the data
if (isset($_POST['submit'])) {

    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);


    $password = $_POST['password'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $imagePath = '../Images/' . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $_POST['img'];
    }

    // Retrieve the current password from the database
    $query = "SELECT password FROM user WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Update admin record
    $query = "UPDATE user SET name=?, email=?, role=?, phone=?, address=?, password=?, image=? WHERE id=?";
    $stmt = mysqli_prepare($con, $query);

    // Bind the statement
    mysqli_stmt_bind_param($stmt, 'sssisssi', $name, $email, $role, $phone, $address, $password, $imagePath, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['message'] = 'Record updated successfully.';
    } else {
        $_SESSION['message'] = 'Something went wrong while updating.';
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    header('Location: User-profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>
<style>
    form input {
        text-transform: none;

    }

    form input::placeholder {
        font-size: 13px;
    }
</style>

<body>
    <?php include('sidebar.php'); ?>

    <section id="main-page">
        <?php include('Header.php'); ?>

        <main id="page-content">
            <?php
            include('../connection.php');
            $id = $_SESSION['id'];
            $role = 'user';
            $query = "SELECT * FROM user WHERE id=? && role='$role'";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="form-parent">
                    <div class="form-records">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <h4>Update Profile</h4><br>
                            <div class="form-group">
                                <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                            </div>

                            <div class="form-group">
                                <label style="color:black">Username</label>
                                <input type="text" name="name" placeholder="Enter user" class="form-control" value="<?php echo $row['name']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label style="color:black">Email ID</label>
                                <input type="text" name="email" placeholder="Enter email" class="form-control" value="<?php echo $row['email']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label style="color:black">Company Designation</label>
                                <input type="text" name="designation" placeholder="Enter designation" class="form-control" value="<?php echo $row['role']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label style="color:black">Phone Number</label>
                                <input type="text" name="phone" placeholder="Enter contact" class="form-control" value="<?php echo $row['phone']; ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label style="color:black">User Address</label>
                                <input type="text" name="address" placeholder="Enter address" class="form-control" value="<?php echo $row['address']; ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label style="color:black">Password</label>
                                <input type="text" name="password" placeholder="Enter password" class="form-control" value="<?php echo $row['password']; ?>"
                                    required>
                            </div>


                            <div class="form-group">
                                <?php if (!empty($row['image']) && file_exists($row['image'])) {
                                    echo '<img src="../Images/' . $row['image'] . '" class="ml-2" style="width:80px;  height:80px; border-radius:5px; border: 3px solid #d5d7da;">';
                                } else {
                                    echo '<img src="../Images/imgdefault.png " class="ml-2" style="width:80px; height:80px; border-radius:5px; border: 3px solid #d5d7da;">';
                                } ?> <input type="hidden" name="img" value="<?php echo $row['image']; ?>" style="text-transform:none;">
                            </div>

                        <?php } ?>
                        <div class="form-group">
                            <b>Upload Image</b><br>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info">Update Profile
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
        </main>
    </section>

    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="../Bootstrap/js/jquery.min.js"></script>
    <script src="../Bootstrap/js/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
        document.querySelectorAll('input').forEach(field => {
            if (field.value.trim() !== '') {
                field.classList.add('has-value');
            }

            field.addEventListener('input', () => {
                if (field.value.trim() !== '') {
                    field.classList.add('has-value');
                } else {
                    field.classList.remove('has-value');
                }
            })
        });
    </script>
</body>

</html>