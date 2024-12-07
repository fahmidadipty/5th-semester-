<?php
session_start();
include '../db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in customer's email and fetch customer data
$email = $_SESSION['email'];
$query = "SELECT * FROM Customers WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$customer_id = $user['CustomerID']; // Get customer_id

// Fetch appointments for this customer
$query = "SELECT * FROM appointments WHERE CustomerID = ? ORDER BY AppointmentDate DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$appointments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointments</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff; /* White background for the page */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff; /* White background for the container */
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333; /* Dark text color for better contrast */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        /* Green table header */
        th {
            background-color: #4CAF50; /* Green background for table header */
            color: #fff; /* White text for table header */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green background for button */
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 90%;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Appointments</h2>
        
        <?php if ($appointments->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($appointment = $appointments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['AppointmentDate']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No appointments found.</p>
        <?php endif; ?>
        
        <br>
        <a href="cusdash.php">Back to Dashboard</a>
    </div>
</body>
</html>
