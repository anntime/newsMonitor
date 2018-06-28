<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
require "../include/PHPFetion.php";
	function send_Remindtel($user_name,$user_tel,$update_title,$update_url,$site_name){
	$myfetion = "18854735458";
	$mypasswd = "aa428571";
	$fetion = new PHPFetion($myfetion,$mypasswd);
	$p0 = "<p>"."您好,您关注的页面"."<b>".$site_name."</b>"."有新信息:"."</p>";
    $p1 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;".$update_title."</p>";
    $p2 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;"."<a href=".$update_url.">"."详情请点击"."</a>";
	$send_content =$p0.$p1.$p2;
	//$send_content = "您好："."您所关注的网站有更新：".$update_title."URL为：".$update_url;
	echo $send_content;
    //$send_content = iconv("gbk","utf-8",$send_content);
	$fetion->send($user_tel,$send_content);
	}
    function test_email(){
    $user_name="xqnssa";
    $user_tel="18854735458";
    $update_title="这是一封测试邮件";
    $update_url="http://xqnssa.blog.163.com";
    $site_name = "济宁学院AIlab";
    send_Remindtel($user_name,$user_tel,$update_title,$update_url,$site_name);        
}
test_email();
	
	
?>
</body>
</html>	