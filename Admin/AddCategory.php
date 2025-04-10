<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');
include('Check_token.php');


if (isset($_POST['save_data'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $detail = mysqli_real_escape_string($con, $_POST['detail']);

    $image = $_FILES['image']['name'];
    if ($image) {
        $imagePath = "../Images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $image;
    }

    $query = "Insert into category(`name`, `detail`, `image`) values(?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $detail, $imagePath);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        echo json_encode(['status' => 'success', 'message' => 'Record added successfully.', 'redirect' => 'View-category.php']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Something went wrong while adding..']);
    }
    exit();
}
?>





<!-- Record Table -->
<div class="form-parent">

    <div class="form-records">
        <form method="POST" id="insertForm" enctype="multipart/form-data">
            <h4>Add New Category</h4><br>
            <div class="form-group">
                <label style="color:black">Category</label>

                <input type="text" name="name" id="name" placeholder="Category Name " class="form-control" required>
            </div>

            <div class="form-group">
                <label style="color:black">Description</label>

                <textarea type="text" name="detail" id="detail" placeholder="Description"
                    class="form-control "></textarea>
            </div>


            <div class="form-group">
                <label style="font-weight:500;">Upload Image</label><br>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>


            <div class="form-group mt-3">
                <button type="submit" id="submitbtn" name="submit" class="btn btn-info">Add Data
                </button>
                <button onclick="window.history.back()" class="btn btn-secondary ml-2">Move Back</button>

            </div>
        </form>

    </div>
</div>


</main>

</section>


</body>

</html>