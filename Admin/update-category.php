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
    $detail = mysqli_real_escape_string($con, $_POST['detail']);

    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $_POST['img'];
    }

    $query = "update category set name=?, detail=?,image=? where id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $detail, $imagePath, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        echo json_encode(['status' => 'success', 'message' => 'Record Updated successfully..', 'redirect' => 'View-category.php']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Something went wronh while updating..']);
    }
    mysqli_stmt_close($stmt);
    exit();
}

?>







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
            <form method="POST" action="" id="updateForm" enctype="multipart/form-data">
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
                        value="<?php echo $row['detail']; ?>"><?php echo $row['detail']; ?></textarea>
                </div>



                <div class="form-group">
                    <?php if (!empty($row['image']) && file_exists($row['image'])) {
                        echo '<img src="../Images/' . $row['image'] . '" class="ml-2" style="width:80px;  height:80px; border-radius:5px; border: 3px solid #d5d7da;">';
                    } else {
                        echo '<img src="../Images/productdefault.png " class="ml-2" style="width:80px; height:80px; border-radius:5px; border: 3px solid #d5d7da;">';
                    } ?>
                    <input type="hidden" name="img" value="<?php echo $row['image']; ?>" style="text-transform:none;">
                </div>



            <?php } ?>
            <div class="form-group">
                <b>Upload Image</b><br>
                <input type="file" name="image" class="form-control">
            </div>


            <div class="form-group mt-3">
                <button type="submit" name="submit" class="btn btn-info">Update Data
                </button>
                <button onclick="window.location.href='View-category.php'" class="btn btn-secondary ml-2">Move Back</button>

            </div>
            </form>

        </div>
    </div>