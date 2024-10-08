<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store form data and errors
$name = $email = $phone = $eventdate = $location = $message = "";
$name_err = $email_err = $phone_err = $eventdate_err = $location_err = $message_err = "";
$success_msg = "";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate Email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
    } elseif (!preg_match('/^[0-9]{10}$/', $_POST["phone"])) {
        $phone_err = "Please enter a valid 10-digit phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate Event Date
    if (empty($_POST["eventdate"])) {
        $eventdate_err = "Please select an event date.";
    } else {
        $eventdate = $_POST["eventdate"];
    }

    // Validate Location
    if (empty(trim($_POST["location"]))) {
        $location_err = "Please enter the event location.";
    } else {
        $location = trim($_POST["location"]);
    }

    // Validate Message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter your message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Check for errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($eventdate_err) && empty($location_err) && empty($message_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO wddcontact (name, email, phone, eventdate, location, message) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss", $param_name, $param_email, $param_phone, $param_eventdate, $param_location, $param_message);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_eventdate = $eventdate;
            $param_location = $location;
            $param_message = $message;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $success_msg = "Your message has been sent successfully!";
                // Clear form fields
                $name = $email = $phone = $eventdate = $location = $message = "";
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="templatemo">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <title>Malcolm Lismore</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-snapx-photography.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }
        .header-area {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-section {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            max-width: 600px;
        }
        .contact-form .form-control {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .contact-form .form-control:focus {
            border-color:  #f0f2f5;
            box-shadow: 0 0 8px rgba(90, 90, 243, 0.2);
        }
        .btn-primary {
            background-color: #5a5af3;
            border-color: #5a5af3;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 6px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            display: block;
            margin: 0 auto;
        }
        .btn-primary:hover {
            background-color: #4a4aed;
            border-color: #4a4aed;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
        .error {
            color: #e74c3c;
            font-size: 14px;
        }
        .success-msg {
            background-color: #2ecc71;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .site-label {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .dynamic-shadow {
            position: relative;
            background: linear-gradient(145deg, #ffffff, #f0f2f5);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 0 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.5s ease;
        }
        .dynamic-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 0 30px rgba(0, 0, 0, 0.2);
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
   
<script>
        // JavaScript to set min date for event date input to today's date
        window.onload = function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("eventdate")[0].setAttribute('min', today);
        };
    </script>
   

    <section class="contact-section dynamic-shadow">
        <div class="container">
            <div class="site-label">Contact Malcolm Lismore</div>

            <?php if (!empty($success_msg)) : ?>
                <div class="success-msg"><?php echo $success_msg; ?></div>
            <?php endif; ?>

            <form class="contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="error"><?php echo $name_err; ?></span>

                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>

                <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo htmlspecialchars($phone); ?>">
                <span class="error"><?php echo $phone_err; ?></span>

           
              <div class="form-group <?php echo (!empty($eventdate_err)) ? 'has-error' : ''; ?>">
              <label for="eventdate">Event Date:</label>
              <input type="date" name="eventdate" class="form-control" value="<?php echo $eventdate; ?>">
              <span class="error"><?php echo $eventdate_err; ?></span>
          </div>


                <input type="text" name="location" class="form-control" placeholder="Event Location" value="<?php echo htmlspecialchars($location); ?>">
                <span class="error"><?php echo $location_err; ?></span>

                <textarea name="message" class="form-control" placeholder="Message"><?php echo htmlspecialchars($message); ?></textarea>
                <span class="error"><?php echo $message_err; ?></span>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
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

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/animate.js"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/templatemo-custom.js"></script>
</body>
</html>
