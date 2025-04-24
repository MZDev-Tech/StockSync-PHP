<?php
session_name("ADMIN_SESSION");
session_start();
include('../connection.php');

// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');


// code to check if admin has submit data
if (isset($_POST['save_data'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $fileNumber = mysqli_real_escape_string($con, $_POST['fileNumber']);
    $fileTitle = mysqli_real_escape_string($con, $_POST['fileTitle']);
    $detail = mysqli_real_escape_string($con, $_POST['detail']);
    // Removing zero-width space and BOM characters
    $detail = preg_replace('/\x{200B}|\x{FEFF}/u', '', $detail);

    // Remove extra spaces or line breaks if necessary
    $detail = trim($detail);

    $query = "update documents set fileNumber=?, fileTitle=?, description=? where id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $fileNumber, $fileTitle, $detail, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {

        echo json_encode(['status' => 'success', 'message' => 'Record Updated successfully..', 'redirect' => 'view-document.php']);
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
$query = "select * from documents where id='$id'";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
?>
    <div class="form-parent">
        <div class="form-records">
            <form method="POST" id="updateForm" action="" enctype="multipart/form-data">
                <h4 style="text-align:center; margin:10px 0 14px 0">Update Document</h4>
                <div class="form-group">
                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
                </div>

                <div class="section">
                    <p class="sec-title"><span class="las la-sort"></span> File Specification</p>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label style="color:black">File Number</label>
                            <input type="text" name="fileNumber" placeholder="Enter file code" class="form-control"
                                value="<?php echo $row['fileNumber']; ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label style="color:black">File Title</label>
                            <input type="text" name="fileTitle" placeholder="Enter title" class="form-control"
                                value="<?php echo $row['fileTitle']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <p class="sec-title"><span class="las la-sort"></span> File Details</p>
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <textarea name="detail" id="summernote" placeholder="Type Details.." class="form-control"><?php echo $row['description']; ?></textarea>

                        </div>

                    </div>
                </div>


            <?php } ?>



            <div class="form-group mt-2 ml-3">
                <button type="submit" name="submit" class="btn btn-info">Update Data
                </button>
                <button type="button" onclick="window.location.href='view-document.php'" class="btn btn-secondary ml-1">Move Back
                </button>
            </div>
            </form>

        </div>
    </div>

    </main>

    </section>
    <script>
        // Wait until the DOM is updated, then initialize Summernote
        $('#summernote').ready(function() {
            $('#summernote').summernote({
                placeholder: 'Enter Description',
                height: 200,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['misc', ['undo', 'redo']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        var data = new FormData();
                        data.append("file", files[0]);

                        $.ajax({
                            url: 'handleFileMedia.php',
                            type: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#summernote').summernote('insertImage', response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error uploading file: " + error);
                            }
                        });
                    }
                }
            });
        });
    </script>