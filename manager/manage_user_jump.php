<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>重置用户密码</title>
</head>

<body>
<?php
  include("../include/common.inc.php");
    //设置http页面编码
  header("Content-type: text/html; charset=utf-8");
  $userName=$_GET['username'];
  $userTel=$_GET['usertel'];
  $Email=$_GET['email'];
   //连接数据库
  $db=getdb();
   //查询该用户是否存在
  $sql="SELECT `user_passwd` FROM `user` WHERE `user_name`= \"".$userName."\"";
 // echo $sql;
  $oriPW=$db->query($sql)or die  (mysqli_connect_error());
   
   if($oriPW->fetch_Array()==null)
   {
     alert("请重新输入用户名","manage_user.php");
   }else{
     $newPW=domake_password("6");
     $db->query("update user set user_passwd =\"".$newPW."\" where user_name=\"".$userName."\"")or die  (mysqli_connect_error());
     echo "您的新密码是：".$newPW." 请妥善保管</br></br>" ;
   
   }
   echo"<strong><a href=\"..\manager\manage_user.php\">返回继续修改信息，重置密码</br></br></br></a></strong>";
   echo"<strong><a href=\"..\manager\manager_admin.php\">返回管理员主界面</a></strong>";


?>
</body>
</html>
