<?php
require_once __DIR__ . '/../../../helpers/session-start.php';
require_once __DIR__ . '/../../../helpers/sql.php';
require_once __DIR__ . '/../../../helpers/alert.php';

$errors = [];

if(!empty($_POST) || !empty($email) || !empty($password))
{
    if(empty($email))
        $email = $_POST['email'];
    if(empty($password))
        $password = hash('sha512', $_POST['password']);

    $mysqli = Sql_init();

    $stmt = $mysqli->prepare("
        SELECT user_id, email, password_hash, first_name, last_name, phone, user_type
        FROM users
        WHERE email = ?
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($user = $result->fetch_assoc())
    {
        if($password === $user['password_hash'])
        {
            $_SESSION['user'] = [
                'user_id'    => $user['user_id'],
                'email'      => $user['email'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'phone'      => $user['phone'],
                'user_type'  => $user['user_type'],
            ];

            if(isset($_POST['checkbox']))
            {
                setcookie("email", $user['email']);
                setcookie("password", $user['password_hash']);
            }

            if($user['user_type'] == "patient")
                header('Location: /modules/home-page/controllers/home.php');
            else if($user['user_type'] == "doctor")
                header('Location: /modules/home-page/controllers/home.php');
            else if($user['user_type'] == "admin")
                header('Location: /modules/admin-page/controllers/admin.php');

            exit;
        } else {
            $errors[] = 'Невірний пароль';
        }
    } else {
        $errors[] = 'Користувача з таким Email не знайдено';
    }
}

include __DIR__ . '/../views/login-page.php';
?>
