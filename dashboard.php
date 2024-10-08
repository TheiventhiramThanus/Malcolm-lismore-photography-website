<?php
include "dashboardconnection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM wddcontact WHERE id = $id";
    
    if (mysqli_query($link, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
        color: #333;
    }

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

    .sidebar:hover {
        width: 300px;
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

    .content {
        padding: 20px;
        background-color: #fff;
        flex: 1;
        overflow-y: auto;
    }

    .card {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .btn-container {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 5px 10px;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: inline-block;
    }

    .btn-success {
        background-color: #28a745;
    }
    .btn-log {
        background-color: #007bff;
    }

    .btn-pending {
        background-color: orange;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3em 0.6em;
        margin-left: 5px;
        color: #007bff;
        background-color: #f0f2f5;
        border: 1px solid #ddd;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff;
        background-color: #007bff;
        border: 1px solid #007bff;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <ul>
        <li id="dashboard">Contact</li>
        <li id="gallery">Gallery</li>
        <li id="service">Service</li>
      </ul>
    </aside>
    <div class="main-content">
      <header class="navbar">
        <h3>Contact Overview</h3>
        <div class="btn btn-log">
          <button id="logoutButton">Logout</button>
        </div>
      </header>

      <div class="content">
        <div class="card">
          <h4>Contact Messages</h4>
          <table id="contactTable" class="display">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Event Date</th>
                <th>Location</th>
                <th>Message</th>
                <th colspan="3">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $res = mysqli_query($link, "SELECT * FROM wddcontact");
              while ($row = mysqli_fetch_array($res)) {
                echo "<tr id='row-" . $row["id"] . "'>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><a href='https://wa.me/" . preg_replace("/\D/", "", $row["phone"]) . "' target='_blank'>" . $row["phone"] . "</a></td>";
                echo "<td>" . $row["eventdate"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td class='btn-container'>";
                echo "<button type='button' class='btn btn-success' onclick='sendMessage(" . $row["id"] . ", \"approved\")'>Approved</button>";
                echo "<button type='button' class='btn btn-pending' onclick='sendMessage(" . $row["id"] . ", \"pending\")'>Pending</button>";
                echo "<button type='button' class='btn btn-danger' onclick='deleteContact(" . $row["id"] . ")'>Delete</button>";
                echo "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function () {
        $('#contactTable').DataTable();
    });

    function deleteContact(id) {
        if (confirm("Are you sure you want to delete this contact?")) {
            $.post('your-current-file.php', { id: id }, function (response) {
                if (response == 'success') {
                    $('#row-' + id).remove();
                } else {
                    alert("Failed to delete contact.");
                }
            });
        }
    }

    function sendMessage(id, status) {
        var name = $('#row-' + id).find('td:nth-child(1)').text();
        var phone = $('#row-' + id).find('td:nth-child(3)').text();
        var date = $('#row-' + id).find('td:nth-child(4)').text();
        var location = $('#row-' + id).find('td:nth-child(5)').text();

        var cleanPhone = phone.replace(/\D/g, '');

        var message = "";
        if (status === "approved") {
            message = `Hello ${name},\nYour request for the event on ${date} at ${location} has been approved. We are looking forward to serving you.`;
        } else if (status === "pending") {
            message = `Hello ${name},\nYour request for the event on ${date} at ${location} is currently pending. We will update you soon.`;
        }

        var whatsappURL = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(message)}`;

        window.open(whatsappURL, '_blank');
    }
 document.getElementById("logoutButton").addEventListener("click", function() {
          window.location.href = "login.html";
      });

      document.getElementById("gallery").addEventListener("click", function() {
          window.location.href = "gallerydash.php";
      });

      document.getElementById("service").addEventListener("click", function() {
          window.location.href = "servicedash.php";
      });
              // Cancel Button Functionality
        $('#cancelButton').click(function() {
            $('#customerModal').hide();
        });

        // Close Modal
        $('.close').click(function() {
            $('#customerModal').hide();
        });

 function deleteContact(id) {
          if (confirm("Are you sure you want to delete this contact?")) {
              $.ajax({
                  url: '',
                  type: 'POST',
                  data: { id: id },
                  success: function(response) {
                      if (response == 'success') {
                          $('#row-' + id).remove();
                      } else {
                          alert('Error deleting contact.');
                      }
                  }
              });
            }
        }

        // Send Message (For demo purposes, just alert the message)
        $('#sendMessageButton').click(function() {
            var service = $('#modalService').val();
            var message = $('#modalMessage').val();
            alert('Service: ' + service + '\nMessage sent: ' + message);
            $('#customerModal').hide();
        });

  </script>
</body>
</html>
