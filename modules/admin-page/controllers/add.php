<?php

require_once __DIR__ . '/../../../helpers/sql.php';

$conn = Sql_init();

$table = $_POST['table'];
$fields = [];
$values = [];

try
{
    foreach($_POST as $key => $val)
    {
        if($key !== 'table')
        {
            $fields[] = "`$key`";
            $values[] = "'" . $conn->real_escape_string($val) . "'";
        }
    }

    $sql = "INSERT INTO `$table` (" . implode(",", $fields) . ") VALUES (" . implode(",", $values) . ")";
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
