<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="templatemo">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <title>SnapX Photography Categories</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-snapx-photography.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <style>
        .featured-contests .item {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            margin-bottom: 30px;
            position: relative;
        }

        .featured-contests .item:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2), 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .featured-contests .item .content {
            padding: 20px;
        }

        .featured-contests .item .top-content {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .featured-contests .item .top-content .award {
            font-weight: 600;
            color: #333;
        }

        .featured-contests .item .top-content .price {
            font-weight: 700;
            color: #4CAF50; /* Green color for price */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .featured-contests .item h4 {
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .featured-contests .item .info {
            margin-bottom: 15px;
            color: #666;
        }

        .featured-contests .item .border-button a {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            background-color: #4CAF50; /* Green color for button */
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .featured-contests .item .border-button a:hover {
            background-color: #388E3C; /* Darker green on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky" style="background-color: rgb(255, 255, 255);">
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
                        <ul class="nav">
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
                                </ul>
                            </li>
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

    <section class="featured-contests">
        <div class="container">
            <div class="row" >
                <div class="col-lg-12" style="margin-top: 0%;">
                    <div class="section-heading text-center"  >
                        <h4><em>prices</em> & <em>packages</em></h4>
                    </div>
                </div>

                <?php
                // Database connection
                $servername = "localhost";  // Replace with your server name
                $username = "root";         // Replace with your MySQL username
                $password = "";             // Replace with your MySQL password
                $database = "dashboard";    // Replace with your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the service1 table
                $sql = "SELECT * FROM service1 LIMIT 10";  // Changed from 'service' to 'service1'
                $result = $conn->query($sql);

                if ($result === false) {
                    die("Error: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-lg-4" >
                            <div class="item">
                                <div class="content">
                                    <div class="top-content">
                                        <h4>  <span class="price">' . $row["plan"] . '</span> </h4> 
                                        <span class="price">$' . $row["price"] . '</span>
                                    </div>
                                    <h6>' . $row["description"] . '</h6>
                                    <div class="info">
                                        <span class="submissions">' . $row["features"] . '</span>
                                    </div>
                                    <div class="border-button" style="margin-left: 35%;">
                                        <a href="contact.php">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "<p>No contests available</p>";
                }

                // Close connection
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <footer class="no-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright © 2048 <a href="#">SnapX</a> Photo Contest Co., Ltd. All rights reserved.
                        Design: <a title="CSS Templates" rel="sponsored" href="https://templatemo.com" target="_blank">TemplateMo</a> Distribution: <a title="CSS Templatesss" rel="sponsored" href="https://themewagon.com" target="_blank">ThemeWagon</a>
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
