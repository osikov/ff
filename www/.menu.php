<?php if ($login != "" ) { ?>

<div style='wdith:100%; background:#4020C0;'>
<style>
.menuDiv
{
  padding: 10px;
  color:white;
}
.menuDiv:hover 
{
    background-color: #301080;
}

.menuA
{
    color: white;
    text-decoration: none;
}
</style>

<table border=0 cellspacing=0 cellpadding=0 width=100%><tr><td>

<table border=0 cellspacing=0 cellpadding=0 style="margin-left: 40px">
<tr>
<td>
<a class=menuA href='domains.php'><div class=menuDiv>DOMAINS</div></a>
</td>
<td>
<a class=menuA href='profile.php'><div class=menuDiv>PROFILE</div></a>
</td>
</tr></table>

</td>
<td align=right>

<table border=0 cellspacing=0 cellpadding=0>
<tr>

<?php if ($login == "admin") { ?>
<td>
<a class=menuA href='users.php'><div class=menuDiv>USERS</div></a>
</td>
<td>
<a class=menuA href='servers.php'><div class=menuDiv>SERVERS</div></a>
</td>
<?php } ?>

<td>
<a class=menuA href='index.php?logout'><div class=menuDiv>LOGOUT</div></a>
</td>

</tr></table>

</td></tr></table>

</div>
<?php } ?>