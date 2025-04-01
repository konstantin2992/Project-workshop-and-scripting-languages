<?php
    require_once __DIR__ . '/../../../helpers/alert.php';

    include __DIR__ . '/../views/login-page.php';

    if(isset($_POST['remember']))
    {
        setcookie('email', $_POST['email'], (time()+((365*24*60*60)*3)));
        setcookie('password', $_POST['password'], (time()+((365*24*60*60)*3)));
    }
    /* That for deleting cookie from memory. I set it here as an example, but in future would be good to put it in "leave acount" button.
    else
    {
        setcookie('login', $_POST['login'], ( time() - (24 * 60 * 60) ));
        setcookie('password', $_POST['password'], ( time() - (24 * 60 * 60) ));
    }
    */
    if(!empty($_POST))
    {
        alert("you set email - \"{$_POST['email']}\" and password - \"{$_POST['password']}\" and remember is - \"{$_POST['remember']}\", but your coockie has login - \"{$_COOKIE['email']}\" and password - \"{$_COOKIE['password']}\"");
    }
?>
