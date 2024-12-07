<?php
include '../db.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchTerm) {
    $query = "SELECT * FROM Customers WHERE FirstName LIKE ? OR LastName LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTermWildcard = '%' . $searchTerm . '%';
    $stmt->bind_param("ss", $searchTermWildcard, $searchTermWildcard);
} else {
    $query = "SELECT * FROM Customers";
    $stmt = $conn->prepare($query);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer List</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .customer-container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .search-box {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-box input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
        }

        .search-box button {
            padding: 10px 20px;
            border: none;
            background-color: #5cb85c;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #5cb85c;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="customer-container">
        <h2>Customer List</h2>

        <div class="search-box">
            <form method="get" action="cusview.php">
                <input type="text" name="search" placeholder="Search by First or Last Name" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>Gender</th>
            </tr>
            <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["CustomerID"] . "</td>
                                <td>" . $row["FirstName"] . "</td>
                                <td>" . $row["LastName"] . "</td>
                                <td>" . $row["Phone"] . "</td>
                                <td>" . $row["Email"] . "</td>
                                <td>" . $row["Address"] . "</td>
                                <td>" . $row["City"] . "</td>
                                <td>" . $row["Gender"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No customers found</td></tr>";
                }
            ?>
        </table>

        <a href="homepage.php" class="back-button">Back to Homepage</a>
    </div>
</body>
</html>
