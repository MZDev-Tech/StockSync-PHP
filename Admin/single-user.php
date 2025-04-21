<div class="col-lg-12 mb-6 page-name">
    <h2>User Data</h2>
    <h5>Home / Profile</h5>
</div>
<!-----------alert message------------->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-warning data-dismissible fade show" id="alertMessage" style="margin:10px 25px">
        <strong>User! </strong>
        <?php echo $_SESSION['message'] ?>
        <button type="button" data-dismiss="alert" class="close" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
<?php unset($_SESSION['message']);
} ?>
<!---------------Admin Record Table ------------------------->
<div class="row" style="margin:10px 25px">
    <div class="col-12 bg-white">
        <div class="d-flex justify-content-between align-items-center py-3 top-recordParent">
            <div class="d-flex align-items-center top-recordPart">
                <i class="fa-solid fa-tablet-screen-button"></i>
                <div>
                    <h2 class="mb-1">User Data</h2>
                    <p class="mb-0">Manage your records efficiently</p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include('../connection.php');
$id = $_GET['id'];

$query = "select * from user where id=?";
$stmt = mysqli_prepare($con, $query);
//bind parameters
mysqli_stmt_bind_param($stmt, 'i', $id);
//excute query
mysqli_stmt_execute($stmt);
//get result
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_array($result)) {
?>
    <div class="profile-records" style="margin: 30px 28px 20px 28px;">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card mb-3  pb-4 shadow-sm">
                    <div class="card-body p-0">
                        <!-- Upper Background Image -->
                        <div class="upper" style="height: 140px; background-image: url('../Images/userbg.jpeg'); background-size: cover; background-position: center;">
                        </div>

                        <!-- Profile Image -->
                        <div class="d-flex justify-content-center" style="margin-top: -75px;">
                            <div class="user-img">
                                <?php if (!empty($row['image']) && file_exists($row['image'])) {
                                    echo '<img src="../Images/' . $row['image'] . '" alt="userImg" class="rounded-circle border border-3 border-white shadow" width="125" height="125">';
                                } else {
                                    echo "<img src='../Images/imgdefault.jpg' class='rounded-circle border border-3 border-white shadow' width='125' height='125'>";
                                } ?>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="d-flex flex-column align-items-center text-center mt-3 pb-3">
                            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                            <p class="text-secondary mb-1"><?php echo htmlspecialchars($row['designation']) ?></p>
                            <p class="text-muted font-size-sm"><?php echo htmlspecialchars($row['email']); ?></p>

                            <div class="d-flex align-items-center">
                                <a href="update-user.php?id=<?php echo $row['id'] ?>" class="btn btn-info update-link " data-id="<?php echo $row['id'] ?>">Update</a>
                                <a href="View-user.php" class="btn btn-outline-secondary  ml-2">Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <!-- Card Header -->
                    <div class="card-header text-center bg-white py-3" style="background:linear-gradient(250deg, rgb(66 146 155 / 54%), rgb(119 108 122 / 71%));">
                        <p class="mb-0 text-white" style="font-size: 15px;">Detailed information about the selected user</p>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Full Name -->
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><span class="las la-sort"></span> Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-data">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </div>
                        </div>
                        <hr>

                        <!-- Email -->
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><span class="las la-sort"></span> Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-data">
                                <?php echo htmlspecialchars($row['email']); ?>
                            </div>
                        </div>
                        <hr>

                        <!-- Phone -->
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><span class="las la-sort"></span> Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-data">
                                +92<?php echo htmlspecialchars($row['phone']); ?>
                            </div>
                        </div>
                        <hr>

                        <!-- Designation -->
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><span class="las la-sort"></span> Designation</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-data">
                                <?php echo htmlspecialchars($row['designation']); ?>
                            </div>
                        </div>
                        <hr>

                        <!-- Address -->
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><span class="las la-sort"></span> Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-data">
                                <?php echo htmlspecialchars($row['address']); ?>
                            </div>
                        </div>
                        <hr>

                        <!-- Status -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><span class="las la-sort"></span> Status</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-data status">
                                <span><?php echo htmlspecialchars($row['status']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>


            <?php } ?>

            </div>