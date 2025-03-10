<?php

// file to not allow user to directly access user panel until they are login
include('Check_token.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Document</title>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Print-specific CSS -->
    <link rel="stylesheet" href="../CSS/print.css" media="print">
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
            $query = "select * from documents where id='$id'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="single-recordParent">
                    <div class="single-recordBorder">
                        <div class="single-recordChild" id="documentContent">
                            <div class="file-header">
                                <h2><?php echo $row['filename'] ?></h2>
                                <div class="user-data">
                                    <p class="name">Barcode:<span><?php echo $row['barcode'] ?></span> </p>
                                    <p>Created at:<span><?php echo date('F j, Y', strtotime($row['created_at'])) ?> </span></p>
                                </div>
                            </div>

                            <div class="file-content">
                                <div class="title-part">
                                    <h3>Document Title</h3>
                                    <p><?php echo $row['fileTitle'] ?></p>
                                </div>
                                <div class="text-part">

                                    <div class="text-part">
                                        <?php
                                        $description = $row['description'];
                                        // Decode HTML entities to ensure proper display of content
                                        $description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
                                        echo $description;
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class="file-footer">
                                <p>Inventory Management System © PTPL</p>
                            </div>
                        </div>

                        <div class="single-recordChild2">
                            <div class="file-topics">
                                <h4>Perform Actions</h4>
                                <ul>
                                    <li><i class="fas fa-search"></i> <a href="TrackRecord.php">Track Document</a></li>
                                    <li><i class="fas fa-edit"></i> <a href="update-document.php?id=<?php echo $row['id'] ?>">Update Record</a></li>
                                    <li><i class="far fa-file-pdf"></i> <a href="javascript:void(0);" onclick="printDocument()">Print Document</a></li>
                                    <li><i class="fas fa-download"></i> <a href="javascript:void(0);" onclick="downloadPDF()">Download File</a></li>
                                    <li><i class="fas fa-arrow-left"></i> <button style="background:transparent; " onclick="history.back()">Go Back</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </main>
    </section>

    <!-- External jquery, popper File Link for bootstrap 4 -->

    <script src="../Bootstrap/js/jquery.min.js"></script>
    <script src="../Bootstrap/js/popper.min.js"></script>

    <!-- Bootstrap 4 (JS) -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>

    <script>
        function printDocument() {
            var content = document.getElementById("documentContent").innerHTML;

            window.print(content);
        }

        function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById("documentContent");

            html2canvas(element, {
                scale: 2, // Increase scale for better quality
                useCORS: true, // Enable cross-origin images
            }).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgWidth = 210; // A4 width in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                pdf.save("Document.pdf");
            });
        }
    </script>
</body>

</html>