<?php
    if (array_key_exists('logout',$_REQUEST))
    {
        session_start();
        unset($_SESSION['login']);
    }
?>
<script>window.location.href = 
location.href.substring(0, location.href.lastIndexOf("/")+1)+"profile.php";</script>