<?php
session_start();
include '../db.php';  // Include your database connection

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the customer ID is set in the URL
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Prepare the SQL query to delete the customer
    $delete_query = "DELETE FROM Customers WHERE CustomerID = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $customer_id);

    // Execute the query and check if the deletion was successful
    if ($stmt->execute()) {
        // Redirect to the customer list page
        header("Location: view_customer.php");
        exit();
    } else {
        // If there is an error deleting, show a message
        echo "Error deleting customer!";
    }

    $stmt->close();
} else {
    // If no ID is provided, show an error message
    echo "Invalid request!";
}

?>
