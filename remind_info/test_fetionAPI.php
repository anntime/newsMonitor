<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
/****************************************
被测试的对象为接口是搭建在SinaAppEngine上
的，SAE的服务还算是比较牢靠的。
****************************************/
include("../include/PHPFetion.php");
$destation = 18854735458;
$message = "tttt";
$update_title = "这是调用飞信API端口的测试！";
$update_url = "http://xqnssa.blog.163.com/";
$site_name = "AIlab的部落格";
$message = "您好："."您所关注"."\"$site_name\""."网站有更新：".$update_title."URL为：".$update_url;
$send = "http://quanapi.sinaapp.com/fetion.php?u=18854735458&p=aa428571&to=".$destation."&m=".$message;
echo $send."<br>";
$ret = file_get_contents($send);
$retArray = json_decode($ret, true);
print_r($retArray);
$test = $retArray["result"];
echo $test;
if ($test !=0){
$alarm = "警告：飞信API出现问题，请及时修复！~";
$user_tel = 18854735458;
$fetion = new PHPFetion($user_tel, 'aa428571');
$fetion->send($user_tel,$alarm);
echo "ok";
}
?>
</body>
</html>