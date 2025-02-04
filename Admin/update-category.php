<?php
session_start();
include('../connection.php');
// code to not allow admin to directly access admin panel until they are login

if (!isset($_SESSION['id']) && empty($_SESSION['id'])) {
    header('Location:../admin-login.php');
    exit();

}

// code to check if admin has submit data
if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $detail = mysqli_real_escape_string($con, $_POST['detail']);

    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/".basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);
    } else {
        $imagePath = $_POST['img'];
    }

    $query = "update category set name=?, detail=?,image=? where id=?";
    $stmt=mysqli_prepare($con,$query);
    mysqli_stmt_bind_param($stmt,'sssi',$name,$detail,$imagePath,$id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        $_SESSION['message']='Record Updated successfully..';
    } else {
        $_SESSION['message']='Something went wronh while updating..';
    }
    mysqli_stmt_close($stmt);
    header('Location:View-category.php');
        exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
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
            $query = "select * from category where id='$id'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
           <div class="form-parent">
                <div class="form-records">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <h4 style="text-align:center; margin:10px 0 14px 0">Update Category</h4>
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                        </div>

                        <div class="form-group">
                            <label style="color:black">Category Name</label>
                            <input type="text" name="name" placeholder="Enter category" class="form-control" value="<?php echo $row['name']; ?>"
                                required>
                        </div>

                        
                        <div class="form-group">
                        <label style="color:black">Description</label>
                        <textarea type="text" name="detail" placeholder="Enter details.." class="form-control"
                        value="<?php echo $row['detail']; ?>"><?php echo $row['detail']; ?></textarea>                        </div>


                        
                        <div class="form-group">
                            <img src="../Images/<?php echo $row['image']; ?>"
                                style="width:80px; height:80px; border-radius:5px; border: 3px solid #d5d7da; ">
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
    document.querySelectorAll('input,textarea').forEach(field=>{
     if(field.value.trim()!==''){
        field.classList.add('has-value');
     }

     field.addEventListener('input',()=>{
        if(field.value.trim()!==''){
        field.classList.add('has-value');
     }else{
        field.classList.remove('has-value');
     }
     })
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>