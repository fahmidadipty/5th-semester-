<?php
session_start();
include '../db.php'; // Include your database connection

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch appointments from the database
$query = "SELECT a.AppointmentID, a.AppointmentDate, a.Status, c.FirstName AS CustomerName, s.FirstName AS StaffName, se.ServiceName
          FROM Appointments a
          JOIN Customers c ON a.CustomerID = c.CustomerID
          JOIN Staff s ON a.StaffID = s.StaffID
          JOIN Services se ON a.ServiceID = se.ServiceID
          WHERE a.AppointmentDate >= CURDATE()  
          ORDER BY a.AppointmentDate DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$appointments = $stmt->get_result();

// Update appointment status
if (isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE Appointments SET Status = ? WHERE AppointmentID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_status, $appointment_id);
    $stmt->execute();

    header("Location: appointmentadmin.php");
    exit();
}

// Handle payment button click
if (isset($_POST['process_payment'])) {
    $appointment_id = $_POST['appointment_id'];

    // Redirect to payment page or process payment logic here
    // For now, we just show a message
    echo "<script>alert('Redirecting to payment page for Appointment ID: $appointment_id');</script>";
    header("Location: payment.php?appointment_id=$appointment_id"); // Example redirect to payment page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #4CAF50; /* Green background for table header */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        select, button {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .payment-btn {
            background-color: #008CBA;
        }

        .payment-btn:hover {
            background-color: #007B9A;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Appointments</h2>

        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Staff Name</th>
                    <th>Service</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Update Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($appointments->num_rows > 0): ?>
                    <?php while ($appointment = $appointments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['CustomerName']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['StaffName']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['ServiceName']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['AppointmentDate']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Status']); ?></td>
                            <td>
                                <form action="appointmentadmin.php" method="POST">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['AppointmentID']; ?>">
                                    <select name="status">
                                        <option value="Pending" <?php echo ($appointment['Status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Completed" <?php echo ($appointment['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="Cancelled" <?php echo ($appointment['Status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status">Update</button>
                                </form>
                            </td>
                            <td>
                                <form action="appointmentadmin.php" method="POST">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['AppointmentID']; ?>">
                                    <button type="submit" name="process_payment" class="payment-btn">Process Payment</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table><br>
        <a href="admindash.php" class="back-button">BACK</a>
    </div>
</body>
</html>
