<p?php

    // file to not allow admin to directly access admin panel until they are login
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
    </head> <!-- Summernote CSS (Bootstrap 4 compatible) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <body>

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
                            <img src="../Images/ptpl-logo.png" alt="" class="logo-left">
                            <p class="header-title">Punjab Thermal Power (Pvt.) Limited</p>
                            <img src="../Images/ptpl-logo11.png" alt="" class="logo-right">
                        </div>
                        <div class="header-bottomfooter"></div>


                        <div class="file-content">
                            <div class="title-part">
                                <h3>File Number</h3>
                                <p><?php echo $row['fileNumber'] ?></p>
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
                        <div class="footer-lines"></div>

                        <div class="file-footer">
                            <p>Ground Floor, 7 C-1 Gullberg III, Lahore. Tel +92-42-35711278-9, Fax:+92-42-35711282</p>
                            <p style="padding-top:2px; text-transform: none;">Website: WWW.punjabthermal.com</p>
                        </div>
                    </div>

                    <div class="single-recordChild2">
                        <div class="file-topics">
                            <h4>Perform Actions</h4>
                            <ul>
                                <li><i class="fas fa-search"></i> <a href="TrackRecord.php">Track Document</a></li>
                                <li><i class="fas fa-edit"></i> <a href="update-document.php?id=<?php echo $row['id'] ?>" class="update-link" data-id="<?php echo $row['id']; ?>">Update Record</a></li>
                                <li><i class=" far fa-file-pdf"></i> <a href="javascript:void(0);" onclick="printDocument()">Print Document</a></li>
                                <li><i class="fas fa-download"></i> <a href="javascript:void(0);" onclick="downloadPDF()">Download File</a></li>
                                <li><i class="fas fa-arrow-left"></i> <button style="background:transparent" onclick="window.location.href='view-document.php'">Go Back</button>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Bootstrap 4 (JS) -->
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <!-- Summernote JS (Bootstrap 4 compatible) -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
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