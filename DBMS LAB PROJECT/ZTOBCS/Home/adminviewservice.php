<?php
include '../db.php';

$services = [];
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $query = "SELECT ServiceName, Description, Price, DurationMinutes FROM Services";
    if ($searchTerm) {
        $query .= " WHERE ServiceName LIKE ?";
        $stmt = $conn->prepare($query);
        $searchTermWildcard = '%' . $searchTerm . '%';
        $stmt->bind_param("s", $searchTermWildcard);
    } else {
        $stmt = $conn->prepare($query);
    }
    
    $stmt->execute();
    $stmt->bind_result($serviceName, $description, $price, $duration);

    while ($stmt->fetch()) {
        $services[] = [
            'serviceName' => $serviceName,
            'description' => $description,
            'price' => $price,
            'duration' => $duration
        ];
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Error retrieving services: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Services</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .services-container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
        }

        .search-container button {
            padding: 10px 20px;
            border: none;
            background-color: #5cb85c;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .search-container button:hover {
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
    <div class="services-container">
        <h2>Available Services</h2>

        <div class="search-container">
            <form method="get" action="">
                <input type="text" name="search" placeholder="Search services..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if (!empty($services)): ?>
            <table>
                <tr>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price ($)</th>
                    <th>Duration (Minutes)</th>
                </tr>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= htmlspecialchars($service['serviceName']) ?></td>
                        <td><?= htmlspecialchars($service['description']) ?></td>
                        <td><?= number_format($service['price'], 2) ?></td>
                        <td><?= htmlspecialchars($service['duration']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No services are currently available. Please check back later.</p>
        <?php endif; ?>

        <a href="admindash.php" class="back-button">Back </a>
    </div>
</body>
</html>
