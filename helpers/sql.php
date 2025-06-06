<?php
    require_once __DIR__ . '/config.php';

    function Sql_init()
    {
        $conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

        if ($conn->connect_error) {
            die("Connection failure: " . $conn->connect_error);
        }

        return $conn;
    }

    // that is example for specific operation that use responce
    /*
    function Sql_query($sql)
    {
        $mysqli = Sql_init();
        $res = mysqli_query($mysqli, $sql);
        $conn->close();
    }
    */
?>
