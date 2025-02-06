<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Document</title>
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


            <div class="single-recordParent">
                <div class="track-recordParent">
                    <div class="track-record">
                        <h2>Track File Record</h2>

                        <div class="row" style="margin:25px 20px 8px 20px">
                            <div class="col-12 search-record">
                                <form method="POST" action="">
                                    <div class="input-box">
                                        <input type="text" class="form-control" name="searh" placeholder="Enter barcode to track record">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="card result-part">
                        <div class="card-header head">
                            Result
                        </div>
                        <div class="card-body">
                            <!-- <blockquote class="blockquote mb-0">
                                <p>No Record Found.</p>
                                <footer class="blockquote-footer">Try with different <cite title="Source Title">barcode</cite></footer>
                            </blockquote> -->

                            <div class="col-lg-12">
    
            <h5 class="header-title" style="margin:8px 0 26px 0; font-size:18px">Records Office</h5>
            <ul class="list-unstyled activity-wid mb-0">
                <li class="activity-list activity-border">
                    <div class="activity-icon avatar-sm">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="avatar-sm rounded-circle" alt="">
                    </div>
                    <div class="card">
                        <div class="card-header" style="display:flex; gap:12px; background:#fff">
                            <h5 class="font-size-15 mb-1 text-primary">Ali Ahmand</h5>
                            <p class="text-muted font-size-14 mb-0">- Received the document</p>
                        </div>

                        <div class="card-body">
                            <p><i class="fa fa-calendar font-size-15"></i> Date & Time</p>

                            <span>February 10 2024 09:41 PM </span> 

                           
                        </div>

                    </div>
                </li>

                



            </ul>

        </div>
    

                        </div>
                    </div>
                </div>

            </div>

            </div>

        </main>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>



</body>

</html>