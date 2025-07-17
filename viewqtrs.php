<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "add_qtrs";

// Connect to DB
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM quarters ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Quarters - DVC Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        h2 {
            color: #2e3aa0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #2e3aa0;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            color: #2e3aa0;
            font-weight: bold;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>📋 List of Quarters</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Quarter No</th>
            <th>Type</th>
            <th>Block</th>
            <th>Status</th>
            <th>Grade</th>
            <th>Created At</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['quarter_no']}</td>
                        <td>{$row['quarter_type']}</td>
                        <td>{$row['block']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['grade']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No quarters added yet.</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <div class="back-link">
        <p><a href="add_quarters.html">← Add New Quarter</a> | <a href="admin.html">🏠 Admin Dashboard</a></p>
    </div>
</body>
</html>
