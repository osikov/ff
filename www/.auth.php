<?php
    require '.GoogleAuthenticator.php';
    require '.auth.ui.php';


    $login = "";
    if (array_key_exists('login',$_SESSION))
    {
        $login = $_SESSION['login'];
    }
    $gasecret = "";
    if (array_key_exists('gasecret',$_SESSION))
    {
        $gasecret = $_SESSION['gasecret'];
    }


    function auth_check_login()
    {
        global $login;
        if ($login != "")
            return;

        if (!array_key_exists('login',$_REQUEST))
        {
            // enter login/pass
            auth_enter_login("");
            return;
        }

        $trylogin = $_REQUEST['login'];
        $trypass = $_REQUEST['pass'];
        $gacode = "";
        if (array_key_exists('gacode',$_REQUEST))
        {
            $gacode = $_REQUEST['gacode'];
        }
    
        global $db;
        $stmt = $db->prepare("insert into login_attempt values(?,NOW())");
        $stmt->bind_param("s",$trylogin);
        $stmt->execute();
        $db->query("delete from login_attempt where regtime < NOW() - interval 5 minute");
        $stmt = $db->prepare("select count(*) c from login_attempt where login=? group by login");
        $stmt->bind_param("s",$trylogin);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if ($row['c'] > 10)
        {
                auth_enter_login("Too many tries. Try again in 5 minutes.");
                return;
        }
        
        $stmt = $db->prepare("select gaauth,
          AES_DECRYPT(gasecret,?) gasecret, enabled
          from user where login=? and pass=SHA2(?,'512')");
        $stmt->bind_param("sss", $trypass, $trylogin, $trypass);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc())
        {
            if ($row['enabled'] != 1)
            {
                auth_enter_login("Account is disabled");
                return;
            }
        
            $gaauth = $row['gaauth'];
            $gasecret = $row['gasecret'];

            if ($gaauth == 1)
            {
                if ($gacode == "")
                {
                    // enter ga code
                    auth_enter_ga_code($trylogin,$trypass,"");
                    return;
                }
                else
                {
                    $ga = new PHPGangsta_GoogleAuthenticator();
                    $checkResult = $ga->verifyCode($gasecret, $gacode, 2);
                    if (!$checkResult)
                    {
                        // wrong code
                        auth_enter_ga_code($trylogin,$trypass,"Wrong code");
                        return;
                    }
                }
            }
            
            $_SESSION['login'] = $trylogin;
            $_SESSION['gasecret'] = $gasecret;
            auth_logged();
        }
        else
        {
            // wrong login or password
            auth_enter_login("Wrong login or password");
            return;
        }
    }
    
?>
