<?php
// DATABASE CONNECTION
$conn = new mysqli("localhost", "root", "", "dvc_btps");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// TOTAL EMPLOYEES
$total_employees = $conn->query("SELECT COUNT(*) as count FROM employees")->fetch_assoc()['count'];

// VACANT & OCCUPIED QUARTERS (Optional: Static or based on DB logic)
$vacant_quarters = 150;
$occupied_quarters = 1200;

// REQUESTED QUARTERS
$requested_quarters = $conn->query("SELECT COUNT(*) as count FROM quarter_requests")->fetch_assoc()['count'];

// RECENT EMPLOYEES (Latest 10)
$recent_employees = $conn->query("SELECT * FROM employees ORDER BY created_at DESC LIMIT 10");

// ALL EMPLOYEES (For Manage Employees)
$all_employees = $conn->query("SELECT * FROM employees");

// NOTICES
$latest_notice = $conn->query("SELECT notice FROM notices ORDER BY date_added DESC LIMIT 1")->fetch_assoc()['notice'] ?? 'No notice available.';

// UPCOMING HOLIDAYS
$upcoming_holidays = $conn->query("SELECT * FROM holidays WHERE holiday_date >= CURDATE() ORDER BY holiday_date ASC LIMIT 4");

// REQUESTED EMPLOYEES (Recent Quarter Requests)
$requested_emps = $conn->query("SELECT * FROM quarter_requests ORDER BY request_date DESC LIMIT 10");
?>

<!-- SAMPLE HTML SECTION START -->
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial; margin: 20px; background-color: #f0f2f5; }
    .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    h2 { color: #2c3e50; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ccc; }
    th { background: #2c3e50; color: white; }
  </style>
</head>
<body>

<div class="card">
  <h2>Dashboard Stats</h2>
  <p><strong>Total Employees:</strong> <?= $total_employees ?></p>
  <p><strong>Vacant Quarters:</strong> <?= $vacant_quarters ?></p>
  <p><strong>Occupied Quarters:</strong> <?= $occupied_quarters ?></p>
  <p><strong>Requested Quarters:</strong> <?= $requested_quarters ?></p>
</div>

<div class="card">
  <h2>Recent Employees</h2>
  <table>
    <tr><th>Employee ID</th><th>Name</th><th>Grade</th><th>Join Date</th></tr>
    <?php while($emp = $recent_employees->fetch_assoc()): ?>
      <tr>
        <td><?= $emp['employee_id'] ?></td>
        <td><?= $emp['name'] ?></td>
        <td><?= $emp['grade'] ?></td>
        <td><?= $emp['join_date'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<div class="card">
  <h2>Manage Employees</h2>
  <table>
    <tr><th>ID</th><th>Name</th><th>Department</th><th>Designation</th></tr>
    <?php while($emp = $all_employees->fetch_assoc()): ?>
      <tr>
        <td><?= $emp['employee_id'] ?></td>
        <td><?= $emp['name'] ?></td>
        <td><?= $emp['department'] ?></td>
        <td><?= $emp['designation'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<div class="card">
  <h2>Recent Quarter Requests</h2>
  <table>
    <tr><th>Employee ID</th><th>Name</th><th>Grade</th><th>Requested Quarter</th><th>Date</th></tr>
    <?php while($rq = $requested_emps->fetch_assoc()): ?>
      <tr>
        <td><?= $rq['employee_id'] ?></td>
        <td><?= $rq['name'] ?></td>
        <td><?= $rq['grade'] ?></td>
        <td><?= $rq['requested_quarter'] ?></td>
        <td><?= $rq['request_date'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<div class="card">
  <h2>Latest Notice</h2>
  <p><?= $latest_notice ?></p>
</div>

<div class="card">
  <h2>Upcoming Holidays</h2>
  <ul>
    <?php while($h = $upcoming_holidays->fetch_assoc()): ?>
      <li><?= date('d M Y', strtotime($h['holiday_date'])) ?> - <?= $h['description'] ?></li>
    <?php endwhile; ?>
  </ul>
</div>

</body>
</html>