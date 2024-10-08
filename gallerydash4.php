<?php
include "dashboardconnection.php";

function redirect($url) {
    header("Location: $url");
    exit();
}

// Handle image upload
if(isset($_POST["insert"])) {
    $file = $_FILES['img'];

    if ($file['error'] == 0) {
        $imgData = addslashes(file_get_contents($file['tmp_name']));

        $query = "INSERT INTO gallery4 (img) VALUES ('$imgData')";  // Updated table name
        if (mysqli_query($link, $query)) {
            echo "Image uploaded successfully.";
        } else {
            echo "Database insertion error: " . mysqli_error($link);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    // Redirect to the same page to avoid form resubmission
    redirect($_SERVER['PHP_SELF']);
}

// Handle image update
if(isset($_POST["edit"])) {
    $imgId = $_POST["img_id"];
    $file = $_FILES['img'];

    if ($file['error'] == 0) {
        $imgData = addslashes(file_get_contents($file['tmp_name']));

        $stmt = $link->prepare("UPDATE gallery4 SET img = ? WHERE id = ?");  // Updated table name
        $stmt->bind_param("si", $imgData, $imgId);

        if ($stmt->execute()) {
            echo "Image updated successfully.";
        } else {
            echo "Database update error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    // Redirect to the same page to avoid form resubmission
    redirect($_SERVER['PHP_SELF']);
}

// Handle image deletion
if(isset($_POST["delete"])) {
    $imgId = $_POST["img_id"];
    $query = "DELETE FROM gallery4 WHERE id='$imgId'";  // Updated table name
    if(mysqli_query($link, $query)) {
        echo "Image deleted successfully.";
    } else {
        echo "Failed to delete the image: " . mysqli_error($link);
    }

    // Redirect to the same page to avoid form resubmission
    redirect($_SERVER['PHP_SELF']);
}

// Fetch all images from the gallery4 table
$result = mysqli_query($link, "SELECT id, img FROM gallery4");  // Updated table name
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        /* Dashboard Layout */
        .dashboard {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: width 0.3s ease;
        }

        .sidebar h2 {
            margin-top: 0;
            font-size: 1.6em;
            font-weight: 600;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        .sidebar ul li {
            padding: 15px;
            margin-bottom: 10px;
            background-color: #0056b3;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .sidebar ul li:hover {
            background-color: #004494;
            transform: scale(1.03);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            color: #007bff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar h3 {
            margin: 0;
            font-size: 1.4em;
        }

        .content {
            padding: 20px;
            background-color: #fff;
            flex: 1;
            overflow-y: auto;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .card input[type="file"] {
            margin-bottom: 10px;
        }

        .card button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .card button:hover {
            background-color: #218838;
        }

        .card form {
            display: inline;
        }

        .card .delete-btn {
            background-color: #dc3545;
        }

        .card .delete-btn:hover {
            background-color: #c82333;
        }

        .card .edit-btn {
            background-color: #ffc107;
        }

        .card .edit-btn:hover {
            background-color: #e0a800;
        }

        .hidden-file-input {
            display: none;
        }

        /* Permanent Dropdown specific styling */
        .dropdown {
            position: relative;
            background-color: #004494;
            padding: 0;
            border-radius: 5px;
        }

        .dropdown ul {
            display: block;
            background-color: #004494;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .dropdown ul li {
            padding: 10px 15px;
            background-color: #0056b3;
            border-bottom: 1px solid white;
            transition: background-color 0.3s ease;
        }

        .dropdown ul li:hover {
            background-color: #004999;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>Fashion Gallery</h2>
            <ul>
                <li id="dashboard">Contact</li>
                <li id="service">Service</li>
                <li class="dropdown">
                    Gallery
                    <ul>
                    <li id="gallery1">Wedding Gallery</li>
                        <li id="gallery2">Nature Gallery</li>
                        <li id="gallery3">Event Gallery</li>
                        
                    </ul>
                </li>
            </ul>
        </aside>
        <div class="main-content">
            <header class="navbar">
               <h3 style="margin-left: 450px;">Fashion Gallery</h3>
            </header>
            <div class="content">
                <div class="card-container">
                    <div class="card">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input name="img" type="file" required>
                            <button type="submit" name="insert">Upload Image</button>
                        </form>
                    </div>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="card">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" alt="Uploaded Image">
                        <br>
                        <!-- Edit and Delete Buttons -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="img_id" value="<?php echo $row['id']; ?>">
                            <input type="file" name="img_update" class="hidden-file-input" onchange="this.form.submit();">
                            <!-- <button type="button" onclick="triggerFileInput(this)" class="edit-btn">Edit</button> -->
                            <button type="submit" name="delete" class="delete-btn">Delete</button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function triggerFileInput(button) {
            const fileInput = button.previousElementSibling;
            fileInput.click();
        }
    </script>
    <script>
        function triggerFileInput(button) {
            const fileInput = button.previousElementSibling;
            fileInput.click();
        }
    </script>
    <script>
    document.getElementById("logoutButton").addEventListener("click", function() {
      // Redirect to the login page
      window.location.href = "login.html";
    });
  </script>
   <script>
    document.getElementById("service").addEventListener("click", function() {
      // Redirect to the service page
      window.location.href = "servicedash.php";
    });
  </script>
   <script>
    document.getElementById("dashboard").addEventListener("click", function() {
      // Redirect to the dashboard page
      window.location.href = "dashboard.php";
    });
  </script>

<script>
    document.getElementById("gallery1").addEventListener("click", function() {
      // Redirect to the dashboard page
      window.location.href = "gallerydash.php";
    });
  </script>

<script>
    document.getElementById("gallery2").addEventListener("click", function() {
      // Redirect to the dashboard page
      window.location.href = "gallerydash2.php";
    });
  </script>

<script>
    document.getElementById("gallery3").addEventListener("click", function() {
      // Redirect to the dashboard page
      window.location.href = "gallerydash3.php";
    });
  </script>
</script>
</body>
</html>
