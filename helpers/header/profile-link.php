<?php
    require_once __DIR__ . '/../sql.php';

    if(!empty($_SESSION))
    {
        $mysqli = Sql_init();
        $sql = '
            SELECT first_name, last_name
            FROM users
            WHERE email = ?
        ';

        $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "s",
            $email
        );

        $email = $_SESSION["email"];

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result))
            echo($row["first_name"]);
        else
        {
            echo("
            <div id='auth'>
                <a href='/../../modules/register-form/controllers/login.php'>Login</a>
            </div>
            ");
        }
    }
?>
