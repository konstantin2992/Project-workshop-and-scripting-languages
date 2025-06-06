<?php
require_once __DIR__ . '/../../../helpers/sql.php';
require_once __DIR__ . '/../../../helpers/session-start.php';
include __DIR__ . '/../../../helpers/alert.php';

$mysqli = Sql_init();

$stmt = $mysqli->prepare("
    SELECT user_type
    FROM users
    WHERE email = ?
");
$stmt->bind_param("s", $_SESSION['user']['email']);
$stmt->execute();
$result = $stmt->get_result();

if(!isset($_SESSION['user']['email']))
{
    die("Email not set in session.");
}
if($user = $result->fetch_assoc())
{
    if(!$user)
    {
        die("User not found in database.");
    }
    if($user['user_type'] !== 'admin')
    {
        header("Location: /modules/home-page/controllers/home.php");
        exit;
    }
}

if(!empty($_GET['error']))
{
    alert($_GET['error']);
}
else if(!empty($_GET['error']))
{
    header("Location: /modules/admin-page/controllers/admin.php?table=" . urlencode($_GET['table']));
    exit;
}

$conn = Sql_init();

$tables = [];
$result = $conn->query("SHOW TABLES");
while($row = $result->fetch_array())
{
    $tables[] = $row[0];
}

$current_table = $_GET['table'] ?? $tables[0];
$columns = $conn->query("SHOW COLUMNS FROM `$current_table`")->fetch_all(MYSQLI_ASSOC);
$rows = $conn->query("SELECT * FROM `$current_table`");

function getEnumValues($conn, $table, $column)
{
    $res = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    $row = $res->fetch_assoc();
    if(preg_match("/^enum\((.*)\)$/", $row['Type'], $matches))
    {
        return array_map(function($val)
        {
            return trim($val, "'");
        }, explode(',', $matches[1]));
    }
    return [];
}

echo($_GET['error']);
require_once __DIR__ . '/../views/admin-page.php';

?>
