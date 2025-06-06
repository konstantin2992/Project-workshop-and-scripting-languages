<?php

require_once __DIR__ . '/../../../helpers/sql.php';

$conn = Sql_init();

$table = $_POST['table'];
$key = $_POST['key'];
$id = $_POST['id'];

$updates = [];
try
{
    foreach($_POST as $field => $val)
    {
        if(!in_array($field, ['table', 'key', 'id']))
        {
            $updates[] = "`$field` = '" . $conn->real_escape_string($val) . "'";
        }
    }

    $sql = "UPDATE `$table` SET " . implode(", ", $updates) . " WHERE `$key` = '" . $conn->real_escape_string($id) . "'";
    $conn->query($sql);
    header("Location: /modules/admin-page/controllers/admin.php?table=" . urlencode($table));
    exit;
}
catch(mysqli_sql_exception $e)
{
    $error = $e->getMessage();
    header("Location: /modules/admin-page/controllers/admin.php?table=" . urlencode($table) . "&error=" . urlencode("Failed to update: " . $e->getMessage()));
    exit;
}
