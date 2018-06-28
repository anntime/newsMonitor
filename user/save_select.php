<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<form name="form1" method="post" action="">
<table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
<?php
	
	
require "../include/common.inc.php";
$db = getdb();
if(!empty ($_COOKIE['username'])){
$username = $_COOKIE['username'];
$passcode = $_COOKIE['password'];
$judge_login = login_user($db,$username,$passcode);
if ($judge_login == 1) {
get_post();
$user_num = get_usernum($db,$username);
insert_sql($db,$get_choose,$get_remind,$user_num,$get_user_key);
}
}
else alert("请先登录！","index.php");

function get_post(){
	/*用于接收用户选择订阅的板块的内容
	$get_choose用于接收订阅的板块
	$get_remind用于接收提醒方式
	$get_user_key用于接收关键字
	*/
	global $get_choose;
	global $get_remind;
	global $get_user_key;
	if(empty($_POST['get_subsite_name']))  alert ("您没有选择订阅，点击确定返回选择界面","user_select.php");
	else{
	   $get_choose = $_POST['get_subsite_name'];
	   $get_remind = $_POST['remind'];
	   $get_user_key = $_POST['user_key']; 
	}
}
function get_usernum($db,$username){
	$sql = "SELECT * FROM user WHERE user_name="."\"$username\"";
    $result = $db->query($sql);
    $row = $result->fetch_array();
    $user_num = $row["user_num"];
    return $user_num;
}
function judge_insert($db,$user_num,$site_id,$remind,$user_key){
	//判断数据库中是否有相同记录，如果有相同的记录返回值为1，否则返回值为0
	$sql = "SELECT * FROM user_site WHERE user_num = $user_num AND site_id = $site_id";
	$result = $db->query($sql);
	while ($row=$result->fetch_array()){
		$sql_user_num = $row["user_num"];
	    $sql_site_id = $row["site_id"];
	    $sql_remind = $row["remind"];
	    $sql_user_key = $row["user_key"];
	    $sql_isDelete = $row["isDelete"];
	    $cmp = (($user_num==$sql_user_num)&&($site_id==$sql_site_id)&&($remind==$sql_remind)&&($user_key == $sql_user_key));
	    echo $cmp;
	    $user_key ='';
	    if (($cmp ==1)&&($sql_isDelete == 1)){ 
	    $sql_up = "UPDATE user_site SET isDelete = 0 WHERE user_num = $user_num AND site_id = $site_id AND remind = $remind AND user_key = "."\"$user_key\"";
	    //echo $sql_up;
	    $db->query($sql_up);
	    return 1;}
	    else if($cmp ==1){
	    return 1;
	    }
	    else continue;
	   	}
	   	return 0;
}
function simple_remind($db,$user_num,$site_id,$remind,$user_key){
    $sql = "SELECT * FROM user_site WHERE user_num = $user_num AND site_id = $site_id";
    $result = $db->query($sql);
    //如果result为空的话，返回0
    if($result !=null){
    while ($row = $result ->fetch_array()){
    $user_site_remind = $row["remind"];
    $isdelete = $row["isDelete"];
    if (($remind == 2)&&(($user_site_remind ==1)||($user_site_remind ==0))){
        update_remind($db,$user_num,$site_id,$remind,$user_key,$isdelete);
        return 1;
       }
     elseif ((($remind == 0)||($remind == 1))&&($user_site_remind == 2)){
     update_remind($db,$user_num,$site_id,$remind,$user_key,$isdelete);
     return 1;
     }
     elseif((($remind ==1)||($remind == 0))&&(($user_site_remind == 1)||($user_site_remind == 0))){
     update_remind($db,$user_num,$site_id,$remind,$user_key,$isdelete); 
     return 1;
     }
     else return 0;
    }
  }
  else return 0;
}
function update_remind($db,$user_num,$site_id,$remind,$user_key,$isdelete){
     if($isdelete == 0) $sql = "UPDATE user_site SET remind = 2 ,user_key = \"$user_key\" WHERE user_num = $user_num AND site_id = $site_id";
     else $sql = "UPDATE user_site SET remind = $remind ,user_key = \"$user_key\" ,isDelete = 0 WHERE user_num = $user_num AND site_id = $site_id";
     $db ->query($sql);
}
function get_remind_num($db,$tmp){
  if ($tmp!=null){
  $sql_getcategory = "SELECT * FROM site WHERE site_id = $tmp";
  $result = $db->query($sql_getcategory);
  $row = $result->fetch_Array();
  $site_category = $row["site_category"];
  $sql_getsite = "SELECT * FROM site WHERE site_category = '$site_category'AND isDelete = 0";
  $result_site = $db->query($sql_getsite);
  $category_site = array();
  for($i=0;$row = $result_site->fetch_Array();$i++){
  $category_site[$i] = $row["site_id"];
  }
  $num = array_search($tmp,$category_site);
  //echo $num;
  return $num;
  }


}
function insert_sql($db,$get_choose,$get_remind,$user_num,$user_key){
        //$choose_count 用来存放$get_choose的长度
        $choose_count = count ($get_choose);
        for($i = 0;$i<$choose_count;$i++){
        	//$tmp用来存放$get_choose里面的数据.用以获取$get_remind和$user_num里面的值
        	//print_r ($get_choose);
        	$tmp = $get_choose[$i];
        	$num = get_remind_num($db,$tmp);
        
        	//print_r($get_remind);
        
            $remind = $get_remind[$num];
            $user_mykey =urlencode($user_key[$num]);
            //判断数据库中是否有相同记录!
            $judge_sql = judge_insert($db,$user_num,$tmp,$remind,$user_mykey);
            //echo $judge_sql;
            if($judge_sql == 1)  continue;
            else{
            $judge_remind=simple_remind($db,$user_num,$tmp,$remind,$user_mykey);
            if($judge_remind == 0) {
            //echo $user_mykey;
            $sql= "INSERT INTO user_site (`user_num`, `site_id`, `remind`, `user_key`, `isDelete`) VALUES ($user_num,$tmp,$remind,"."\"$user_mykey\"".",0)";
            //echo $sql;
            $db->query($sql);
            }
            else continue;
        }
        }
     alert ("您所选择的网站已经成功添加关注！","user_main.php");
}
?>
</form>
</body>
</html>