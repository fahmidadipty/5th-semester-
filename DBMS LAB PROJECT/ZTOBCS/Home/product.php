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

// Insert new product into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $quantityInStock = $_POST['quantityInStock'];
    $price = $_POST['price'];

    // Prepare SQL query
    $sql = "INSERT INTO Products (ProductName, Description, QuantityInStock, Price)
            VALUES ('$productName', '$description', '$quantityInStock', '$price')";

    if ($conn->query($sql) === TRUE) {
        $message = "New product added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch products to display
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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
    <h1>Product Management</h1>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="quantityInStock">Quantity in Stock:</label>
        <input type="number" id="quantityInStock" name="quantityInStock" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <input type="submit" value="Add Product">
    </form>

    <h2>Existing Products</h2>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity in Stock</th>
            <th>Price</th>
        </tr>

        <?php
        // Display all products
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['ProductID'] . "</td>
                        <td>" . $row['ProductName'] . "</td>
                        <td>" . $row['Description'] . "</td>
                        <td>" . $row['QuantityInStock'] . "</td>
                        <td>" . $row['Price'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No products available.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
