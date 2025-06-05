<?php

require_once __DIR__ . '/../../../helpers/sql.php';

$conn = Sql_init();

$table = $_GET['table'];
$key = $_GET['key'];
$id = $_GET['id'];

try
{
    $sql = "DELETE FROM `$table` WHERE `$key` = '" . $conn->real_escape_string($id) . "'";
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
