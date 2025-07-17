<?php
$conn = new mysqli("localhost", "root", "", "dvc_btps");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_GET['id'] ?? null;
if (!$id) die("Employee ID not provided.");

$emp_result = $conn->query("SELECT * FROM employees WHERE employee_id = '$id'");
if ($emp_result->num_rows == 0) die("Employee not found.");
$emp = $emp_result->fetch_assoc();

$attendance = $conn->query("SELECT SUM(present_days) AS total FROM attendance WHERE employee_id = '$id'")->fetch_assoc()['total'] ?? 0;
$leaves = $conn->query("SELECT SUM(leave_days) AS total FROM leaves WHERE employee_id = '$id'")->fetch_assoc()['total'] ?? 0;
$awards = $conn->query("SELECT COUNT(*) AS total FROM awards WHERE employee_id = '$id'")->fetch_assoc()['total'] ?? 0;

$notice = $conn->query("SELECT notice FROM notices ORDER BY date_added ASC LIMIT 1")->fetch_assoc()['notice'] ?? 'No Notice';
$holidays = $conn->query("SELECT * FROM holidays WHERE holiday_date >= CURDATE() ORDER BY holiday_date LIMIT 4");

$joining_date = new DateTime($emp['date_of_joining']);
$today = new DateTime();
$interval = $joining_date->diff($today);
$work_duration = $interval->y . " years " . $interval->m . " months";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Employee Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: #f8f9fa;
      margin: 0;
    }

    .header {
      background: #fff;
      border-bottom: 3px solid #e31e24;
      padding: 20px;
      font-size: 28px;
      text-align: center;
      font-weight: bold;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      padding: 20px;
      gap: 20px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      flex: 1;
      min-width: 300px;
    }

    .section-title {
      background: #2e3aa0;
      color: white;
      padding: 8px 12px;
      font-weight: bold;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .info-box {
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 8px;
      background: #f1f1f1;
    }

    .button {
      background: #2e3aa0;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px;
      margin: 5px 5px 0 0;
      font-weight: bold;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      padding: 6px 8px;
      border-bottom: 1px solid #eee;
    }

    .holiday-box {
      padding: 8px;
      border-radius: 5px;
      margin: 6px 0;
    }

    .bg-red { background-color: #ffe6e6; }
    .bg-green { background-color: #e6ffe6; }
    .bg-yellow { background-color: #fffacd; }
    .bg-blue { background-color: #e6f0ff; }
  </style>
</head>
<body>

<div class="header">EMPLOYEE DASHBOARD</div>

<div class="container">
  <!-- Left Card: Profile -->
  <div class="card" style="text-align: center;">
    <img src="user.gif" width="70" alt="Profile Icon">
    <h2><?= htmlspecialchars($emp['name']) ?></h2>
    <p><strong><?= htmlspecialchars($emp['designation']) ?></strong></p>
    <p><strong>At work for:</strong> <?= $work_duration ?></p>
    <div>
      <div class="button"><?= $attendance ?> ATTENDANCE</div>
      <div class="button"><?= $leaves ?> LEAVES</div>
      <div class="button"><?= $awards ?> AWARDS</div>
    </div>
  </div>

  <!-- Middle Card: Personal & Company Details -->
  <div class="card">
    <div class="section-title">Personal Details</div>
    <table>
      <tr><td><strong>Name</strong></td><td><?= htmlspecialchars($emp['name']) ?></td></tr>
      <tr><td><strong>Father's Name</strong></td><td><?= htmlspecialchars($emp['father_name']) ?></td></tr>
      <tr><td><strong>Date of Birth</strong></td><td><?= date("d-M-Y", strtotime($emp['dob'])) ?></td></tr>
      <tr><td><strong>Gender</strong></td><td><?= htmlspecialchars($emp['gender']) ?></td></tr>
      <tr><td><strong>Email</strong></td><td><?= htmlspecialchars($emp['email']) ?></td></tr>
      <tr><td><strong>Phone</strong></td><td><?= htmlspecialchars($emp['phone']) ?></td></tr>
      <tr><td><strong>Local Address</strong></td><td><?= htmlspecialchars($emp['local_address']) ?></td></tr>
      <tr><td><strong>Permanent Address</strong></td><td><?= htmlspecialchars($emp['permanent_address']) ?></td></tr>
    </table>

    <div class="section-title" style="margin-top:15px;">Company Details</div>
    <table>
      <tr><td><strong>Employee ID</strong></td><td><?= htmlspecialchars($emp['employee_id']) ?></td></tr>
      <tr><td><strong>Department</strong></td><td><?= htmlspecialchars($emp['department']) ?></td></tr>
      <tr><td><strong>Designation</strong></td><td><?= htmlspecialchars($emp['designation']) ?></td></tr>
    </table>

    <a class="button" href="http://localhost/dvc_form/allotform.html">Apply for Quarter</a>
  </div>

  <!-- Right Card: Notices & Holidays -->
  <div class="card">
    <div class="section-title">Notice Board</div>
    <p><?= htmlspecialchars($notice) ?></p>

    <div class="section-title" style="margin-top:15px;">Upcoming Holidays</div>
    <?php
      $colors = ['bg-red', 'bg-green', 'bg-yellow', 'bg-blue'];
      $i = 0;
      if ($holidays->num_rows > 0):
        while($h = $holidays->fetch_assoc()):
          $color = $colors[$i++ % count($colors)];
    ?>
      <div class="holiday-box <?= $color ?>">
        Office Off — <?= date("d M Y", strtotime($h['holiday_date'])) ?> (<?= htmlspecialchars($h['description'] ?? 'Holiday') ?>)
      </div>
    <?php endwhile; else: ?>
      <p>No upcoming holidays.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>