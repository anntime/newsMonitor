<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
<title>用户密码管理</title>
</head>
<h2 align="center"> 用户密码管理 </h2>
<body>
<?php
	require "../include/common.inc.php";
	$db = getdb();
    $username = $_COOKIE['managername'];
    $passcode = $_COOKIE['password'];
    $judge_login = login_manager($db,$username,$passcode);
     if ($judge_login == 1){
echo"<form name=\"form1\" method=\"get\"  action=\"manage_user_jump.php\">
  <table width=\"300\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
    <tr>
      <td width=\"150\"><div align=\"right\">用户名：</div></td>
      <td width=\"150\"><input type=\"text\" name=\"username\" id=\"SiteName\"></td>
    </tr>
    <tr>
      <td width=\"150\"><div align=\"right\">         </div></td>
      <td width=\"150\">不能为空。。</td>
    </tr>
    <tr>
      <td><div align=\"right\">电话号码：</div></td>
      <td><input type=\"text\" name=\"usertel\" id=\"SubSiteName\"></td>
    </tr>
    <tr>
      <td><div align=\"right\">邮箱：</div></td>
      <td><input type=\"text\" name=\"email\" id=\"SubSiteName\"></td>
    </tr>
  </table>
  <p align=\"center\">
    <input type=\"submit\" name=\"Submit\" value=\"提交\">
    <input type=\"reset\" name=\"Reset\" value=\"重置\">";
    }else{
        alert("请先登录！","manager_login.htm");
    }
?>
</body>
</html>
