<?php
session_start();
// Include your database connection file
include('../db.php');
// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
// Fetch staff members from the database
$query = "SELECT * FROM Staff";
$result = mysqli_query($conn, $query);

// Check if there are any staff members
if (mysqli_num_rows($result) > 0) {
    $staff_members = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $staff_members = [];
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the staff member from the database
    $delete_query = "DELETE FROM Staff WHERE StaffID = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        header("Location:admidash.php");
    } else {
        echo "<script>alert('Error deleting staff member');</script>";
    }
}

// Handle update action (optional: if you have an update form, implement here)
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    // Fetch staff member details for editing
    $edit_query = "SELECT * FROM Staff WHERE StaffID = $edit_id";
    $edit_result = mysqli_query($conn, $edit_query);
    $staff_to_edit = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
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
            max-width: 1000px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        .action-buttons a {
            padding: 8px 15px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 4px;
            margin: 0 5px;
        }

        .action-buttons a.delete {
            background-color: #e74c3c;
        }

        .action-buttons a.edit {
            background-color: #f39c12;
        }

        .action-buttons a:hover {
            opacity: 0.8;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .container {
                padding: 20px;
                margin: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>View Staff Members</h2>

        <?php if (empty($staff_members)) { ?>
            <p>No staff members found.</p>
        <?php } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Hire Date</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staff_members as $staff) { ?>
                        <tr>
                            <td><?php echo $staff['StaffID']; ?></td>
                            <td><?php echo $staff['FirstName']; ?></td>
                            <td><?php echo $staff['LastName']; ?></td>
                            <td><?php echo $staff['Phone']; ?></td>
                            <td><?php echo $staff['Email']; ?></td>
                            <td><?php echo $staff['Position']; ?></td>
                            <td><?php echo $staff['HireDate']; ?></td>
                            <td><?php echo $staff['Salary']; ?></td>
                            <td class="action-buttons">
                                <a href="view_staff.php?edit_id=<?php echo $staff['StaffID']; ?>" class="edit">Edit</a><br>
                                <a href="view_staff.php?delete_id=<?php echo $staff['StaffID']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>

</html>
