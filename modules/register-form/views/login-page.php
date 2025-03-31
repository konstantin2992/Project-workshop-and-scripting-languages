<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <?php
        require_once __DIR__ . '/../../../helpers/config.php';
        require_once __DIR__ . '/../google-login/google-oauth.php';
    ?>
    <form action="<?php echo AUNTIFICATION_LOC; ?>/controllers/login.php" method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
        <br>
        <button type="submit">Login</button>
        <br>
        <a href="<?php echo $client->createAuthURL(); ?>" class="google-login-btn">Login trough Google</a>
        <br>
        <a href="<?php echo AUNTIFICATION_LOC; ?>/controllers/registration.php">Register</a>
        <br>
        <a href="/forgot-password">Forgot Password?</a>
    </form>
</body>

</html>
