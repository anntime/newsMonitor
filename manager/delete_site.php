﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<title>录入网站信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<h2 align="center"> 删除网站信息 </h2>
<p align="center">（只需要在你选择的信息处填写！）</p>
<body>
 <?php
	require "../include/common.inc.php";
	$db = getdb();
    $username = $_COOKIE['managername'];
    $passcode = $_COOKIE['password'];
    $judge_login = login_manager($db,$username,$passcode);
     if ($judge_login == 1){
    echo"<form name=\"form1\" method=\"post\"  action=\"delete_site_identify.php\">
          <table width=\"300\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\">
           <tr>
            <td><div align=\"right\">删除信息选择：</div></td>
             <td><select name=\"delete\" id=\"Dele\">
				    <option value=\"0\" selected>SiteID</option>
				    <option value=\"1\">SiteName</option>
				    <option value=\"2\">SubSiteName</option>
				    <option value=\"3\">URL</option>
				  </select></td>
           </tr>
           <tr>
            <td width=\"150\"><div align=\"right\">SiteID：</div></td>
            <td width=\"150\"><input type=\"text\" name=\"siteid\" id=\"SiteID\"></td>
           </tr>
           <tr>
            <td width=\"150\"><div align=\"right\">SiteName：</div></td>
            <td width=\"150\"><input type=\"text\" name=\"sitename\" id=\"SiteName\"></td>
           </tr>
           <tr>
            <td width=\"150\"><div align=\"right\">          </div></td>
            <td width=\"150\">eg：济宁学院</td>
           </tr>
           <tr>
            <td><div align=\"right\">SubSiteName：</div></td>
            <td><input type=\"text\" name=\"subsitename\" id=\"SubSiteName\"></td>
           </tr>
           <tr>
            <td><div align=\"right\">           </div></td>
            <td width=\"200\">eg:济宁学院人事信息网</td>
           </tr>
           <tr>
            <td><div align=\"right\">URL：</div></td>
            <td><input type=\"text\" name=\"url\" id=\"URL\"></td>
           </tr>
          </table>
          <p align=\"center\">
           <input type=\"submit\" name=\"Submit\" value=\"提交\">
           <input type=\"reset\" name=\"Reset\" value=\"重置\">
          </p>
        </form>";
     }else{
        alert("请先登录！","manager_login.htm");
     }
     ?>
</body>
</html>
