<?php
include '../db.php'; // Include the database configuration file

// Check if the form was submitted
if ( isset($_POST['submit'])) {
    // Retrieve and sanitize form inputs
    $first_name = $conn->real_escape_string(trim($_POST['first_name']));
    $last_name = $conn->real_escape_string(trim($_POST['last_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $PasswordHash = password_hash(trim($_POST['PasswordHash']), PASSWORD_DEFAULT);

   

    // Prepare SQL statement to insert data into the Customers table
    $query = "INSERT INTO Customers (FirstName, LastName,  Email, PasswordHash) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $first_name, $last_name,  $email, $PasswordHash);

    // Execute the statement and check if the data was inserted
    if ($stmt->execute()) {
        // Set a success message in the session and redirect to cusview.php
        
        header("Location: login.php");
    
        exit();
     
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqNfEXcWqHqWv8KhTK4fj4xk6xJfa+RwvX++dtzRiSJE/" crossorigin="anonymous">
    <style>
        /* CSS Styling */
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Set the homepage background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        .register-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-container label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        .register-container input[type="text"], .register-container input[type="email"], .register-container input[type="password"], .register-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #5cb85c;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .register-container p {
            text-align: center;
            font-size: 14px;
        }

        .register-container a {
            color: #5cb85c;
            text-decoration: none;
        }

        .register-container a:hover {
            text-decoration: underline;
        }

        /* Media Query for small devices */
        @media (max-width: 576px) {
            .register-container {
                padding: 15px;
                width: 90%;
            }
        }

    </style>
</head>
<body>
    <div class="register-container">
        <form action="reg.php" method="POST">
            <h2>Customer Registration</h2>
            
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required placeholder="First Name">

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required placeholder="Last Name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Email">

            <label for="address">Password:</label>
            <input type="text" id="address" name="PasswordHash" required placeholder="Password">

            <button type="submit" name="submit">Register</button>
        </form>
        <p>Have an account? <a href="login.php">Login Here</a></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zyxtOZ6gD5gtnD9gD6cJgH1Rb8EZp4jV0my93+X+5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqNfEXcWqHqWv8KhTK4fj4xk6xJfa+RwvX++dtzRiSJE/" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqNfEXcWqHqWv8KhTK4fj4xk6xJfa+RwvX++dtzRiSJE/" crossorigin="anonymous"></script>
</body>
</html>
