<?php 
include "dashboardconnection.php";

// Fetch all images from the gallery table
$result = mysqli_query($link, "SELECT img FROM gallery");
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="author" content="templatemo">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <title>SnapX Photo Contests</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-snapx-photography.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  </head>

<body>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="index.html" class="logo">
                          <img src="assets/images/logo.png" alt="SnapX Photography Template">
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav" >
                        <li><a href="home.html" class="active">Home</a></li>
                        <li><a href="about.html" class="active">About</a></li>
                        <li><a href="service.php">Services</a></li>
                        <li class="has-sub">
                        <a href="javascript:void(0)">Gallery</a>
                        <ul class="sub-menu">
                        <li><a href="gallery1.php">Wedding Gallery</a></li>
                  <li><a href="gallery2.php">Nature Gallery</a></li>
                  <li><a href="gallery3.php">Event Gallery</a></li>
                  <li><a href="gallery4.php">Fashion Gallery</a></li>
                            
                        </li>
                        </ul>
                        <li><a href="contact.php">Contact</a></li>
                    </ul> 
                      <div class="border-button">
                        <a id="" href="login.html" class=""><i class=""></i> Login</a>
                      </div>
                      <a class='menu-trigger'>
                          <span>Menu</span>
                      </a>
                      <!-- ***** Menu End ***** -->
                  </nav>
              </div>
          </div>
      </div>
  </header>
  <!-- ***** Header Area End ***** -->


  <section class="portfolio" style="margin-top: 0cm;background-color: white;margin-bottom: 0%;">
   
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading text-center">
          
            <h4>Wedding <em>Gallery</em></h4>
          </div>
        </div>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-lg-3">
          <div class="thumb">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" alt="Gallery Image" style="max-width: 100%; height: auto;">
          </div>
        </div>
        <?php } ?>

      </div>
    </div>
  </section>

  

  <!-- Scripts -->

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p><a href="#"></a> 2024 Malcolm Lismore Photography. All rights reserved.

            Email: <a title="CSS Templates" rel="sponsored" href="" target="_blank"> info@malcolmlismorephotography.com
              </a>
              Phone:  <a title="CSS Templates" rel="sponsored" href="" target="_blank">+44 1234 567890</a>
           Location: <a title="CSS Templates" rel="sponsored" href="" target="_blank"> Based on the North West coast of Scotland </a>
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

  </body>
</html>
