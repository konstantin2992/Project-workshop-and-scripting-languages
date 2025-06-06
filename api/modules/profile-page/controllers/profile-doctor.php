<?php

ob_start();
require_once __DIR__ . '/../../../helpers/session-start.php';
require_once __DIR__ . '/../../../helpers/sql.php';

if(empty($_SESSION['user']))
{
    header('Location: /modules/register-form/controllers/login.php');
    exit;
}

$mysqli = Sql_init();

$stmt = $mysqli->prepare("
    SELECT email, password_hash, first_name, last_name, phone, address, birth_date, gender, user_type
    FROM users
    WHERE email = ?
");
$stmt->bind_param("s", $_SESSION['user']['email']);
$stmt->execute();
$result = $stmt->get_result();

// Fetch specializations
$stmt = $mysqli->prepare("SELECT specialization_id, name FROM specializations ORDER BY name ASC");
$stmt->execute();
$specializations = $stmt->get_result();

// Optional: hardcoded clinic list (could also come from a `clinics` table)
$stmt = $mysqli->prepare("SELECT clinic_id, name FROM clinics ORDER BY name ASC");
$stmt->execute();
$clinics = $stmt->get_result();

$stmt = $mysqli->prepare("
    SELECT 
        appointments.appointment_id,
        appointments.created_at,
        appointments.duration_minutes,
        appointments.status,
        appointments.doctor_id,
        users.first_name,
        users.last_name,
        users.address AS patient_address
    FROM appointments
    JOIN users ON users.user_id = appointments.patient_id
    WHERE doctor_id = ?
    ");
$stmt->bind_param("i", $_SESSION['user']['user_id']);
$stmt->execute();
$appointments = $stmt->get_result();

$stmt = $mysqli->prepare("
    SELECT a.doctor_id, u.user_id, u.first_name, u.last_name, u.phone
    FROM appointments a
    JOIN users u ON u.user_id = a.patient_id
    WHERE a.doctor_id = ?
");
$stmt->bind_param("i", $_SESSION['user']['user_id']);
$stmt->execute();
$patients = $stmt->get_result();

$stmt = $mysqli->prepare("
    SELECT DISTINCT u.user_id, u.first_name, u.last_name
    FROM appointments a
    JOIN users u ON u.user_id = a.patient_id
    WHERE a.doctor_id = ?
");
$stmt->bind_param("i", $_SESSION['user']['user_id']);
$stmt->execute();
$patientsWithMessages = $stmt->get_result();

$mysqli = Sql_init();

$stmt = $mysqli->prepare("
    SELECT *
    FROM reminders
    WHERE patient_id = ?
    ORDER BY scheduled_time DESC
");
$stmt->bind_param("i", $_SESSION['user']['user_id']);
if (!$stmt->execute())
    die("Execute failed: " . $stmt->error);
$reminders = $stmt->get_result();

if($user = $result->fetch_assoc())
{
    $emailCurrent = $user['email'];
    $passwordHash = $user['password_hash'];
    $birthParts = explode("-", $user['birth_date']);
    $userType = $user['user_type'];
    $userId = $user['user_id'];
    include __DIR__ . '/../views/profile-doctor-page.php';
}
else
{
    header('Location: /modules/register-form/controllers/login.php');
    exit;
}

if(!empty($_POST))
{
    $email = $_POST['email'];
    $confirmPassword = $_POST['password-confirm'];
    $birthDate = $_POST['birth_year'] . '-' . $_POST['birth_month'] . '-' . $_POST['birth_day'];
    if(!empty($_POST['password']))
        $newPassword = hash("sha512", $_POST['password']);
    else
        $newPassword = $passwordHash;

    if(hash('sha512', $confirmPassword) == $passwordHash)
    {
        $mysqli = Sql_init();

        $stmt = $mysqli->prepare("
            UPDATE users
            SET email = ?, password_hash = ?,
            first_name = ?, last_name = ?,
            phone = ?, address = ?,
            birth_date = ?, gender = ?
            WHERE email = ?
        ");
        $stmt->bind_param("sssssssss",
            $email, $newPassword,
            $_POST['first-name'], $_POST['last-name'],
            $_POST['phone'], $_POST['address'],
            $birthDate, $_POST['gender'],
            $_SESSION['user']['email']
        );
        $stmt->execute();

        $_SESSION['user'] = [
            'user_id'    => $userId,
            'email'      => $_POST['email'],
            'first_name' => $_POST['first-name'],
            'last_name'  => $_POST['last-name'],
            'phone'      => $_POST['phone'],
            'user_type'  => $userType,
        ];

        setcookie("email", $user['email'], time() + 3600, "/");
        setcookie("password", $user['password_hash'], time() + 3600, "/");
        header('Location: /modules/home-page/controllers/home.php');
        ob_end_flush();
        exit;
    }
    else
    {
        alert("Пароль не підтвердженно!");
    }
}
ob_end_flush();

?>
