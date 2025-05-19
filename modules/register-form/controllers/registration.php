<?php
    require_once __DIR__ . '/../../../helpers/config.php';
    require_once __DIR__ . '/../../../helpers/alert.php';
    require_once __DIR__ . '/../../../helpers/sql.php';
    include __DIR__ . '/../views/registration-page.php';

    if(!empty($_POST))
    {
        if($_POST['password'] == $_POST['confirm-password'])
        {
            $sql = "
                INSERT INTO users
                (email, password_hash, 
                first_name, last_name, 
                phone, birth_date, 
                address, user_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $mysqli = Sql_init();
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss",
                $email, $hashPassword, $firstName, $lastName,
                $phone, $birth, $address, $userType
            );

            $email = $_POST['email'];
            $hashPassword = hash('sha512', $_POST['password']);
            $firstName = $_POST['first-name'];
            $lastName = $_POST['last-name'];
            $phone = $_POST['phone'];
            $birth = $_POST['birth'];
            $address = $_POST['address'];
            $userType = 'patient';

            mysqli_stmt_execute($stmt);

            // alert doesn't appear, so maybe some operations would not work to - need more experiments.
            // alert("your username - \"{$_POST['username']}\" email is - \"{$_POST['email']}\" and password - \"{$_POST['password']}\"");
            header('Location: ' . AUNTIFICATION_LOC . '/controllers/login.php');
            exit;
        }
        else
        {
            alert("Your password does not equal to confirm password! Try again");
        }
    }
?>
