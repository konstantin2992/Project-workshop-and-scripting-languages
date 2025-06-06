<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/../../../helpers/header/header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/login.css">
    <title>Login Page</title>
</head>


<body>
    <?php require_once __DIR__ . '/../../../helpers/config.php'; ?>
    
    <div class="login-section">
<!-- action="<?php //echo AUNTIFICATION_LOC; ?>/controllers/login.php" -->
        <form method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
            <br>
            <button type="submit">Login</button>
            <br>
            <a href="<?php echo AUNTIFICATION_LOC; ?>/controllers/google-oauth.php" class="google-login-btn">Login through Google</a>
            <br>
            <a href="<?php echo AUNTIFICATION_LOC; ?>/controllers/registration.php">Register</a>
            <br>
            <a href="/forgot-password">Forgot Password?</a>
        </form>
    </div>
</body>

<?php require_once __DIR__ . '/../../../helpers/footer/footer-page.php'; ?>

</html>
