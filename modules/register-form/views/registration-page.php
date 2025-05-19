<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>

<body>
    <?php require __DIR__ . '/../../../helpers/config.php'; ?>
    <form action="<?php echo AUNTIFICATION_LOC; ?>/controllers/registration.php" method="POST">
        <label for="first-name">*First name:</label>
        <input type="text" id="first-name" name="first-name" maxlength="100" required>
        <br>
        <label for="last-name">*Last name:</label>
        <input type="text" id="last-name" name="last-name" maxlength="100" required>
        <br>
        <label for="email">*Email:</label>
        <input type="email" id="email" name="email" placeholder="example@gmail.com" maxlength="255" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="123-45-6789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12">
        <br>
        <label for="birth">Birth:</label>
        <input type="date" id="birth" name="birth">
        <br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Region, town, street, house" maxlength="255">
        <br>
        <label for="password">*Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="confirm-password">*Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        <br>
        <button type="submit">Register</button>
    </form>
</body>

</html>
