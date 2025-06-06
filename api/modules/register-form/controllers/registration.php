
<?php
require_once __DIR__ . '/../../../helpers/config.php';
require_once __DIR__ . '/../../../helpers/alert.php';
require_once __DIR__ . '/../../../helpers/sql.php';
include __DIR__ . '/../views/registration-page.php';

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

if (!empty($_POST)) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $phone = trim($_POST['phone']);
    $day = $_POST['birth_day'];
    $month = $_POST['birth_month'];
    $year = $_POST['birth_year'];
    $address = trim($_POST['address']);
    $gender = $_POST['gender'];
    $userType = 'patient';

    // 1. Password match check
    if ($password !== $confirmPassword) {
        alert("Ваш пароль у підтвердженні не збігається! Перевірте його і спробуйте заново.");
        return;
    }

    // 2. Validate inputs
    $hasError = false;
    if (!is_valid_email($email)) {
        alert("Невірна електронна адреса.");
        $hasError = true;
    }
    if (!is_valid_password($password)) {
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
        alert("Номер телефону має бути у форматі 000-000-0000.");
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

    $birth = "$year-$month-$day";
    $hashPassword = hash('sha512', $password);

    $sql = "SELECT email FROM users WHERE email = ?";
    $mysqli = Sql_init();
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result->fetch_assoc();

    if (empty($row)) {
        if(!$hasError)
        {
            $sql = "
                INSERT INTO users (
                    email, password_hash,
                    first_name, last_name,
                    phone, birth_date,
                    address, user_type,
                    gender
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssss",
                $email, $hashPassword, $firstName, $lastName,
                $phone, $birth, $address, $userType, $gender
            );
            mysqli_stmt_execute($stmt);

            header('Location: ' . AUNTIFICATION_LOC . '/controllers/login.php');
            exit;
        }
        else
        {
        }
    } else {
        alert("Електронна адреса вже занята!");
    }
}
?>

