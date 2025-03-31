<?php
    require __DIR__ . '/../../../helpers/alert.php';

    include __DIR__ . '/../views/login-page.php';

    if(isset($_POST['remember']))
    {
        setcookie('login', $_POST['login'], (time()+((365*24*60*60)*3)));
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
        alert("you set login - \"{$_POST['login']}\" and password - \"{$_POST['password']}\" and remember is - \"{$_POST['remember']}\", but your coockie has login - \"{$_COOKIE['login']}\" and password - \"{$_COOKIE['password']}\"");
    }
?>
