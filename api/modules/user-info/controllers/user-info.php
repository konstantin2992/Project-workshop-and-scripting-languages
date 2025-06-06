
<?php
require_once __DIR__ . '/../../../helpers/config.php';
require_once __DIR__ . '/../../../helpers/session-start.php';
require_once __DIR__ . '/../../../helpers/sql.php';

$mysqli = Sql_init();

if (!isset($_GET['id'])) {
    die("No user ID provided.");
}

$id = $_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Інформація про користувача</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 30px;
            background-color: #f2f2f2;
        }
        .user-info {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .user-info h2 {
            color: #2a5885;
            margin-bottom: 20px;
        }
        .user-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-info td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .user-info td:first-child {
            font-weight: bold;
            color: #555;
            width: 30%;
        }
    </style>
</head>
<body>
<div class="user-info">
    <h2>Інформація про користувача</h2>
    <table>
        <tr><td>Email:</td><td><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><td>Ім’я:</td><td><?= htmlspecialchars($user['first_name']) ?></td></tr>
        <tr><td>Прізвище:</td><td><?= htmlspecialchars($user['last_name']) ?></td></tr>
        <tr><td>Стать:</td><td><?= htmlspecialchars($user['gender']) ?></td></tr>
        <tr><td>Телефон:</td><td><?= htmlspecialchars($user['phone']) ?></td></tr>
        <tr><td>Дата народження:</td><td><?= htmlspecialchars($user['birth_date']) ?></td></tr>
        <tr><td>Адреса:</td><td><?= nl2br(htmlspecialchars($user['address'])) ?></td></tr>
    </table>
</div>
</body>
</html>

