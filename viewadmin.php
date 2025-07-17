<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "dvc_btps");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin data (if needed, else just fetch dashboard info)
$totalEmployees = $conn->query("SELECT COUNT(*) AS total FROM employees")->fetch_assoc()['total'];
$vacantQuarters = $conn->query("SELECT COUNT(*) AS total FROM quarters WHERE status = 'vacant'")->fetch_assoc()['total'];
$occupiedQuarters = $conn->query("SELECT COUNT(*) AS total FROM quarters WHERE status = 'occupied'")->fetch_assoc()['total'];
$requestedQuarters = $conn->query("SELECT COUNT(*) AS total FROM quarter_requests")->fetch_assoc()['total'];
$recentEmployees = $conn->query("SELECT * FROM employees ORDER BY created_at DESC LIMIT 10");
$latestNotice = $conn->query("SELECT notice FROM notices ORDER BY date_added DESC LIMIT 1")->fetch_assoc()['notice'] ?? 'No Notice';
$holidays = $conn->query("SELECT * FROM holidays WHERE holiday_date >= CURDATE() ORDER BY holiday_date ASC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6fc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        h1 {
            color: #4b2aad;
            text-align: center;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 30px 0;
        }
        .card {
            flex: 1;
            padding: 20px;
            background: white;
            border-left: 5px solid #4b2aad;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .section {
            margin: 30px 0;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4b2aad;
            color: white;
        }
        .section h2 {
            color: #4b2aad;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>

    <div class="stats">
        <div class="card">
            <h3>Total Employees</h3>
            <p><?php echo $totalEmployees; ?></p>
        </div>
        <div class="card">
            <h3>Vacant Quarters</h3>
            <p><?php echo $vacantQuarters; ?></p>
        </div>
        <div class="card">
            <h3>Occupied Quarters</h3>
            <p><?php echo $occupiedQuarters; ?></p>
        </div>
        <div class="card">
            <h3>Requested Quarters</h3>
            <p><?php echo $requestedQuarters; ?></p>
        </div>
    </div>

    <div class="section">
        <h2>Recent Employees</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Department</th><th>Designation</th></tr>
            <?php while ($row = $recentEmployees->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>Notice Board</h2>
        <p><?php echo htmlspecialchars($latestNotice); ?></p>
    </div>

    <div class="section">
        <h2>Upcoming Holidays</h2>
        <table>
            <tr><th>Date</th><th>Description</th></tr>
            <?php while ($h = $holidays->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date("d-M-Y", strtotime($h['holiday_date'])); ?></td>
                    <td><?php echo htmlspecialchars($h['description']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>