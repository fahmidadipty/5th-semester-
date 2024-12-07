<?php

$servername = "localhost"; 
$username = "root";        
$password = "";           
$dbname = "luxeloom2";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Set default role and CustomerID for new user (Customer role assumed here)
    $role = 'Customer';
    $customerID = 1; // You may want to handle this dynamically depending on your logic

    // Insert user data into Users table
    $sql = "INSERT INTO Users (Username, Email, PasswordHash, Role, CustomerID) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $email, $passwordHash, $role, $customerID);

    // Execute query and check if the insertion was successful
    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        echo 'Please fill the form correctly';
    }

    // Close the statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <!-- Bootstrap CDN for responsive design -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqNfEXcWqHqWv8KhTK4fj4xk6xJfa+RwvX++dtzRiSJE/" crossorigin="anonymous">

    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('background.jpg'); /* Set the homepage background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        .signup-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .signup-container label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        .signup-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .signup-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .signup-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .signup-container p {
            text-align: center;
            font-size: 14px;
        }

        .signup-container a {
            color: #4CAF50;
            text-decoration: none;
        }

        .signup-container a:hover {
            text-decoration: underline;
        }

        /* Media Query for small devices */
        @media (max-width: 576px) {
            .signup-container {
                padding: 20px;
                width: 90%;
            }
        }

    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Username">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Email">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Password">
            </div>
            <div>
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required placeholder="Confirm Password">
            </div>
            <div>
                <input type="submit" value="Sign Up">
            </div>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zyxtOZ6gD5gtnD9gD6cJgH1Rb8EZp4jV0my93+X+5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqNfEXcWqHqWv8KhTK4fj4xk6xJfa+RwvX++dtzRiSJE/" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqNfEXcWqHqWv8KhTK4fj4xk6xJfa+RwvX++dtzRiSJE/" crossorigin="anonymous"></script>
</body>
</html>
