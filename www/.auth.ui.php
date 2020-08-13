<?php

    function auth_enter_login($err)
    {
        echo "
<form method=post>
<div class=centered>
<table border=3 cellpadding=3 cellspacing=0 align=center>
<tr><th colspan=2 style='background:#4020C0; color:white'>Login</th></tr>";

        if ($err != "")
            echo "<tr><td colspan=2 style='background:#F57E85' align=center>$err</td></tr>";

        echo "
<tr><td>Login:</td><td><input type=text name=login></td></tr>
<tr><td>Password:</td><td><input type=password name=pass></td></tr>
<tr><td colspan=2 align=center><input type=submit value='Login'></td></tr>
</table>
</div>
</form>
";
    }
    
    function auth_enter_ga_code($l,$p,$err)
    {
        echo "
<form method=post>
<input type=hidden name=login value='$l'>
<input type=hidden name=pass value='$p'>
<div class=centered>
<table border=3 cellpadding=3 cellspacing=0 align=center>
<tr><th colspan=2 style='background:#4020C0; color:white'>Google Authenticator</th></tr>";

        if ($err != "")
            echo "<tr><td colspan=2 style='background:#F57E85' align=center>$err</td></tr>";

        echo "
<tr><td>Code:</td><td><input type=text name=gacode autocomplete=off></td></tr>
<tr><td colspan=2 align=center><input type=submit value='Enter'></td></tr>
</table>
</div>
</form>
";
    }     
    
    function auth_logged()
    {
        echo "<script>window.location.href=window.location.href;</script>";
        die();
    }
?>