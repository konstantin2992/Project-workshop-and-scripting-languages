<?php
    require_once __DIR__ . '/../../../helpers/alert.php';
    require_once __DIR__ . '/../../../helpers/sql.php';
    include __DIR__ . '/../views/login-page.php';

    /* That for deleting cookie from memory. I set it here as an example, but in future would be good to put it in "leave acount" button.
    else
    {
        setcookie('login', $_POST['login'], ( time() - (24 * 60 * 60) ));
        setcookie('password', $_POST['password'], ( time() - (24 * 60 * 60) ));
    }
    */

    if(!empty($_POST))
    {
        $mysqli = Sql_init();
        $sql = '
            SELECT email, password_hash
            FROM users
            WHERE email = ?
        ';

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s",
            $email
        );

        $email = $_POST['email'];
        $hashPassword = hash('sha512', $_POST['password']);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result))
            if($hashPassword == $row['password_hash'])
            {
                if(isset($_POST['remember']))
                {
                    setcookie('email', $email, (time()+((365*24*60*60)*3)));
                    setcookie('password', $hashPassword, (time()+((365*24*60*60)*3)));
                }
                alert("Success! You loggined into: " . $row['email']);
            }
        else
            alert("No");
    }
?>
