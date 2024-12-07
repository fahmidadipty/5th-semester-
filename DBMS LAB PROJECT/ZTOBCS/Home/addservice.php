<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your DB username
$password = "";      // Replace with your DB password
$dbname = "ztobcs";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new service into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceName = $_POST['serviceName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $durationMinutes = $_POST['durationMinutes'];

    // Prepare SQL query
    $sql = "INSERT INTO Services (ServiceName, Description, Price, DurationMinutes)
            VALUES ('$serviceName', '$description', '$price', '$durationMinutes')";

    if ($conn->query($sql) === TRUE) {
        $message = "New service added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch services to display
$sql = "SELECT * FROM Services";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="submit"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Service Management</h1>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="serviceName">Service Name:</label>
        <input type="text" id="serviceName" name="serviceName" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="durationMinutes">Duration (Minutes):</label>
        <input type="number" id="durationMinutes" name="durationMinutes" required>

        <input type="submit" value="Add Service">
    </form>

    <h2>Existing Services</h2>
    <table>
        <tr>
            <th>Service ID</th>
            <th>Service Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Duration (Minutes)</th>
        </tr>

        <?php
        // Display all services
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['ServiceID'] . "</td>
                        <td>" . $row['ServiceName'] . "</td>
                        <td>" . $row['Description'] . "</td>
                        <td>" . $row['Price'] . "</td>
                        <td>" . $row['DurationMinutes'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No services available.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
