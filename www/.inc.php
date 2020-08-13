<?php
    $db = new mysqli("localhost", "ff", "ffpass", "ff");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    function reload()
    {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

    function show_error($str)
    {
        echo "<font color=red>$str</font><br>";
    }

?>