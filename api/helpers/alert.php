<?php
    function alert($msg)
    {
        echo "<script>alert(" . json_encode($msg) . ");</script>";
    }
?>
