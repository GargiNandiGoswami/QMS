<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "add_qtrs";

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$quarter_no = $_POST['quarter_no'];
$quarter_type = $_POST['quarter_type'];
$block = $_POST['block'];
$status = $_POST['status'];
$grade = $_POST['grade'];

// Prepare SQL
$sql = "INSERT INTO quarters (quarter_no, quarter_type, block, status, grade)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $quarter_no, $quarter_type, $block, $status, $grade);

// Execute
if ($stmt->execute()) {
    echo "<h3>✅ Quarter '$quarter_no' added successfully.</h3>";
    echo "<p><a href='add_quarters.html'>➕ Add Another</a> | <a href='viewqtrs.php'>📄 View Quarters</a></p>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
