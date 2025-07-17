<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "dvc_quarter_allotment";

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all records
$sql = "SELECT * FROM family_accommodation_applications ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Family Accommodation Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            font-size: 14px;
            vertical-align: top;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        img {
            height: 40px;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .scrollable {
            overflow-x: auto;
        }
    </style>
</head>
<body>

<h1>All Submitted Family Accommodation Applications</h1>

<div class="scrollable">
    <table>
        <tr>
            <th>ID</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Basic Pay</th>
            <th>Grade Pay</th>
            <th>Spl Pay</th>
            <th>Tech Pay</th>
            <th>Duty Allowance</th>
            <th>NPA</th>
            <th>Date Entry DVC</th>
            <th>Joining Station</th>
            <th>Slab Entry</th>
            <th>Service Continuity</th>
            <th>Marital Status</th>
            <th>Current Qtr No.</th>
            <th>Old Family Qtr</th>
            <th>Old HRA</th>
            <th>Preferred Qtrs</th>
            <th>Willing Other Qtrs</th>
            <th>Spouse Info</th>
            <th>SC/ST</th>
            <th>Undertaking A</th>
            <th>U-A Response</th>
            <th>Undertaking B</th>
            <th>U-B Response</th>
            <th>DOB</th>
            <th>Apply Date</th>
            <th>Signature</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['employee_name']}</td>
                    <td>{$row['designation_name']}</td>
                    <td>{$row['basic_pay']}</td>
                    <td>{$row['grade_pay']}</td>
                    <td>{$row['spl_pay']}</td>
                    <td>{$row['tech_pay']}</td>
                    <td>{$row['duty_allowance']}</td>
                    <td>{$row['npa']}</td>
                    <td>{$row['date_entry_dvc']}</td>
                    <td>{$row['date_join_station']}</td>
                    <td>{$row['date_slab_entry']}</td>
                    <td>{$row['service_continuity']}</td>
                    <td>{$row['marital_status']}</td>
                    <td>{$row['present_qtr_room']}</td>
                    <td>{$row['family_accommodation_old']}</td>
                    <td>{$row['hra_old_station']}</td>
                    <td>{$row['preferred_quarters']}</td>
                    <td>{$row['willing_any_qtr']}</td>
                    <td>{$row['spouse_quarter_info']}</td>
                    <td>{$row['caste_status']}</td>
                    <td>{$row['undertaking_a']}</td>
                    <td>{$row['undertaking_a_response']}</td>
                    <td>{$row['undertaking_b']}</td>
                    <td>{$row['undertaking_b_response']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['apply_date']}</td>
                    <td><img src='uploads/{$row['signature']}' alt='Signature'></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='28'>No applications found.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>