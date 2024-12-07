<?php
session_start();
include '../db.php'; // Include your database connection

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch appointment details from the database
$appointment = null;
$products = []; // To store the list of products

if (isset($_GET['appointment_id'])) { // Make sure this matches the URL parameter
    $appointment_id = $_GET['appointment_id']; // Correct query parameter name

    // Query to fetch appointment details
    $query = "SELECT a.AppointmentID, a.AppointmentDate, a.Status, c.FirstName AS CustomerName, s.FirstName AS StaffName, se.ServiceName, se.Price AS ServicePrice
              FROM Appointments a
              JOIN Customers c ON a.CustomerID = c.CustomerID
              JOIN Staff s ON a.StaffID = s.StaffID
              JOIN Services se ON a.ServiceID = se.ServiceID
              WHERE a.AppointmentID = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch appointment details if available
    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
    } else {
        echo "Appointment not found!";
        exit();
    }

    // Fetch the list of products (e.g., from a "products" table)
    $productQuery = "SELECT * FROM Products";
    $productResult = $conn->query($productQuery);
    while ($product = $productResult->fetch_assoc()) {
        $products[] = $product;
    }
} else {
    echo "No Appointment ID provided.";
    exit();
}

// Handle the form submission for payment processing
if (isset($_POST['submit_payment'])) {
    $selected_products = $_POST['products']; // Array of selected product IDs
    $promotion_code = $_POST['promotion_code'] ?? ''; // Optional promotion code

    // Calculate the total price based on selected products and service price
    $total_price = $appointment['ServicePrice']; // Start with the service price
    $product_total = 0;

    // Add prices of selected products
    if (!empty($selected_products)) {
        foreach ($selected_products as $product_id) {
            $productQuery = "SELECT Price FROM Products WHERE ProductID = ?";
            $stmt = $conn->prepare($productQuery);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $productResult = $stmt->get_result();

            if ($productResult->num_rows > 0) {
                $product = $productResult->fetch_assoc();
                $product_total += $product['Price'];
            }
        }
    }

    // Add product total to service price
    $total_price += $product_total;

    // Apply promotion code if provided (example logic)
    if (!empty($promotion_code)) {
        $promotionQuery = "SELECT DiscountPercentage FROM Promotions WHERE PromotionName = ?";
        $stmt = $conn->prepare($promotionQuery);
        $stmt->bind_param("s", $promotion_code);
        $stmt->execute();
        $promotionResult = $stmt->get_result();

        if ($promotionResult->num_rows > 0) {
            $promotion = $promotionResult->fetch_assoc();
            $discount = $promotion['DiscountPercentage'] / 100 * $total_price;
            $total_price -= $discount;
        } else {
            echo "Invalid promotion code.";
        }
    }

    // Final total payment
    echo "Total Payment: $" . number_format($total_price, 2);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1 class="heading">Appointment Payment</h1>

    <!-- Payment Form -->
    <form action="payment.php?appointment_id=<?php echo $appointment['AppointmentID']; ?>" method="POST" class="payment-form">
        <div class="appointment-details">
            <h3>Appointment Details</h3>
            <p><strong>Customer:</strong> <?php echo $appointment['CustomerName']; ?></p>
            <p><strong>Service:</strong> <?php echo $appointment['ServiceName']; ?> (Price: $<?php echo $appointment['ServicePrice']; ?>)</p>
        </div>

        <div class="product-selection">
            <h3>Select Products</h3>
            <select name="products[]" multiple>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['ProductID']; ?>"><?php echo $product['ProductName']; ?> - $<?php echo $product['Price']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php
// Assuming the database connection is already included above (e.g., include '../db.php')

// Query to fetch active promotions where the end date is greater than or equal to the current date
$current_date = date('Y-m-d'); // Get today's date in YYYY-MM-DD format
$promotionQuery = "SELECT PromotionName, DiscountPercentage, EndDate FROM Promotions WHERE EndDate >= ?";
$stmt = $conn->prepare($promotionQuery);
$stmt->bind_param("s", $current_date); // Bind the current date to the query
$stmt->execute();
$promotionResult = $stmt->get_result();

// Fetch the promotions and store them in an array
$promotions = [];
while ($promotion = $promotionResult->fetch_assoc()) {
    $promotions[] = $promotion;
}
?>

<!-- HTML Section to Display Available Promotions -->
<div class="promotion-code">
    <h3>Enter Promotion Name(optional)</h3>
    <input type="text" name="promotion_code" placeholder="Enter promotion name">
    
    <?php if (count($promotions) > 0): ?>
        <h4>Available Promotions:</h4>
        <ul>
            <?php foreach ($promotions as $promotion): ?>
                <li>
                    <strong>Code:</strong> <?php echo htmlspecialchars($promotion['PromotionName']); ?> |
                    <strong>Discount:</strong> <?php echo htmlspecialchars($promotion['DiscountPercentage']); ?>% |
                    <strong>Valid Until:</strong> <?php echo htmlspecialchars($promotion['EndDate']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No active promotions available at the moment.</p>
    <?php endif; ?>
</div>


        <div class="submit-button">
            <button type="submit" name="submit_payment">Submit Payment</button>
        </div>
        <a href="appointmentadmin.php" class="back-button">Back </a>
    </form>
</div>

</body>
</html>

<!-- CSS (styles.css) -->
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7fc;
    }

    .container {
        width: 80%;
        max-width: 900px;
        margin: 0 auto;
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .heading {
        text-align: center;
        color: #333;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .payment-form h3 {
        color: #333;
        font-size: 22px;
        margin-bottom: 10px;
    }

    .appointment-details, .product-selection, .promotion-code {
        margin-bottom: 20px;
    }

    .appointment-details p, .product-selection select, .promotion-code input {
        font-size: 16px;
        line-height: 1.6;
        color: #555;
    }

    select, input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 8px;
    }

    button {
        padding: 12px 30px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
    }

    button:hover {
        background-color: #45a049;
    }

    .submit-button {
        text-align: center;
    }
</style>
</html>
