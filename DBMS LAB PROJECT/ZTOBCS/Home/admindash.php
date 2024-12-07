<?php
session_start();
include '../db.php';  

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and general styles */
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('background.jpg'); /* Set your background image path here */
            background-size: cover;
            background-position: center;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 30px;
            color: white;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-header h2 {
            font-size: 28px;
            margin: 0;
            font-weight: 600;
        }

        .sidebar-body {
            padding-left: 20px;
        }

        .sidebar-body p {
            padding: 15px 0;
            font-size: 18px;
            text-transform: capitalize;
        }

        .sidebar-body ul {
            list-style-type: none;
            padding-left: 0;
        }

        .sidebar-body ul li {
            margin: 20px 0;
        }

        .sidebar-body ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            display: block;
            padding: 10px 15px;
            background-color: #388E3C;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .sidebar-body ul li a:hover {
            background-color: #81C784;
        }

        /* Main content area */
        .main-content {
            margin-left: 250px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9); /* Light background for main content */
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content h1 {
            font-size: 36px;
            color: #2C3E50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .main-content p {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .main-content .options {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .main-content .options a {
            display: block;
            width: 180px;
            padding: 15px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .main-content .options a:hover {
            background-color: #388E3C;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
                padding-top: 15px;
            }

            .sidebar-header h2 {
                font-size: 24px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .main-content .options a {
                width: 150px;
            }
        }

        /* Logout Button styles */
        .logout-btn {
            background-color: #D32F2F; /* Red color for logout */
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            display: block;
            margin: 20px auto;
            width: fit-content;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #E57373;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Dashboard</h2>
        </div>
        <div class="sidebar-body">
            <p>Welcome, <?php echo $_SESSION['name']; ?>!</p>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <h1>Welcome to the Admin Dashboard</h1>

        <div class="options">
            <a href="reg2.php">Add Customer</a>
            <a href="add_staff.php">Add Staff</a>
            <a href="view_staff.php">View Staff</a>
            <a href="product.php">Add Product</a>
            <a href="addservice.php">Add service</a>
            <a href="add_promotion.php">Add Promotion</a>
            <a href="view_customer.php">View Customers</a>
            <a href="viewproduct.php">View Products</a>
            <a href="adminviewservice.php">View Services</a>
            <a href="appointmentadmin.php">View Appointments</a>
        </div>
    </div>
</body>
</html>

