
<?php
session_start();
include '../db.php';
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Prepare a query to fetch user details by email

}
$query = "SELECT ServiceName FROM services";  // Assume the table name is 'services' and it has a column 'service_name'
$result = mysqli_query($conn, $query);

$query1 = "SELECT Services.ServiceName, Appointments.AppointmentDate, Appointments.Status FROM Appointments
    JOIN Services ON Appointments.ServiceID = Services.ServiceID
    WHERE Appointments.AppointmentDate >= CURDATE() 
    ORDER BY Appointments.AppointmentDate ASC";
$result1 = mysqli_query($conn, $query1);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Zero-To-One</title>
    <style>
        /* General Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #4CAF50;
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 18px;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            flex: 1 1 250px;
        }

        .sidebar h3 {
            margin-top: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
        }

        /* Main Content Styling */
        .main-content {
            flex-grow: 2;
            margin-left: 20px;
            min-width: 300px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h3 {
            margin-top: 0;
        }

        .card table {
            width: 100%;
            border-collapse: collapse;
        }

        .card table, .card th, .card td {
            border: 1px solid #ddd;
        }

        .card th, .card td {
            padding: 12px;
            text-align: left;
        }

        .card button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .card button:hover {
            background-color: #45a049;
        }

        /* Footer Styling */
        footer {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Responsive Styling */
        @media screen and (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .card button {
                width: 100%;
                padding: 12px;
            }
        }

        @media screen and (max-width: 480px) {
            .navbar {
                font-size: 16px;
                padding: 10px;
            }

            .card h3 {
                font-size: 18px;
            }

            .card table, .card th, .card td {
                font-size: 14px;
            }
        }
        .card button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .card button:hover {
            background-color: #45a049;
        }
        .card table {
            width: 100%;
            border-collapse: collapse;
        }

        .card table, .card th, .card td {
            border: 1px solid #ddd;
        }

        .card th, .card td {
            padding: 12px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>Welcome To Zero-To-One</h2>
    </div>

    <div class="dashboard-container">
      
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Welcome, <?php echo $_SESSION['name']; ?></h3>
            <ul>
                <li><a href="view_appointments.php">View Appointments</a></li>
                <li><a href="book_apoinment.php">Book New Appointment</a></li>
                <li><a href="viewprofile.php">Edit Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            
            <!-- Upcoming Appointments -->
            <div class="card">
        <h3>Upcoming Appointments</h3>
        <table>
            <tr>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
            // Check if there are any appointments fetched
            if (mysqli_num_rows($result1) > 0) {
                // Loop through the results and display each appointment
                while ($row = mysqli_fetch_assoc($result1)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ServiceName']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['AppointmentDate']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Status']) . '</td>';
                    echo '</tr>';
                }
            } else {
                // If no upcoming appointments, show a message
                echo '<tr><td colspan="4">No upcoming appointments.</td></tr>';
            }
            ?>
            </table>
        </div>
    

            <!-- Available Services -->
              <!-- Available Services Section -->
    <div class="card">
        <h3>Available Services</h3>
        <ul>
            <?php
            // Check if there are any services fetched
            if (mysqli_num_rows($result) > 0) {
                // Loop through the results and display each service
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li>' . htmlspecialchars($row['ServiceName']) . '</li>';
                }
            } else {
                echo '<li>No services available at the moment.</li>';
            }
            ?>
        </ul>
        <button onclick="window.location.href='book_apoinment.php'">Book Appointment</button>
        <div class="card">
    <h3>Recent Promotions</h3>
    <table>
        <tr>
            <th>Promotion Name</th>
            <th>Discount (%)</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
        <?php
        // Fetch promotions from the database
        $query = "SELECT PromotionName, DiscountPercentage, StartDate, EndDate FROM Promotions";
        $result = mysqli_query($conn, $query);

        // Check if there are any promotions
        if (mysqli_num_rows($result) > 0) {
            // Loop through each promotion and display it in a table row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['PromotionName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DiscountPercentage']) . "%</td>";
                echo "<td>" . htmlspecialchars($row['StartDate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['EndDate']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No promotions available at the moment.</td></tr>";
        }
        ?>
    </table>
</div>


    <footer>
        &copy; Zero-To-One. All rights reserved.
    </footer>

</body>
</html>
