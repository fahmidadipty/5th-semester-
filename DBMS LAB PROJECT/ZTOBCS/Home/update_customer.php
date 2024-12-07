<?php
session_start();
include '../db.php';  // Include your database connection

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get the customer ID from the URL
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Prepare the SQL query to fetch the customer details
    $query = "SELECT * FROM Customers WHERE CustomerID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if customer exists
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "Customer not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

// Handle form submission for updating customer details
if (isset($_POST['submit'])) {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare the update query
    $update_query = "UPDATE Customers SET FirstName = ?, LastName = ?, Email = ?, Phone = ? WHERE CustomerID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $customer_id);

    // Execute the update query
    if ($stmt->execute()) {
        header("Location: view_customer.php");  // Redirect to view customers page after successful update
        exit();
    } else {
        echo "Error updating customer details!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="phone"] {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #388E3C;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            font-size: 14px;
        }

        .back-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update Customer Details</h2>

        <form action="update_customer.php?id=<?php echo $customer_id; ?>" method="POST">
            <!-- First Name -->
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($customer['FirstName']); ?>" required>

            <!-- Last Name -->
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($customer['LastName']); ?>" required>

            <!-- Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['Email']); ?>" required>

            <!-- Phone -->
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['Phone']); ?>" required>

            <!-- Submit Button -->
            <input type="submit" name="submit" value="Update Customer">
        </form>

        <div class="back-link">
            <a href="view_customer.php">Back to Customer List</a>
        </div>
    </div>

</body>
</html>
