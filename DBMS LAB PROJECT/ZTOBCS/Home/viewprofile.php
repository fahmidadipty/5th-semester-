<?php
session_start();  // Start the session

// Check if the user is logged in by checking if the session 'email' is set
if (!isset($_SESSION['email'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

include '../db.php';  // Include your database connection file

// Get the user's email from the session
$email = $_SESSION['email'];

// Fetch user data from the database
$query = "SELECT * FROM Customers WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data is found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// If the form is submitted, update the profile information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $firstname = $conn->real_escape_string(trim($_POST['firstname']));
    $lastname = $conn->real_escape_string(trim($_POST['lastname']));
    $new_email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $address = $conn->real_escape_string(trim($_POST['address']));
    $city = $conn->real_escape_string(trim($_POST['city']));
    $gender = $conn->real_escape_string(trim($_POST['gender']));

    // If the new email is different from the current email
    if ($new_email != $email) {
        // Check if the new email already exists in the database
        $email_check_query = "SELECT * FROM Customers WHERE Email = ?";
        $stmt_check = $conn->prepare($email_check_query);
        $stmt_check->bind_param("s", $new_email);
        $stmt_check->execute();
        $email_check_result = $stmt_check->get_result();

        if ($email_check_result->num_rows > 0) {
            echo "This email is already in use.";
        } else {
            // Update user data in the database, including the new email
            $update_query = "UPDATE Customers SET FirstName = ?, LastName = ?, Email = ?, Phone = ?, Address = ?, City = ?, Gender = ? WHERE Email = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("ssssssss", $firstname, $lastname, $new_email, $phone, $address, $city, $gender, $email);

            if ($stmt_update->execute()) {
                // Update session email if it was changed
                $_SESSION['email'] = $new_email;
                echo "Profile updated successfully!";
                // Redirect to profile page to reflect changes
                header("Location: cusdash.php");
                exit();
            } else {
                echo "Error updating profile: " . $stmt_update->error;
            }
        }
    } else {
        // Update user data without changing the email
        $update_query = "UPDATE Customers SET FirstName = ?, LastName = ?, Phone = ?, Address = ?, City = ?, Gender = ? WHERE Email = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("sssssss", $firstname, $lastname, $phone, $address, $city, $gender, $email);

        if ($stmt_update->execute()) {
            echo "Profile updated successfully!";
            header("Location: cusdash.php");
            exit();
        } else {
            echo "Error updating profile: " . $stmt_update->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Edit Profile</title>
    <link rel="stylesheet" href="styles.css">  <!-- Link to your CSS file -->
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #5cb85c;
            outline: none;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            font-size: 16px;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #5cb85c;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            color: #5cb85c;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Profile</h2>
        <form action="viewprofile.php" method="POST">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['FirstName']); ?>" required>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['LastName']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['Address']); ?>" required>
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['City']); ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['Gender']); ?>" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Update Profile">
            </div>
        </form>
        <a href="cusdash.php">Back to Dashboard</a>
    </div>
</body>
</html>
