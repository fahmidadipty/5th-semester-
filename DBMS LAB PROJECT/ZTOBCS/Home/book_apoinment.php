<?php
session_start();
include '../db.php';  // Include your database connection

// Check if the customer is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get the customer ID from session
$customer_id = $_SESSION['id'];

// Fetch available services
$services_query = "SELECT * FROM Services";
$services_result = $conn->query($services_query);

// Fetch available staff
$staff_query = "SELECT * FROM Staff";
$staff_result = $conn->query($staff_query);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $service_id = $_POST['service'];
    $staff_id = $_POST['staff'];
    $appointment_date = $_POST['appointment_date'];

    // Insert the appointment into the database
    $insert_query = "INSERT INTO Appointments (CustomerID, StaffID, ServiceID, AppointmentDate, Status) 
                     VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iiis", $customer_id, $staff_id, $service_id, $appointment_date);

    if ($stmt->execute()) {
        // Redirect to the customer dashboard or show a success message
        echo "Appointment booked successfully!";
        header("Location: cusdash.php");
        exit();
    } else {
        echo "Error booking appointment: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
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

        .appointment-container {
            background-color: #fff; /* White background for the form container */
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            color: #333;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select, input[type="datetime-local"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green background for the submit button */
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
            color: white;
        }

        /* Back Link */
        .back-link {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            display: block;
            margin-top: 20px;
            background-color: #4CAF50; /* Green background for back link */
            padding: 10px;
            border-radius: 4px;
        }

        .back-link:hover {
            background-color: #45a049;
            text-decoration: underline;
        }

        /* Table Header (th) Style */
        th {
            background-color: #4CAF50; /* Green background for table header */
            color: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="appointment-container">
        <h2>Book an Appointment</h2>
        
        <form action="book_apoinment.php" method="POST">
            <label for="service">Service:</label>
            <select id="service" name="service" required>
                <option value="">Select Service</option>
                <?php while ($row = $services_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ServiceID']; ?>"><?php echo htmlspecialchars($row['ServiceName']); ?></option>
                <?php } ?>
            </select>

            <label for="staff">Staff:</label>
            <select id="staff" name="staff" required>
                <option value="">Select Staff</option>
                <?php while ($row = $staff_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['StaffID']; ?>"><?php echo htmlspecialchars($row['FirstName']); ?></option>
                <?php } ?>
            </select>

            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required placeholder="Select Date">
<br>
            <input type="submit" value="Book Appointment">
        </form>
        
        <br>
        <a href="cusdash.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
