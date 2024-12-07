<?php
session_start();
include '../db.php'; // Include your database connection

if (isset($_POST['submit_promotion'])) {
    // Sanitize and validate form inputs
    $promotion_name = $_POST['promotion_name'];
    $description = $_POST['description'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Basic validation for form fields
    if (empty($promotion_name) || empty($description) || empty($discount_percentage) || empty($start_date) || empty($end_date)) {
        $error_message = "All fields are required!";
    } else {
        // Insert promotion data into the database
        $query = "INSERT INTO Promotions (PromotionName, Description, DiscountPercentage, StartDate, EndDate) 
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdss", $promotion_name, $description, $discount_percentage, $start_date, $end_date);
        
        if ($stmt->execute()) {
            $success_message = "Promotion added successfully!";
            header("Location: admindash.php");
        } else {
            $error_message = "Error adding promotion: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotion</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            width: 60%;
            max-width: 600px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .error,
        .success {
            text-align: center;
            font-size: 14px;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                width: 100%;
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add Promotion</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form action="add_promotion.php" method="POST">
            <div class="form-group">
                <label for="promotion_name">Promotion Name:</label>
                <input type="text" id="promotion_name" name="promotion_name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="discount_percentage">Discount Percentage:</label>
                <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>

            <button type="submit" name="submit_promotion">Add Promotion</button>
            
        </form> <br> <a href="admindash.php">Back to Dashboard</a>
        
    </div>

</body>
</html>
