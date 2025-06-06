<?php
ob_start();
require_once __DIR__ . '/../../../helpers/config.php';
require_once __DIR__ . '/../../../helpers/session-start.php';
require_once __DIR__ . '/../../../helpers/sql.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_valid_password($password) {
    return preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+]{8,}$/', $password);
}

function is_valid_name($name) {
    return preg_match('/^[A-Za-zА-Яа-яІіЇїЄєҐґ\'\- ]+$/u', $name);
}

function is_valid_phone(&$phone) {
    $digits = preg_replace('/\D/', '', $phone);

    if (strlen($digits) !== 10) {
        return false;
    }

    $validPrefixes = [
        '050', '066', '095', '099', // Vodafone
        '067', '068', '096', '097', '098', // Kyivstar
        '063', '073', '093' // Lifecell
    ];

    $prefix = substr($digits, 0, 3);

    if (!in_array($prefix, $validPrefixes)) {
        return false;
    }

    $phone = substr($digits, 0, 3) . '-' . substr($digits, 3, 3) . '-' . substr($digits, 6, 4);
    return true;
}

function is_valid_date($y, $m, $d) {
    return checkdate((int)$m, (int)$d, (int)$y);
}

function is_valid_gender($gender) {
    return in_array($gender, ['male', 'female', 'other']);
}

if(empty($_SESSION['user']))
{
    header('Location: /modules/register-form/controllers/login.php');
    exit;
}

$mysqli = Sql_init();

$mysqli->begin_transaction();

try {
    $stmt = $mysqli->prepare("
        SELECT email, password_hash, first_name, last_name, phone, address, birth_date, gender, user_type
        FROM users
        WHERE email = ?
    ");
    $stmt->bind_param("s", $_SESSION['user']['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt = $mysqli->prepare("
        SELECT u.user_id, u.first_name, u.last_name
        FROM appointments a
        JOIN users u ON u.user_id = a.doctor_id
        WHERE a.patient_id = ?
        GROUP BY u.user_id
    ");
    $stmt->bind_param("i", $_SESSION['user']['user_id']);
    $stmt->execute();
    $doctors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $today = date('Y-m-d');
    $stmt = $mysqli->prepare("
        SELECT a.appointment_date, a.duration_minutes, a.status, d.first_name, d.last_name
        FROM appointments a
        JOIN users d ON a.doctor_id = d.user_id
        WHERE a.patient_id = ? AND a.appointment_date >= ?
        ORDER BY a.appointment_date, a.duration_minutes
    ");
    $stmt->bind_param("is", $_SESSION['user']['user_id'], $today);
    $stmt->execute();
    $upcomingAppointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $mysqli->commit();
}
catch (Exception $e) {
    $mysqli->rollback();
    throw $e;
}

$code = "/../../../modules/user-info/controllers/user-info.php" . "?id=" . $_SESSION['user']['user_id'];
$qrCode = QrCode::create($code)
    ->setEncoding(new Encoding('UTF-8'))
    ->setSize(300);
$writer = new PngWriter();
$qrCodeResult = $writer->write($qrCode);

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
    $userType = $user['user_type'];
    $userId = $_SESSION['user']['user_id'];
    $birthParts = explode("-", $user['birth_date']);
    include __DIR__ . '/../views/profile-page.php';
}
else
{
    header('Location: /modules/register-form/controllers/login.php');
    exit;
}

if (!empty($_POST)) {
    $email = $_POST['email'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    $day = $_POST['birth_day'];
    $month = $_POST['birth_month'];
    $year = $_POST['birth_year'];
    $birthDate = "$year-$month-$day";

    $confirmPassword = $_POST['password-confirm'];
    $password = $_POST['password'];
    $newPassword = !empty($password) ? hash("sha512", $password) : $passwordHash;

    $hasError = false;

    if (!is_valid_email($email)) {
        alert("Невірна електронна адреса.");
        $hasError = true;
    }

    if (!empty($password) && !is_valid_password($password)) {
        alert("Пароль повинен містити щонайменше 8 символів, включаючи літери та цифри.");
        $hasError = true;
    }

    if (!is_valid_name($firstName)) {
        alert("Ім’я має містити лише літери (латиниця або кирилиця), пробіли або апострофи.");
        $hasError = true;
    }

    if (!is_valid_name($lastName)) {
        alert("Прізвище має містити лише літери (латиниця або кирилиця), пробіли або апострофи.");
        $hasError = true;
    }

    if (!is_valid_phone($phone)) {
        alert("Номер телефону має бути у форматі 000-000-0000 та відповідати українським операторам.");
        $hasError = true;
    }

    if (!is_valid_date($year, $month, $day)) {
        alert("Невірна дата народження.");
        $hasError = true;
    }

    if (!is_valid_gender($gender)) {
        alert("Оберіть коректну стать.");
        $hasError = true;
    }

    if ($hasError) {
        return;
    }

    if (hash('sha512', $confirmPassword) == $passwordHash) {
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
            $firstName, $lastName,
            $phone, $address,
            $birthDate, $gender,
            $_SESSION['user']['email']
        );
        $stmt->execute();

        $_SESSION['user'] = [
            'user_id'    => $userId,
            'email'      => $email,
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'phone'      => $phone,
            'user_type'  => $userType,
        ];

        setcookie("email", $email, time() + 3600, "/");
        setcookie("password", $newPassword, time() + 3600, "/");
        header('Location: /modules/home-page/controllers/home.php');
        ob_end_flush();
        exit;
    } else {
        alert("Пароль не підтверджено!");
    }
}
ob_end_flush();
?>
