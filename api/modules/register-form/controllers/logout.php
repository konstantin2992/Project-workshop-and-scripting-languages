<?php

require_once __DIR__ . '/../../../helpers/session-start.php';

session_unset();
session_destroy();

header('Location: /modules/home-page/controllers/home.php');
exit;
?>
