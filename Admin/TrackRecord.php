<?php
// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

// Database connection
include('../connection.php');

$trackingRecords = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $barcode = $_POST['search'];

    // Query to get document and its tracking history
    $sql = "SELECT d.barcode, d.description, d.created_at, 
            d.created_by,d.fileTitle,
            dt.*, sender.name AS sender_name,
            sender.image AS sender_image, 
            receiver.name AS receiver_name,
            receiver.image AS receiver_image
            FROM documents d
            JOIN document_tracking dt ON d.id = dt.document_id
            JOIN user sender ON dt.from_user = sender.id
            JOIN user receiver ON dt.to_user = receiver.id
            WHERE d.barcode = ?
            ORDER BY dt.date ASC";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $trackingRecords[] = $row;
        }
    } else {
        $noRecordsFound = true;
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Document</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <!-- External CSS File Link -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- Font Icons Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
            <div class="single-recordParent">
                <div class="track-recordParent">
                    <div class="track-record">
                        <h2>Track File Record</h2>
                        <div class="row" style="margin:25px 20px 8px 20px">
                            <div class="col-12 search-record">
                                <form method="POST" action="">
                                    <div class="input-box">
                                        <input type="text" class="form-control" name="search" placeholder="Enter barcode to track record">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card result-part">
                        <div class="card-header head">
                            RESULT
                        </div>
                        <div class="card-body">
                            <?php if (isset($noRecordsFound)): ?>
                                <blockquote class="blockquote mb-0">
                                    <p>No Record Found.</p>
                                    <footer class="blockquote-footer">Try with different <cite title="Source Title">barcode</cite></footer>
                                </blockquote>
                            <?php elseif (!empty($trackingRecords)): ?>
                                <div class="col-lg-12">
                                    <h5 class="header-title">File Record Office</h5>
                                    <ul class="track-list activity-wid">
                                        <?php foreach ($trackingRecords as $record): ?>
                                            <li class="activity-list activity-border">
                                                <div class="activity-icon avatar-sm">
                                                    <img src="../Images/<?php echo $record['sender_image'] ?>" class="Imgfile rounded-circle" alt="">
                                                </div>
                                                <div class="card Track-subpart">
                                                    <div class="card-header" style="display:flex; gap:12px;background:rgba(164, 197, 184, 0.07);">
                                                        <h5 class="result-name"><?php echo htmlspecialchars($record['sender_name']); ?></h5>
                                                        <p class="result-name2">- <?php echo htmlspecialchars($record['status']); ?> the document</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="date-part">
                                                            <p class="trackdata"><i class="far fa-calendar-alt"></i> Date & Time</p>
                                                            <p class="trackdata2"><?php echo htmlspecialchars($record['date']); ?></p>
                                                        </div>
                                                        <div class="remark-part">
                                                            <p class="trackdata"><i class="fa fa-pen"></i> REMARKS:</p>
                                                            <p class="trackdata2">Send To: <span><?php echo htmlspecialchars($record['receiver_name']); ?></span></p>
                                                        </div>
                                                        <p class="btn btn-info status-btn text-white">Status: <?php echo htmlspecialchars($record['status']); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <blockquote class="blockquote mb-0">
                                    <p style="font-weight:600; font-size:17px">Scan Barcode To Track File.</p>
                                    <footer class="blockquote-footer">Keep the barcode steady while scanning for best results.</footer>
                                </blockquote>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>