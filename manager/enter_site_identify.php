<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<?php
  require "../include/common.inc.php";	
   //连接数据库
  $db = getdb(); 
   //获取用户输入
  $sitename=$_POST['sitename'];
  $subsitename=$_POST['subsitename'];
  $url=$_POST['url'];
  $sitetag=$_POST['sitetag'];
   //将表单中的内容进行url编码
  $sitename=myEncode($sitename);
  $subsitename=myEncode($subsitename);
      //判断记录是否存在
    $judg_sql="SELECT  `url` FROM  `site` WHERE `url`='".$url."'and `isDelete`=0;";
    $judgResult=$db->query($judg_sql)or die($db->error);
    if($judgResult->fetch_Array()==null&&$sitename!=null)
    {
        //生成数据库插入语句
	  $sql="INSERT INTO  `news_monitor`.`site` (`site_id` ,`site_name` ,`subsite_name` ,`url` ,`site_description` ,"."
         `isDelete`)VALUES (NULL ,  '".$sitename."',  '".$subsitename."',  '".$url.
         "','".$sitetag."','0');";
      $db->query($sql)or die($db->error);
      aler("网站信息录入成功！");
    }else{
    	aler("网站信息已存在，请录入其他网站！");
    }
    echo"<strong><a href=\"..\manager\enter_site.php\">返回继续输入信息</br></br></br></a></strong>";
    echo"<strong><a href=\"..\manager\manager_admin.php\">返回管理员主界面</a></strong>";
?>

</body>
</html>
