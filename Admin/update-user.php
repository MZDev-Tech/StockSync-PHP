<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');
// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');



// code to check if admin has submit data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_data']))) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $_POST['img'];
    }

    $query = "update user set name=?, email=?, designation=?, phone=?,address=?, password=?,image=? where id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssisssi', $name, $email, $designation, $phone, $address, $password, $imagePath, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.', 'redirect' => 'View-user.php']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Something went wrong while updating.']);
    }


    mysqli_stmt_close($stmt);
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
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
            $role = 'user';
            $query = "select * from user where id='$id' && role='$role'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="form-parent">
                    <div class="form-records">
                        <form method="POST" action="" id="updateForm" enctype="multipart/form-data">
                            <h4 style="text-align:center; margin:10px 0 14px 0">Update User</h4>
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
                                <input type="text" name="designation" placeholder="Enter designation" class="form-control" value="<?php echo $row['designation']; ?>"
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
                                } ?>
                                <input type="hidden" name="img" value="<?php echo $row['image']; ?>" style="text-transform:none;">
                            </div>



                        <?php } ?>
                        <div class="form-group">
                            <b>Upload Image</b><br>
                            <input type="file" name="image" class="form-control">
                        </div>


                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info">Update Data
                            </button>
                        </div>
                        </form>

                    </div>
                </div>

        </main>

    </section>
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
    <!-- External jquery, popper File Link for bootstrap 4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            $('#updateForm').on('submit', function(e) {
                e.preventDefault();
                let formdata = new FormData(this);
                formdata.append('save_data', true);

                $.ajax({
                    url: '',
                    method: 'POST',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,

                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }

                    },
                    catch (error) {
                        console.log('Invalid json response while updating user ', response);
                        Swal.fire('Error', 'Invalid Json response', 'error');
                    }
                });
            });
        });
    </script>
</body>

</html>