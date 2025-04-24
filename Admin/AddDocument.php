<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

// Code to check if admin has submitted the form
if (isset($_POST['save_data'])) {
    $fileNumber = mysqli_real_escape_string($con, $_POST['fileNumber']);
    $fileTitle = mysqli_real_escape_string($con, $_POST['fileTitle']);

    $barcode = uniqid(); // Will generate a unique barcode
    $created_by = $_SESSION['id'];
    $detail = mysqli_real_escape_string($con, $_POST['detail']);
    // Removing zero-width space and BOM characters
    $detail = preg_replace('/\x{200B}|\x{FEFF}/u', '', $detail);

    // Remove extra spaces or line breaks if necessary
    $detail = trim($detail);

    $query = "INSERT INTO documents(`fileNumber`,`fileTitle`, `barcode`, `created_by`, `description`) VALUES (?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssis', $fileNumber, $fileTitle, $barcode, $created_by, $detail);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Get the last inserted file ID
        $document_id = mysqli_insert_id($con);

        // Insert notification into the database
        $notify_title = "File Secured!";
        $notify_message = "'$fileTitle' is now available in the system.";
        $image = '../Images/fileImg.gif';

        $notify_query = "INSERT INTO notifications (`type`,`image`, `related_id`, `title`,`message`, `status`) VALUES ('file', ?, ?,?,?, 'unread')";
        $notify_stmt = mysqli_prepare($con, $notify_query);
        mysqli_stmt_bind_param($notify_stmt, 'siss', $image, $document_id, $notify_title, $notify_message);
        mysqli_stmt_execute($notify_stmt);
        echo json_encode(['status' => 'success', 'message' => 'Document created successfully.', 'redirect' => 'view-document.php']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Something went wrong while creating the document.']);
    }

    exit();
}
?>



<!-- Record Table -->
<div class="form-parent">
    <div class="form-records">
        <form id="insertForm" method="POST" action="" enctype="multipart/form-data">
            <h4 class="text-center">Create New Document</h4><br>
            <div class="section">
                <p class="sec-title"><span class="las la-sort"></span> File Specification</p>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="Filename" class="form-label">File Number</label>
                        <input type="text" name="fileNumber" placeholder="Enter file code" class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="File Title" class="form-label">File Title</label>
                        <input type="text" name="fileTitle" class="form-control" placeholder="Enter Title"
                            required>

                    </div>
                </div>
            </div>

            <div class="section">
                <p class="sec-title"><span class="las la-sort"></span> File Information</p>
                <div class="row">
                    <div class="form-group">
                        <textarea id="summernote" name="detail" placeholder="Description"
                            class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2">
                <button type="submit" name="submit" class="btn btn-info">Create Now</button>
                <button type="button" onclick="window.location.href='view-document.php'" class="btn btn-secondary ml-1">Move Back</button>
            </div>

        </form>
    </div>
</div>
</main>
</section>