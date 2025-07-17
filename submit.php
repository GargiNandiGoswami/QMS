<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "dvc_quarter_allotment";

// 1. Connect to DB
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Handle signature file upload
$signature = "";
if (isset($_FILES["signature"]) && $_FILES["signature"]["error"] == 0) {
    $signature_name = time() . "_" . basename($_FILES["signature"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $signature_name;
    if (move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
        $signature = $signature_name;
    } else {
        die("Failed to upload signature.");
    }
}

// 3. Collect form data
$employee_name = $_POST["employee_name"];
$designation_name = $_POST["designation_name"];
$basic_pay = $_POST["basic_pay"];
$grade_pay = $_POST["grade_pay"];
$spl_pay = $_POST["spl_pay"];
$tech_pay = $_POST["tech_pay"];
$duty_allowance = $_POST["duty_allowance"];
$npa = $_POST["npa"];
$date_entry_dvc = $_POST["date_entry_dvc"];
$date_join_station = $_POST["date_join_station"];
$date_slab_entry = $_POST["date_slab_entry"];
$service_continuity = $_POST["service_continuity"];
$marital_status = $_POST["marital_status"];
$present_qtr_room = $_POST["present_qtr_room"];
$family_accommodation_old = $_POST["family_accommodation_old"];
$hra_old_station = $_POST["hra_old_station"];
$preferred_quarters = $_POST["preferred_quarters"];
$willing_any_qtr = $_POST["willing_any_qtr"];
$spouse_quarter_info = $_POST["spouse_quarter_info"];
$caste_status = $_POST["caste_status"];
$undertaking_a = $_POST["undertaking_a"];
$undertaking_a_response = $_POST["undertaking_a_response"];
$undertaking_b = $_POST["undertaking_b"];
$undertaking_b_response = $_POST["undertaking_b_response"];
$dob = $_POST["dob"];
$apply_date = $_POST["apply_date"];

// 4. Insert data into DB
$sql = "INSERT INTO family_accommodation_applications (
    employee_name, designation_name, basic_pay, grade_pay, spl_pay, tech_pay,
    duty_allowance, npa, date_entry_dvc, date_join_station, date_slab_entry,
    service_continuity, marital_status, present_qtr_room, family_accommodation_old,
    hra_old_station, preferred_quarters, willing_any_qtr, spouse_quarter_info,
    caste_status, undertaking_a, undertaking_a_response, undertaking_b,
    undertaking_b_response, dob, apply_date, signature
) VALUES (
    '$employee_name', '$designation_name', '$basic_pay', '$grade_pay', '$spl_pay', '$tech_pay',
    '$duty_allowance', '$npa', '$date_entry_dvc', '$date_join_station', '$date_slab_entry',
    '$service_continuity', '$marital_status', '$present_qtr_room', '$family_accommodation_old',
    '$hra_old_station', '$preferred_quarters', '$willing_any_qtr', '$spouse_quarter_info',
    '$caste_status', '$undertaking_a', '$undertaking_a_response', '$undertaking_b',
    '$undertaking_b_response', '$dob', '$apply_date', '$signature'
)";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Form submitted successfully!'); window.location.href='allotform.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
