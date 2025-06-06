<?php

require_once __DIR__ . '/../../../helpers/sql.php';
require_once __DIR__ . '/../../../helpers/alert.php';

$doctorId = $_POST['doctor_id'] ?? null;
$date = $_POST['selected_date'] ?? null;
$time = $_POST['selected_time'] ?? null;
$doctorName = $_POST['doctor-name'] ?? null;

// Validate and redirect to next step or show errors
if($doctorId && $date && $time)
{
    include __DIR__ . '/../views/payment-page.php';
    $mysqli = Sql_init();

    // Validate and sanitize input
    $patient_id = $_SESSION['user']['user_id'];
    $doctor_id = $doctorId;

    $stmt = $mysqli->prepare("INSERT INTO appointments (patient_id, doctor_id, reason) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $patient_id, $doctor_id, $reason);
    
    if($stmt->execute())
    {
        $appointment_id = $stmt->insert_id;
    }
    else
    {
        $error[] = "Database error: " . $stmt->error;
    }

    $stmt->close();

    $mysqli->close();
}
else
{
    $error[] = "Ви вибрали щось не вірно";
}
?>
