<?php
require_once __DIR__ . '/../../../helpers/session-start.php';
require_once __DIR__ . '/../../../helpers/sql.php';

$doctor_id = $_SESSION['user']['user_id'];

if (!isset($_GET['patient_id'])) {
    echo "Пацієнт не вибраний.";
    exit;
}

$patient_id = intval($_GET['patient_id']);

$mysqli = Sql_init();
// Fetch patient info
$stmt = $mysqli->prepare("SELECT first_name, last_name FROM users WHERE user_id = ? AND user_type = 'patient'");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();

// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $message = trim($_POST['message']);
    $stmt = $mysqli->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $doctor_id, $patient_id, $message);
    $stmt->execute();

    // Insert reminder for receiver (if not already pending in last 15 minutes)
    $stmt = $mysqli->prepare("
        INSERT INTO reminders (patient_id, reminder_type, scheduled_time, status)
        VALUES (?, 'push', NOW(), 'pending')
    ");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();

    header("Location: chat.php?patient_id=" . $patient_id);
    exit;
}

// Fetch all messages between doctor and patient
$stmt = $mysqli->prepare("
    SELECT m.*, u.first_name, u.last_name FROM messages m
    JOIN users u ON u.user_id = m.sender_id
    WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
    ORDER BY sent_at ASC
");
$stmt->bind_param("iiii", $doctor_id, $patient_id, $patient_id, $doctor_id);
$stmt->execute();
$messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">

<?php require_once __DIR__ . '/../../../helpers/header/header.php'; ?>

<head>
    <meta charset="UTF-8">
    <title>Чат з <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .message-box { max-width: 600px; margin: auto; }
        .message { padding: 10px; margin-bottom: 10px; border-radius: 8px; }
        .sent { background-color: #dff9fb; text-align: right; }
        .received { background-color: #f1f2f6; text-align: left; }
        .message-form { margin-top: 20px; display: flex; gap: 10px; }
        textarea { width: 100%; padding: 10px; }
        button { padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="message-box">
        <h2>Чат з <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?></h2>

        <?php foreach ($messages as $msg): ?>
            <div class="message <?= $msg['sender_id'] == $doctor_id ? 'sent' : 'received' ?>">
                <div><strong><?= htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']) ?></strong></div>
                <div><?= htmlspecialchars($msg['content']) ?></div>
                <div style="font-size: 12px; color: gray;"><?= $msg['sent_at'] ?></div>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="message-form">
            <textarea name="message" rows="3" placeholder="Напишіть повідомлення..." required></textarea>
            <button type="submit">Надіслати</button>
        </form>
    </div>
</body>
</html>
