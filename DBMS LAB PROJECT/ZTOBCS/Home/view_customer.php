<?php
session_start();
include '../db.php';  // Include your database connection

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch customers from the database
$query = "SELECT * FROM Customers"; // Assuming your customers table is named 'Customers'
$result = $conn->query($query);

// Check if query was successful
if (!$result) {
    die("Error retrieving data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
            background-color: #388E3C;
            transition: background-color 0.3s ease;
        }

        .action-buttons a:hover {
            background-color: #81C784;
        }

        .action-buttons .delete {
            background-color: #D32F2F;
        }

        .action-buttons .delete:hover {
            background-color: #FF6659;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Customer List</h2>

        <!-- Display the customer data in a table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($customer = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['CustomerID']); ?></td>
                        <td><?php echo htmlspecialchars($customer['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($customer['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($customer['Email']); ?></td>
                        <td><?php echo htmlspecialchars($customer['Phone']); ?></td>
                        <td class="action-buttons">
                            <!-- Update button -->
                            <a href="update_customer.php?id=<?php echo $customer['CustomerID']; ?>">Update</a>
                            <!-- Delete button -->
                            <a href="delete_customer.php?id=<?php echo $customer['CustomerID']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            
        </table>
        <a href="admindash.php?">BACK</a>
    </div>

</body>
</html>
