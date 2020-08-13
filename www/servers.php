<?php
    include ".header.php";

    if (array_key_exists('add',$_REQUEST))
    {
        $stmt = $db->prepare("insert into server (server,pass) values (?,?)");
        $stmt->bind_param("ss", $_REQUEST['server'], $_REQUEST['spass']);
        $stmt->execute();
    }

?>
<script>
function delserver(i) 
{
}
</script>
<style>th { background-color: #4020C0; color:white }</style>
<br>
<table cellpadding=5 cellspacing=0 border=3 align=center>
<tr>
<th></th>
<th>Server</th>
<th>Ping</th>
<th>SSH</th>
<th>Http</th>
<th>System checks</th>
<th>Assignment</th>
<th>Enabled</th>
<th></th>
</tr>
<?php
    function nullable($v, $en, $di)
    {
        if ($v == '') return '';
        if ($v == 1) return $en;
        if ($v == 0) return $di;
    }

    function nullable2yn($v)
    {
        return nullable($v, '<font color=green>+</font>','<font color=red>X</font>');
    }

    $res = $db->query("select s.*,u.login from server s left join user u on s.user=u.id");
    while($row = $res->fetch_assoc())
    {
        echo "<tr>";
        echo "<td><a href='javascript:delserver(".$row['id'].")'>DELETE</a></td>";
        echo "<td>".$row['server']."</td>";
        echo "<td>".nullable2yn($row['ping'])."</td>";
        echo "<td>".nullable2yn($row['ssh'])."</td>";
        echo "<td>".nullable2yn($row['http'])."</td>";
        echo "<td>".nullable2yn($row['sys'])."</td>";
        echo "<td>".$row['login']."</td>";
        echo "<td>".nullable($row['status'],"<font color=green>ENABLED", "<font color=red>DISABLED")."</td>";
        echo "<td><a href='?en=0&id=".$row['id']."'>DISABLE</a> / <a href='?en=1&id=".$row['id']."'>ENABLE</a></td>";
        echo "</tr>";
    }
?>
</table>


<br>
<form method=post>
<table cellpadding=5 cellspacing=0 border=3 align=center>
<tr><th colspan=2>New server</th></tr>
<tr><td>Server:</td><td><input type=text name=server></td></tr>
<tr><td>Password:</td><td><input type=password name=spass></td></tr>
<tr><td align=right colspan=2><input type=submit name=add value='Add'></td></tr></table>
</table>
</form>
