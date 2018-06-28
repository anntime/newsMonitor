<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>

<?php
//用户注册以后的数据处理文件。需要先检查数据合法性，然后写入数据库
//获取注册用户提交的数据
$UserName1=urlencode($_POST["UserName"]);//用户名
$Password1=$_POST["Password"];//密码
$ConfirmPassword1=$_POST["ConfirmPassword"];//确认密码
$Email1=$_POST["Email"];//邮箱
$user_tel=$_POST["telnum"];
//导入数据库文件
include '../include/common.inc.php';
include '../include/PHPFetion.php';
//定义产生激活码函数
/*
function Check_actnum()
{
$chars_for_actnum=array("A","B","C","D","E","F","G","H","I","J","K","L",
"M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d",
"e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v",
"w","x","y","z","1","2","3","4","5","6","7","8","9","0"
);

for ($i=1;$i<=20;$i++)//生成一个20个字符的激活码
{
 $actnum.=$chars_for_actnum[mt_rand(0,count($chars_for_actnum)-1)];
}
return $actnum;
}
*/
//判断用户名函数
function Check_username($UserName)//参数为用户注册的用户名
{
 //用户名三个方面检查
 //是否为空   字符串检测   长度检测
 $Max_Strlen_UserName=16;//用户名最大长度
 $Min_Strlen_UserName=4;//用户名最短长度
 $UserNameChars="^[A-Za-z0-9_-]";//字符串检测的正则表达式
 $UserNameGood="用户名检测正确";//定义返回的字符串变量
 if($UserName=="")
 {
  $UserNameGood="用户名不能为空";
  return $UserNameGood;
 }
 if(fnmatch("$UserNameChars",$UserName))//正则表达式匹配检查
 {
  $UserNameGood="用户名字符串检测不正确";
  return $UserNameGood;
 }
 if (strlen($UserName)<$Min_Strlen_UserName || strlen($UserName)>$Max_Strlen_UserName)
 {
  $UserNameGood="用户名字长度检测不正确";
  return $UserNameGood;
 }
 return $UserNameGood;
}
//判断密码是否合法函数
function Check_Password($Password)
{
 //是否为空    字符串检测      长度检测
 $Max_Strlen_Password=16;//密码最大长度
 $Min_Strlen_Password=6;//密码最短长度
 $PasswordChars="^[A-Za-z0-9_-]";//密码字符串检测正则表达式
 $PasswordGood="密码检测正确";//定义返回的字符串变量
 if($Password=="")
 {
  $PasswordGood="密码不能为空";
  return $PasswordGood;
 }
 if(fnmatch("$PasswordChars",$Password))
 {
  $PasswordGood="密码字符串检测不正确";
  return $PasswordGood;
 }
 if(strlen($Password)<$Min_Strlen_Password || strlen($Password)>$Max_Strlen_Password)
 {
  $PasswordGood="密码长度检测不正确";
  return $PasswordGood;
 }
 return $PasswordGood;
}
//判断邮箱是否合法函数
function Check_Email($Email)
{
 $EmailChars="^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$";//正则表达式判断是否是合法邮箱地址
 $EmailGood="邮箱检测正确";
 if($Email=="")
 {
  $EmailGood="邮箱不能为空";
  return $EmailGood;
 }
 if(fnmatch("$EmailChars",$Email))//正则表达式匹配检查
 {
  $EmailGood="邮箱格式不正确";
  return $EmailGood;
 }
 return $EmailGood;
}
//判断两次密码输入是否一致
function Check_ConfirmPassword($Password,$ConfirmPassword)
{
 $ConfirmPasswordGood="两次密码输入一致";
 if($Password<>$ConfirmPassword)
 {
  $ConfirmPasswordGood="两次密码输入不一致";
  return $ConfirmPasswordGood;
 }
 else
 return $ConfirmPasswordGood;
}
//调用函数，检测用户输入的数据
$UserNameGood=Check_username($UserName1);
$PasswordGood=Check_Password($Password1);
$EmailGood=Check_Email($Email1);
$ConfirmPasswordGood=Check_ConfirmPassword($Password1,$ConfirmPassword1);
$error=false;//定义变量判断注册数据是否出现错误
if($UserNameGood !="用户名检测正确")
{
  $error=true;//改变error的值表示出现了错误
 //echo $UserNameGood;//输出错误信息
}
if($PasswordGood !="密码检测正确")
{
 $error=true;
 //echo $PasswordGood;
}
if($EmailGood !="邮箱检测正确")
{
 $error=true;
 //echo $EmailGood;
}
if ($ConfirmPasswordGood !="两次密码输入一致")
{
 $error=true;
 echo $ConfirmPasswordGood;
 echo "<br>";
}
//判断数据库中用户名和email是否已经存在
$db=getdb();
$query="select * from user where user_name='$UserName1' or user_email='$Email1'";
$result=$db->query($query);
$error1=$error2= false;
while($row = $result->fetch_Array())
{
 if ($row["user_name"]==$UserName1)
 {
  $error1=true;
  alert ("用户名已存在","index.php#toregister");
 }
 if ($row["user_email"]==$Email1)
 {
  $error2=true;
  alert  ("用户邮箱已经注册","index.php#toregister");
 }
}
//如果数据检测都合法，则将用户资料写进数据库表
if (($error1==false)&&($error2==false)&&($error==false))//$error1=$error2=false表示没有错误
{
 //如数据库之前,将所有字符串格式的全部转换成为utf-8的格式
 $UserName1=urlencode(urldecode($UserName1));
 $Password1=urlencode(urldecode($Password1));
 $db=getdb();
 $user_passwd=md5($Password1);
 $query="insert into user (user_name,user_passwd,user_email,user_tel,user_group) values ('$UserName1','$user_passwd','$Email1','$user_tel','jnxy')";
 $result=$db->query($query);
 $ret = add_fetion_friend($user_tel);
 if ($ret==null) alert("注册成功!","index.php");
 else{
 	 $rett = "注册成功!".$ret;
 	 alert($rett,"index.php");
 	 }
}
function add_fetion_friend($user_tel){
  $yd_num = array(134,135,136,137,138,139,150,151,157,158,159,187,188,152);
  $judge_num = substr($user_tel,0,3);
  for ($i = 0;$i< count($yd_num);$i++){
  if($yd_num[$i]==$judge_num) {
  $fetion = new PHPFetion('15863715401', 'ailab302');
  $fetion->addfriend($user_tel);
  $status = "经检测您的手机号为移动用户，为了短信接收订阅请您回复是!";
  return $status;
  }
  else continue;
  }
}
?>
</body>
</html>