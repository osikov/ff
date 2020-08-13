<?php
    require '.inc.php';
    require '.auth.php';
?>
<html>
<style>
.centered{
  display:flex;
   justify-content:center;
   align-items:center;
   height:60vh;
}
body{
font-family: Arial, Helvetica, sans-serif;
margin:0;
}
</style>
<div style='wdith:100%; background:#4020C0;'>
<img src='imgs/fastflux.jpg'><br>
</div>
<?php require '.menu.php'; ?>

<?php
    auth_check_login();
    if ($login == "")
        die();
?>
