<?php
    require_once __DIR__ . '/../../../helpers/alert.php';
    require_once __DIR__ . '/../../../helpers/config.php';
    //that for google auth library
    require_once __DIR__ . '/../../../vendor/autoload.php';

    session_start();

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

        $email = $googleAccountInfo->email;
        $id = $googleAccountInfo->id;

        alert("Id is: " . $id . ". And email: " . $email);
    }
?>
