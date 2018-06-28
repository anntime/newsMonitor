<!DOCTYPE HTML>
<html>
  <head>
   <meta http-equiv="Content-Language" content="zh-cn">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
       a:link,a:visited{text-decoration:none;  /*超链接无下划线*/}
       a:hover{text-decoration:underline;  /*鼠标放上去有下划线*/}
    </style>
  </head>
  <body>
    <?php
      require "../include/common.inc.php";	
        //获取用户输入
      $managername = $_POST['managername'];
      $passcode = $_POST['passcode'];
        if(empty($_POST['cookie'])) {
            $cookie = 0;
            setcookie("managername",$managername);
            setcookie("password", $passcode);
          }
        else{
            $cookie = $_POST['cookie'];
              //保存30天
            setcookie("managername",$managername,time()+30*24*60*60);
            setcookie("password", $passcode, time()+30*24*60*60);
          }
        //执行SQL语句，判断用户是否存在
      $db = getdb();
      $sql = "SELECT * FROM manager WHERE manager_name = '".$managername."' AND manager_passwd ='".$passcode."'";
      $result = $db->query($sql);;
        if($row = $result->fetch_array())
          {
	         echo "<h1 align=\"center\">欢迎光临</h1>";
              echo"<div align=\"center\">";
               echo"<table width=\"617\" height=\"70\" border=\"0\">";
                echo"<tr>";
                 echo"<td width=\"200\"><div align=\"center\"><strong><a href=\"./manage_user.htm\">管理用户密码</a></strong></div></td>";
                 echo"<td width=\"300\"><div align=\"center\"><strong><a href=\"./enter_site.php\">录入网站信息</a></strong>";
                 echo"<td width=\"300\"><div align=\"center\"><strong><a href=\"./delete_site.php\">删除网站信息</a></strong>";
                echo"</tr>";
               echo"</table>";
             echo"</div>";
	            //自动跳转到user_admin.php
		   header("location: manager_admin.php");				
         }
          else
           {  
             alert("用户名或密码错误","manager_login.htm");
	       }
?>
</body>
</html>