<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Document</title>
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
                                    <p>Created at:<span><?php echo date('F j, Y', strtotime($row['created_at'])) ?> </span>
                                    </p>
                                </div>
                            </div>

                            <div class="file-content">
                                <div class="title-part">
                                    <h3>Document Title</h3>
                                    <p><?php echo $row['fileTitle'] ?></p>
                                </div>
                                <div class="text-part">
                                    <?php echo $row['description'] ?>
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
                                    <li><i class="fas fa-search"></i> <a href="">Track Document</a></li>
                                    <li><i class="fas fa-edit"></i> <a
                                            href="update-document.php?id=<?php echo $row['id'] ?>">Update Record</a></li>
                                            <li><i class="far fa-file-pdf"></i> <a href="" onclick="printDocument(event)">Print Document</a></li>

                                    <li><i class="fas fa-arrow-left"></i> <a href="view-document.php">Go Back</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>






            <?php } ?>






        </main>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script>
        function printDocument(event) {
            event.preventDefault(); // Prevent link navigation

            var printContent = document.getElementById('documentContent').innerHTML;
            var stylesheet = '<link rel="stylesheet" href="../CSS/style.css">';

            var printWindow = window.open('', '', 'width=900,height=700');
            printWindow.document.write(`
        <html>
        <head>
            <title>Print Document</title>
            ${stylesheet}  <!-- Include your existing stylesheet -->
        </head>
        <body>
            ${printContent}  <!-- Print only the document content -->
        </body>
        </html>
    `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>


</body>

</html>