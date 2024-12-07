<?php
session_start();
// Include the database connection file (change the path if needed)
include '../db.php'; 
// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if (isset($_POST['submit_staff'])) {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];

    // Prepare the SQL query to insert the staff details
    $query = "INSERT INTO Staff (FirstName, LastName, Phone, Email, Position, HireDate, Salary) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bind_param("ssssssd", $first_name, $last_name, $phone, $email, $position, $hire_date, $salary);

    // Execute the query and check if the insertion is successful
    if ($stmt->execute()) {
        header("Location:view_staff.php");
    } else {
        $error_message = "Failed to add staff. Please try again.";
    }

    // Close the statement
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #5cb85c;
            outline: none;
        }

        textarea {
            height: 100px;
        }

        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #5cb85c;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .error,
        .success {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }

            h2 {
                font-size: 20px;
            }

            button {
                font-size: 16px;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 15px;
                margin: 10px;
            }

            h2 {
                font-size: 18px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Staff</h2>

       

        <form action="add_staff.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" required>
            </div>

            <div class="form-group">
                <label for="hire_date">Hire Date:</label>
                <input type="date" id="hire_date" name="hire_date" required>
            </div>

            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" step="0.01" required>
            </div>

            <button type="submit" name="submit_staff">Add Staff</button>
        </form><br><a href="admindash.php?">BACK</a>
    </div>
    
</body>

</html>
