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

// Fetch all products from the database
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
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
            background-color: #4CAF50;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
        .no-products {
            text-align: center;
            color: #ff0000;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>View All Products</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Quantity in Stock</th>
                <th>Price</th>
            </tr>

            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['ProductID']; ?></td>
                    <td><?php echo $row['ProductName']; ?></td>
                    <td><?php echo $row['Description']; ?></td>
                    <td><?php echo $row['QuantityInStock']; ?></td>
                    <td><?php echo "$" . number_format($row['Price'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-products">No products available in the database.</p>
    <?php endif; ?>

</div>

</body>
</html>
