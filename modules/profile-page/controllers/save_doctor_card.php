<?php
require_once __DIR__ . '/../../../helpers/session-start.php';
require_once __DIR__ . '/../../../helpers/sql.php';
require_once __DIR__ . '/../../../helpers/alert.php';

if(!isset($_SESSION['user']['email']) && $_SESSION['user']['user_type'] == "doctor")
{
    die('Access denied. You must be logged in.');
}

$mysqli = Sql_init();
$stmt = $mysqli->prepare("
    SELECT user_id FROM users WHERE email = ?
");
$stmt->bind_param("s", $_SESSION['user']['email']);
$stmt->execute();
$result = $stmt->get_result();
if($user = $result->fetch_assoc())
    $user_id = $user['user_id'];
alert($user_id);

// Save image
$image = $_FILES['image'];

$targetDir = "../../../images/users/";
$targetFile = $targetDir . basename($image["name"]);

// Create uploads directory if not exists
if(!is_dir($targetDir)) mkdir($targetDir, 0755, true);

// Move uploaded file
if(move_uploaded_file($image["tmp_name"], $targetFile))
{
    $stmt = $mysqli->prepare("INSERT INTO pictures (file_path) VALUES (?)");
    $stmt->bind_param("s", $targetFile);
    $stmt->execute();
    $pictureId = $stmt->insert_id;
}
else
{
    alert("Error saving doctor card: " . $stmt->error);
}

// Sanitize and validate POST inputs
$specialization_id = intval($_POST['specialty']);
$clinic_name = trim($_POST['clinic_name']);
$clinic_type = trim($_POST['clinic_type']);
$city = trim($_POST['city']);
$price = floatval($_POST['price']);

// Save to the doctors table
$stmt = $mysqli->prepare("
    INSERT INTO doctors 
    (doctor_id, specialization_id, clinic_name, clinic_type, city, price, photo_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    specialization_id = VALUES(specialization_id),
    clinic_name = VALUES(clinic_name),
    clinic_type = VALUES(clinic_type),
    city = VALUES(city),
    price = VALUES(price),
    photo_id = VALUES(photo_id)
");

$stmt->bind_param("iisssdi", $user_id, $specialization_id, $clinic_name, $clinic_type, $city, $price, $pictureId);
if($stmt->execute())
{
    header("Location: /modules/profile-page/controllers/profile-doctor.php");
    exit;
}
else
{
    alert("Error saving doctor card: " . $stmt->error);
}
?>
