<?php
    require_once __DIR__ . '/../../../helpers/config.php';
    require_once __DIR__ . '/../../../vendor/autoload.php';
    require_once __DIR__ . '/../helpers/session-start.php';
    require_once __DIR__ . '/../../../helpers/alert.php';
    require_once __DIR__ . '/../../../helpers/sql.php';

    $client = new Google_Client();
    $client->setClientId(GOOGLE_CLIENT_ID);
    $client->setClientSecret(GOOGLE_CLIENT_SECRET);
    $client->setRedirectUri(GOOGLE_REDIRECT_URL);
    $client->addScope("email");
    $client->addScope("profile");

    if(!isset($_GET['code']))
    {
        header('Location: ' . $client->createAuthUrl());
        exit;
    }
    else
    {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        $googleAccount = new Google_Service_Oauth2($client);
        $googleAccountInfo = $googleAccount->userinfo->get();

        $info["email"] = $googleAccountInfo->email;
    }

    $mysqli = Sql_init();
    $sql = '
        SELECT email, password_hash
        FROM users
        WHERE email = ?
    ';

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s",
        $info["email"]
    );

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result))
    {
        $email = $row['email'];
        $password = $row['password_hash'];
        require_once __DIR__ . '/../../../modules/register-form/controllers/login.php';
    }
    else
        alert("We don't find account!"); // TODO change to redirect on register or go to home, login or something like that.

?>
