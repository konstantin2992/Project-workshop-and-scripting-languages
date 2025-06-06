<?php
require_once __DIR__ . '/../alert.php';
require_once __DIR__ . '/../session-start.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../sql.php';

if(!empty($errors)) {
    alert(array_pop(array_reverse($errors)));
}
else if(!empty($errors)) {
    header('Location: /modules/register-form/controllers/login.php');
}

$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']);

include __DIR__ . '/header-page.php';
?>
