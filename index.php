<?php

$uri = trim($_SERVER['REQUEST_URI'], '/');

switch ($uri)
{
    case '':
    case 'home':
        require __DIR__ . '/modules/home-page/controllers/home.php';
        break;
    case 'about':
        require __DIR__ . '/modules/about-us/controllers/about-us.php';
        break;
    // Add more routes here...
    default:
        http_response_code(404);
        echo "Page not found.";
}
?>
