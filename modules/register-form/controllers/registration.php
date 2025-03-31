<?php
    require __DIR__ . '/../../../helpers/config.php';
    require __DIR__ . '/../../../helpers/alert.php';
    include __DIR__ . '/../views/registration-page.php';

    if(!empty($_POST))
    {
        if($_POST['password'] == $_POST['confirm-password'])
        {
            // alert doesn't appear, so maybe some operations would not work to - need more experiments.
            alert("your username - \"{$_POST['username']}\" email is - \"{$_POST['email']}\" and password - \"{$_POST['password']}\"");
            header('Location: ' . AUNTIFICATION_LOC . '/controllers/login.php');
            exit;
        }
        else
        {
            alert("Your password does not equal to confirm password! Try again");
        }
    }
?>
