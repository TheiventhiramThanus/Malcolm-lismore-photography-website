<?php
// Include database connection
include "serviceconnection.php";

// Fetch all plans from the database
$result = mysqli_query($link, "SELECT * FROM service1");

// Handle adding a new plan
if (isset($_POST['add_plan'])) {
    $plan_name = mysqli_real_escape_string($link, $_POST['plan']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $price = mysqli_real_escape_string($link, $_POST['price']);
    $features = mysqli_real_escape_string($link, implode("\n", array_map('trim', explode("\n", $_POST['features']))));
    
    $query = "INSERT INTO service1 (plan, description, price, features) VALUES ('$plan_name', '$description', '$price', '$features')";
    
    if (mysqli_query($link, $query)) {
        echo "<script>alert('Plan added successfully'); window.location='servicedash.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }
}

// Handle modifying an existing plan
if (isset($_POST['modify_plan'])) {
    $id = intval($_POST['id']);
    $plan_name = mysqli_real_escape_string($link, $_POST['plan']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $price = mysqli_real_escape_string($link, $_POST['price']);
    $features = mysqli_real_escape_string($link, implode("\n", array_map('trim', explode("\n", $_POST['features']))));

    $query = "UPDATE service1 SET plan='$plan_name', description='$description', price='$price', features='$features' WHERE id=$id";
    
    if (mysqli_query($link, $query)) {
        echo "<script>alert('Plan modified successfully'); window.location='servicedash.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }
}

// Handle deleting a plan
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $query = "DELETE FROM service1 WHERE id=$id";
    
    if (mysqli_query($link, $query)) {
        echo "<script>alert('Plan deleted successfully'); window.location='servicedash.php';</script>";
    } else {
        echo "<script>alert('Error deleting plan');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    /* Updated CSS with the color #007BFF */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .sidebar {
        width: 20%;
        background-color: #007BFF;
        color: white;
        height: 100vh;
        padding: 1rem;
        position: fixed;
        
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 2rem;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin-top: 20px;
    }

    .sidebar ul li {
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
        background-color: #0056b3;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .sidebar ul li:hover {
        background-color: #0056b3;
        transform: scale(1.03);
        
    }
   
    

    .content {
        margin-left: 20%;
        padding: 2rem;

    }

    
    

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #e1e1e1;
        padding: 1rem;
        margin-bottom: 2rem;
        border-radius: 5px;
    }

    .header h1 {
        margin: 0;
        color: #007BFF;
    }

    .header button {
        padding: 0.5rem 1rem;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .header button:hover {
        background-color: #0056b3;
    }

    .form-container {
        background-color: white;
        padding: 2rem;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .form-container input, .form-container textarea {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container button {
        width: 100%;
        padding: 0.5rem;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #218838;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }

    table th, table td {
        padding: 1rem;
        border: 1px solid #ddd;
        text-align: left;
    }

    table th {
        background-color: #007BFF;
        color: white;
    }

    table td .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        display: inline-block; /* Change to inline-block to align buttons side by side */
        margin-right: 5px; /* Add some space between the buttons */
    }

    .btn-modify {
        background-color: #28a745;
        color: white;
        margin-bottom: 0.3cm;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        text-decoration: none; /* Ensures no underline */
    }

    .btn-modify:hover {
        background-color:  #218838;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }
    
</style>

</head>
<body>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
        <li id="dashboard">Contact</li>
        <li id="gallery">Gallery</li>
    </ul>
</div>

<div class="content">
    <div class="header">
        <h1>Service Overview</h1>
        <button id="logoutButton">Logout</button>
    </div>

    <div class="form-container">
        <form method="post" action="">
            <input type="text" name="plan" placeholder="Plan Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="price" placeholder="Price" required>
            <textarea name="features" placeholder="Features (one per line)" required></textarea>
            <button type="submit" name="add_plan">Add Plan</button>
        </form>
    </div>

    <table>
        <thead>
        <tr>
            <th>Plan Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Features</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['plan']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['features'])); ?></td>
                <td>
                    <button 
                        class="btn btn-modify" 
                        data-id="<?php echo $row['id']; ?>"
                        data-plan="<?php echo htmlspecialchars($row['plan']); ?>"
                        data-description="<?php echo htmlspecialchars($row['description']); ?>"
                        data-price="<?php echo htmlspecialchars($row['price']); ?>"
                        data-features="<?php echo htmlspecialchars($row['features']); ?>">Modify</button>
                    
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this plan?');" class="btn btn-delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="form-container" id="modify-form-container" style="display:none;">
        <form method="post" action="">
            <input type="hidden" name="id" id="modify-id">
            <input type="text" name="plan" id="modify-plan" placeholder="Plan Name" required>
            <input type="text" name="description" id="modify-description" placeholder="Description" required>
            <input type="text" name="price" id="modify-price" placeholder="Price" required>
            <textarea name="features" id="modify-features" placeholder="Features (one per line)" required></textarea>
            <button type="submit" name="modify_plan">Save Changes</button>
        </form>
    </div>

</div>

<script>
    document.querySelectorAll('.btn-modify').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('modify-id').value = button.getAttribute('data-id');
            document.getElementById('modify-plan').value = button.getAttribute('data-plan');
            document.getElementById('modify-description').value = button.getAttribute('data-description');
            document.getElementById('modify-price').value = button.getAttribute('data-price');
            document.getElementById('modify-features').value = button.getAttribute('data-features');
            document.getElementById('modify-form-container').style.display = 'block';
            window.scrollTo(0, document.getElementById('modify-form-container').offsetTop);
        });
    });

    document.getElementById('logoutButton').addEventListener('click', function () {
        window.location.href = 'adminlogin.html';
    });

    document.getElementById('dashboard').addEventListener('click', function () {
        window.location.href = 'dashboard.php';
    });

    document.getElementById('gallery').addEventListener('click', function () {
        window.location.href = 'gallerydash.php';
    });
</script>

</body>
</html>
