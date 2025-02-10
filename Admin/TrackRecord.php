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
                            RESULT
                        </div>
                        <div class="card-body">
                            <!-- <blockquote class="blockquote mb-0">
                                <p>No Record Found.</p>
                                <footer class="blockquote-footer">Try with different <cite title="Source Title">barcode</cite></footer>
                            </blockquote> -->

                            <!-- <blockquote class="blockquote mb-0">
                                <p style="font-weight:600; font-size:17px">Scan Barcode To Track File.</p>
                                <footer class="blockquote-footer">Keep the barcode steady while scanning for best results.</footer>
                                </blockquote> -->

                            <div class="col-lg-12">
    
            <h5 class="header-title" >File Record Office</h5>
            <ul class="track-list activity-wid">
                <li class="activity-list activity-border">
                    <div class="activity-icon avatar-sm">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="Imgfile rounded-circle" alt="">
                    </div>
                    <div class="card Track-subpart">
                        <div class="card-header" style="display:flex; gap:12px;background:rgba(164, 197, 184, 0.07); ">
                            <h5 class="result-name">Ali Ahmand</h5>
                            <p class="result-name2">- Received the document</p>
                        </div>

                        <div class="card-body">
                            <div class="date-part">
                            <p class="trackdata"><i class="far fa-calendar-alt"></i> Date & Time</p>
                            <p class="trackdata2">February 10 2024 09:41 PM </p>
                            </div> 
                            <div class="remark-part">
                            <p class="trackdata"><i class="fa fa-pen"></i> REMARKS:</p>
                            <p class="trackdata2">Send by: <span>Zaviyan Akram</span></p>
</div>
                            <p class="btn btn-info status-btn text-white">Status pending</p>                 
                        </div>

                    </div>
                </li>

                



            </ul>

            <h5 class="header-title" >File Record Office</h5>
            <ul class="track-list activity-wid">
                <li class="activity-list activity-border">
                    <div class="activity-icon avatar-sm">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="Imgfile rounded-circle" alt="">
                    </div>
                    <div class="card Track-subpart">
                        <div class="card-header" style="display:flex; gap:12px;background:rgba(164, 197, 184, 0.07); ">
                            <h5 class="result-name">Ali Ahmand</h5>
                            <p class="result-name2">- Released the document</p>
                        </div>

                        <div class="card-body">
                            <div class="date-part">
                            <p class="trackdata"><i class="far fa-calendar-alt"></i> Date & Time</p>
                            <p class="trackdata2">February 10 2024 09:41 PM </p>
                            </div> 
                            <div class="remark-part">
                            <p class="trackdata"><i class="fa fa-pen"></i> REMARKS:</p>
                            <p class="trackdata2">Send by: <span>Zaviyan Akram</span></p>
</div>
                            <p class="btn btn-info status-btn text-white">Status pending</p>                 
                        </div>

                    </div>
                </li>

                



            </ul>

            <h5 class="header-title" >File Record Office</h5>
            <ul class="track-list activity-wid">
                <li class="activity-list activity-border">
                    <div class="activity-icon avatar-sm">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="Imgfile rounded-circle" alt="">
                    </div>
                    <div class="card Track-subpart">
                        <div class="card-header" style="display:flex; gap:12px;background:rgba(164, 197, 184, 0.07); ">
                            <h5 class="result-name">Ali Ahmand</h5>
                            <p class="result-name2">- Received the document</p>
                        </div>

                        <div class="card-body">
                            <div class="date-part">
                            <p class="trackdata"><i class="far fa-calendar-alt"></i> Date & Time</p>
                            <p class="trackdata2">February 10 2024 09:41 PM </p>
                            </div> 
                            <div class="remark-part">
                            <p class="trackdata"><i class="fa fa-pen"></i> REMARKS:</p>
                            <p class="trackdata2">Send by: <span>Zaviyan Akram</span></p>
</div>
                            <p class="btn btn-info status-btn text-white" >Status pending</p>                 
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