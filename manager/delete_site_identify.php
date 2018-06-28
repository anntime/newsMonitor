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
  $Dele=$_POST['delete'];
    //根据管理员的选择设置删除信息
		switch($Dele)								
		{
			 //按照siteid来删除
			case 0:								
			    $siteID=$_POST['siteid'];
			   if($siteID==null){
			   	   aler("输入信息不能为空！");
			   }else{
			    $judg_sql="SELECT  `site_id` FROM  `site` WHERE `site_id`='".$siteID."'and `isDelete`=0;";
			    $judgResult=$db->query($judg_sql)or die($db->error);
                 if($judgResult->fetch_Array()==null)
                   {
                   	  aler("输入信息不存在");
                   }else{
                   	   $sql="update site set isDelete=1 where `site_id`=".$siteID;
                   	   $db->query($sql)or die($db->error);
                       aler("网站信息删除成功！");
                   }
 		   	}
 		   		break;
			 //按照site_name来删除
			case 1:								
				$sitename=$_POST['sitename'];
		         //将表单中的内容进行url编码
                $sitename=myEncode($sitename);
			    if($sitename==null){
			   	   aler("输入信息不能为空！");
			   }else{
			    $judg_sql="SELECT  `site_name` FROM  `site` WHERE `site_name`='".$sitename."'and `isDelete`=0;";
			    $judgResult=$db->query($judg_sql)or die($db->error);
                 if($judgResult->fetch_Array()==null)
                   {
                   	  aler("输入信息不存在");
                   }else{
                   	   $sql="update site set isDelete=1 WHERE`site_name`=".$sitename;
                   	   $db->query($sql)or die($db->error);
                       aler("网站信息删除成功！");
                   }
 		   	}
				break;
		     //按照sub_sitename来删除
			case 2:								
				$subsitename=$_POST['subsitename'];
			     //将表单中的内容进行url编码
			    $subsitename=myEncode($subsitename);
				if($subsitename==null){
			   	   aler("输入信息不能为空！");
			   }else{
			    $judg_sql="SELECT  `subsite_name` FROM  `site` WHERE `subsite_name`='".$subsitename."'and `isDelete`=0;";
			    $judgResult=$db->query($judg_sql)or die($db->error);
                 if($judgResult->fetch_Array()==null)
                   {
                   	  aler("输入信息不存在");
                   }else{
                   	   $sql="update site set isDelete=1 where subsite_name`=".$subsitename;
                   	   $db->query($sql)or die($db->error);
                       aler("网站信息删除成功！");
                   }
 		   	}
				break;
		    //按照url来删除
			case 3:								
				$url=$_POST['url'];
				if($url==null){
			   	   aler("输入信息不能为空！");
			   }else{
			    $judg_sql="SELECT  `url` FROM  `site` WHERE `url`='".$url."'and `isDelete`=0;";
			    $judgResult=$db->query($judg_sql)or die($db->error);
                 if($judgResult->fetch_Array()==null)
                   {
                   	  aler("输入信息不存在");
                   }else{
                   	   $sql="update site set isDelete=1 where url=".$url;
                   	   $db->query($sql)or die($db->error);
                       aler("网站信息删除成功！");
                   }
 		   	}
				break;
		}
    echo"<strong><a href=\"..\manager\delete_site.php\">返回继续删除网站信息</br></br></br></a></strong>";
    echo"<strong><a href=\"..\manager\manager_admin.php\">返回管理员主界面</a></strong>";
?>

</body>
</html>
