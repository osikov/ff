<?php
    include ".header.php";

    $ga = new PHPGangsta_GoogleAuthenticator();
    $gasecret = "";
    if (array_key_exists("gasecret", $_SESSION))
        $gasecret = $_SESSION['gasecret'];
    if ($gasecret == "")
    {
        $gasecret = $ga->createSecret();
        $_SESSION['gasecret'] = $gasecret;
    }
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('FastFlux: '.$login, $gasecret);

    if (array_key_exists("save",$_REQUEST))
    {
        $pass = $_REQUEST['pass'];
        if ($pass != "") 
        {
            $stmt = $db->prepare("update user set gasecret=AES_ENCRYPT(?,?),
                pass=SHA2(?,'512') where login=?");
            $stmt->bind_param("ssss", $gasecret, $pass, $pass, $login);
            $stmt->execute();
        }

        $gaauth = (array_key_exists('gachecked', $_REQUEST) &&
            $_REQUEST['gachecked'] == '1')? 1 : 0;
        
        $stmt = $db->prepare("update user set gaauth=? where login=?");
        $stmt->bind_param("is", $gaauth, $login);
        $stmt->execute();
    }

    // load profile values
    $res = $db->query("select gaauth from user where login='$login'");
    $row = $res->fetch_assoc();
        
    $gachecked = $row['gaauth'] == 1 ? "checked" : "";
    
echo "<br>
<form method=post>
<table border=3 cellpadding=5 cellspacing=0 align=center>
<tr><th colspan=2 style='background:#4020C0; color:white'>Profile $login</th></tr>
<tr><td>Password:</td><td><input type=password name=pass autocomplete=off></td></tr>
<tr><td colspan=2 align=center><input type=checkbox name=gachecked $gachecked value='1'> Enable Google authenticator <br><br>
<img src='$qrCodeUrl'>
<br><br>
QR code for Google authenticator<br>is unique per account<br><br>
<a href='https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img width=142 height=60 lt='Get it on Google Play' src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/></a>
<a href='https://apps.apple.com/us/app/google-authenticator/id388497605'> <img width=142 height=60 src='imgs/badge-download-on-the-app-store.svg'> </a>

</td></tr>
<tr><td colspan=2 align=center><input type=submit name=save value='Save changes'></td></tr>
</table>
</form>
";

?>
