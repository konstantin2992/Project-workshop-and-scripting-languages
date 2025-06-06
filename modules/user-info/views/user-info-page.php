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
