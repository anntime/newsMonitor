<?php
/**
 * @author MR.Xiao
 * @copyright 2013
 使用方法：
 在主调php文件中得先引入  common.inc.php   class.phpmailer.php   PHPFetion.php   remind.inc.php 个文件
*/
include("class.textExtract.php");
include("PHPFetion.php");
include("class.phpmailer.php");
include("common.inc.php");
global $news_content;
 function remind_main($db){
 	//这是提醒模块的主函数！
	//找到send为0的记录
    $sql="SELECT * FROM news_update WHERE send = '0' AND isDelete =0";
    $result = $db->query($sql);
    //对每条记录进行操作，操作的内容在两个while里面
    //第一个while是用来获取$site_id;$update_titel;
    while ($row=$result->fetch_Array()){
    	$site_id = $row["site_id"];
        $update_url = $row["update_url"];
        $update_title = $row["update_title"];
        $news_content = $row["news_content"];
        //将$update_title 进行url解码
        $update_title = urldecode($update_title);
        $news_content = urldecode($news_content);
        $match_content = $update_title.$news_content;
/*******************************************************************************************
*             增加正文推送功能，定义一个$news_content的变量，用来存放返回的新闻正文的内容       *
*               备注：目前已经将此功能转移至sphider.inc.php文件内了                           *
*                                               时间：2013年4月7日                           *
*                                           转移时间：2013年4月29日				    		*
* 												Copyright Mr.Xiao                           *
********************************************************************************************/
/*
    	$iTextExtractor = new textExtract($update_url);
		$news_content = $iTextExtractor->getPlainText();
		if( $iTextExtractor->isGB ) $news_content = iconv( 'GBK', 'UTF-8//IGNORE', $news_content);
        //echo $update_title.":".$update_url."<br>";
        //通过sql获取用户信息。
*/
        $user_info = get_user_info($db,$site_id);
        while ($row = $user_info->fetch_Array()){
        	/*
            一条新闻的记录，对应所有的用户进行遍历
            1、获取用户信息，给各种不同的变量名
            2、对比$user_key如果关键字不为空的话，就将$update_title跟$user_key进行对比，如果存在的话，就调用选择提醒模块（choose remind）
            3、如果关键字为空的话，直接调用选择提醒模块（choose remind）
            */
            $site_name = get_sitename($db,$site_id);
            $user_name = $row["user_name"];
            $user_email = $row["user_email"];
            $user_tel= (string)$row["user_tel"];
            $user_key = urldecode($row["user_key"]);
            $user_remind = $row["remind"];
            /*****************************************************************************
            2013-04-23增加多个关键字匹配功能.
            *****************************************************************************/
            if ($user_key!=null){
            //echo $user_key."<br>";
            $user_key_temp = explode(" ",$user_key);
            //print_r ($user_key_temp);
            $j=0;
            for($i=0;$i<count($user_key_temp);$i++){
            //echo "i:".$user_key_temp[$i]."<br>";
            if(strpos($match_content,$user_key_temp[$i])!==false) $j++;
            }
            //echo "This is".$j."<br>";
            if($j>0) choose_remind($user_name,$user_email,$user_tel,$update_title,$update_url,$user_remind,$site_name,$news_content);
            else continue;
            }
            else if($user_key == null) choose_remind($user_name,$user_email,$user_tel,$update_title,$update_url,$user_remind,$site_name,$news_content);
            else continue;
        }
         send_feition(urlencode($update_title));
         update_table($db,$site_id);
    }
}
function judge_china_mobile($user_tel){
  $yd_num = array(134,135,136,137,138,139,150,151,157,158,159,187,188,152);
  $judge_num = substr($user_tel,0,3);
  for ($i = 0;$i< count($yd_num);$i++){
  if($yd_num[$i]==$judge_num) return 1;
  else continue;
  }
  return 0;
}
function get_user_info($db,$site_id){
	//获取用户的信息，将user_site和user表进行连接，返回符合site_id的记录
        $sql = "SELECT * FROM user_site LEFT JOIN user ON user_site.user_num = user.user_num WHERE user_site.site_id =$site_id AND user_site.isDelete = 0 AND user.isDelete = 0";
        $user_info = $db->query($sql);
        return $user_info;
}
function update_table($db,$site_id){
	//提醒完成的话，将news_update表的send标志位置1
        $sql = "UPDATE `news_update` SET `send`=1 WHERE site_id = $site_id";
        $db = $db->query($sql);
}   
function choose_remind($user_name,$user_email,$user_tel,$update_title,$update_url,$user_remind,$site_name,$news_content){
	//根据传递过来的$user_remind,进行提醒方式的对比
	//$user_remind == 0   调用邮件模块
	//$user_remind == 1   调用飞信模块
	//$user_remind == 2   调用飞信和邮件模块
	//echo $user_remind;
        if($user_remind == 0){
        $is_send=send_RemindEmail($user_name,$user_email,$update_title,$update_url,$site_name,$news_content);
		emailIntoDB($user_name,$user_email,$update_title,$is_send);
		
        //echo "调用发送邮件模块"."<br>";
        }
        else if($user_remind ==1) {
        save_feition($user_name,$user_tel,$update_title,$update_url,$site_name);
        //echo "调用飞信模块<br>"; 
        }
        else if($user_remind ==2) {
        //echo "首先调用邮件模块<br>";
        send_RemindEmail($user_name,$user_email,$update_title,$update_url,$site_name,$news_content);
        //echo "其次调用飞信模块<br>"; 
        save_feition($user_name,$user_tel,$update_title,$update_url,$site_name);
        }
        else return;
}

function get_sitename($db,$update_site_id){
            $sql_site="SELECT * FROM site WHERE isDelete = 0 AND site_id = $update_site_id";
            $result_site = $db ->query($sql_site);
            while ($row = $result_site->fetch_array()){
            $site_id = $row["site_id"];
            if($update_site_id == $site_id) {
            $site_name = urldecode($row["subsite_name"]);
            break;
            }
            else continue;
            }
            return $site_name;
}
	/*
function send_remindtel($user_name,$user_tel,$update_title,$update_url,$site_name){  
		//myfetion和mypasswd用来设置飞信的用户名和密码

    	$send = "http://quanapi.sinaapp.com/fetion.php?u=18854735458&p=aa428571&to=".$user_tel."&m=".$message;
    	$ret = file_get_contents($send);
        $retArray = json_decode($ret, true);
        //print_r($retArray);
        $judge_send = $retArray["result"];
        //echo $test;
        if ($is_send!=0){
        $myfetion = "18854735458";
	    $mypasswd = "aa428571";
        $alarm = "警告：飞信API，调用出现问题，请及时修复！";
        $fetion = new PHPFetion($myfetion,$mypasswd);
        $fetion->send($myfetion,$alarm);
        
        }

    	//echo $user_name."&&&".$send_content;
        //$send_content = iconv("gbk","utf-8",$send_content);
	    //$fetion->send($user_tel,$send_content);
	    }
	    else return;
	}
	        */
/*******************************************************************************************
*             增加飞信入库功能，将所要发送的飞信入库，输入为$user_name  $user_tel           *
*             $fetion_content(所要发送的内容)                                               *
*                                               时间：2013年4月3日                          *
*                                               Copyright Mr.Xiao                           *
********************************************************************************************/
function save_feition($user_name,$user_tel,$update_title,$update_url,$site_name){
	    $db = getdb();
	    $judge_tel = judge_china_mobile($user_tel);
		//echo $judge_tel."这是judge_tel返回的值！！！";
		if(($user_tel!=null)&&($judge_tel!=0)) 
	    //$fetion = new PHPFetion($myfetion,$mypasswd);
    	$message = "您好："."您所关注"."\"$site_name\""."网站有更新：".$update_title."URL为：".$update_url;
    	else return;
        $fetion_content = urlencode($message);
        $sql_same = "SELECT * FROM  `fetion_temp` WHERE  `user_tel` =  '$user_tel' AND  `feition_content` = '$fetion_content'";
        //echo $sql_same."<br>";
        $result_same = $db->query($sql_same);
        //echo "OOOO<br>".mysql_num_rows($result_same)."YYYY<br>";
        $row = $result_same->fetch_array();
        if (!$row){
        $sql = "REPLACE INTO  `news_monitor`.`fetion_temp`(`user_name`,`user_tel` ,`feition_content` ,`is_send`) VALUES ('$user_name',  '$user_tel',  '$fetion_content',  '0');";
        $db ->query($sql);}
        else return;
}
/*******************************************************************************************
*             从数据库中调取飞信信息，通过群发的方式赋值给$feition_all,每组不超过10个       *
*                                                                                           *
*                                               时间：2013年4月3日                          *
*                                               Copyright Mr.Xiao                           *
********************************************************************************************/
function send_feition($update_title){
        $db = getdb();
        $feition_tel=array();
        $sql = "SELECT DISTINCT user_tel,feition_content FROM `fetion_temp` WHERE is_send = 0 AND `feition_content` LIKE '%$update_title%';";
        //echo $sql;
        $result = $db ->query($sql);
        if ($result){
        for ($i=0;$row =$result->fetch_array();$i++){
        $feition_tel[$i] = $row["user_tel"];
        $message = $row["feition_content"];
        }
        $feition_count = count($feition_tel);
        //echo "TTTT".$feition_count."RRRR<br>";
        for ($j=0;$j<=$feition_count/10;$j++){
        //echo "RRRR".$j."TTTT<br>";
        $feition_all = "";
        for ($i=0;($i<10)&&(($j*10+$i))<$feition_count;$i++){
        $feition_all = $feition_all.$feition_tel[$j*10+$i].",";
        }
        $feition_all = substr($feition_all,0,-1);
        //调用飞信模块
        if(!empty($feition_all))
        {
        $send = "http://quanapi.sinaapp.com/fetion.php?u=15863715401&p=ailab302&to=".$feition_all."&m=".$message;
      	$ret = file_get_contents($send);
        $retArray = json_decode($ret, true);
        $judge_send = $retArray["result"];
        if($judge_send ==0) 
        update_fetion_send($db,$feition_all,$message);
        else {
        $myfetion = "18854735458";
	    $mypasswd = "aa428571";
        $alarm = "警告：飞信API，调用出现问题，请及时修复！错误代码为".$judge_send;
        $fetion = new PHPFetion($myfetion,$mypasswd);
        $fetion->send($myfetion,$alarm);
        }
        }
   }
  }
}
/*******************************************************************************************
*             从数据库中调取飞信信息，发送成功以后将发送时间和发送标志位进行更新            *
*                                                                                           *
*                                               时间：2013年4月3日                          *
*                                               Copyright Mr.Xiao                           *
********************************************************************************************/

function update_fetion_send($db,$feition_all,$fetion_content){
	    $user_tel_temp = explode(",",$feition_all);
	    foreach($user_tel_temp as $key=>$value){
	    $user_tel=$value;
	    date_default_timezone_set('PRC');    
	    $send_date = date('Y-m-d   H:i:s');
	    $sql = "UPDATE `fetion_temp` SET `send_time`='$send_date',`is_send`=1 WHERE user_tel = '$user_tel' AND feition_content = '$fetion_content'";
        //echo $sql;
        $db->query($sql);
	    }
        return;
}
function send_RemindEmail($user_name,$user_email,$update_title,$update_url,$site_name,$news_content){
        $mail  = new PHPMailer();  
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64"; 
      
        $mail->IsSMTP();  
        $mail->SMTPAuth   = true;               // 指定使用smtp协议发送 
        //$mail->SMTPSecure = "ssl";            // 不开启SSL支持  
        $mail->Host       = "smtp.163.com";      // 选择您的发件人的smtp服务器 
        $mail->Port       = 25;                 // 服务器的端口号，一般为25    
    
        // 发件人的邮箱名 和 发件人邮箱密码 
        $mail->Username   = "xqnssa@163.com";
        $mail->Password   = "110120";
    
        $mail->From = "xqnssa@163.com";     //
        $mail->FromName = "AILAB";  
        $subject="新闻提醒".":".$site_name."---".$update_title; 
        //加上?utf-8?B?".base64_encode($subject)."?="这句话主要是解决邮件标题的乱码错误！
        $mail->Subject="=?utf-8?B?".base64_encode($subject)."?=";
        $mail->WordWrap   = 250; // set word wrap  
        //发送内容由所关注的网站，新闻标题，新闻URL构成。
        $p0 = "<p>"."您好,您关注的页面"."<b>".$site_name."</b>"."有新信息:"."</p>";
        $p1 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"#FF0000\">目前使用的正文推送功能正在测试阶段，不能保证其准确性，还以网站正文为准！</font></p>";
        $p2 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;".$update_title."</p>";
        $p3 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;".$news_content."</p>";
        $p4 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;"."<a href=".$update_url.">"."详情请点击"."</a>";
        $email_conetent=$p0.$p1.$p2.$p3.$p4;
        //echo $subject.":::".$email_conetent."<br>";
        $mail->Body=$email_conetent;  

        $mail->AddAddress("$user_email","$user_name");
        $mail->IsHTML(true); // send as HTML  
        if(!$mail->Send()) { echo "Mailer Error: " . $mail->ErrorInfo; return 0;} 
        else {echo "Message has been sent.<br>";return 1;} 
} 


function save_($user_name,$update_title,$update_url,$user_tel,$user_email,$remind_date,$is_send){
$db = getdb();
$sql = "INSERT INTO  `news_monitor`.`remind_log` (`ID` ,`user_name` ,`update_title`,`update_url`,`user_tel` ,`user_email` ,`remind_data` ,`is_send`) VALUES (NULL ,'$user_name','$update_title','$update_url','$user_tel','$user_email','$remind_date','$is_send');";
//echo $sql;
$db->query($sql);
}
//邮件入库函数
function emailIntoDB($user_name,$user_email,$update_title,$is_send){


$db = getdb();
$sql = "INSERT INTO `news_monitor`.`email_temp` (`ID`, `user_name`, `user_mail`, `email_title`, `send_time`, `is_send`) VALUES (NULL, '$user_name', '$user_email', '$update_title', '".date('Y-m-d   H:i:s')."', '$is_send');"; 
echo $sql;
$db->query($sql);


}
//以下两个函数用于测试！
/*
function send_RemindEmail($user_name,$user_email,$update_title,$update_url,$site_name){
        //用于测试发送邮件的内容
        echo "%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%<br>";
        echo $user_name.$site_name.":".$user_email."::".$update_title.":".$update_url."<br>";
        echo "%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%<br>";
        $user_tel='';
        $remind_date = date('Y-m-d   H:i:s');
        $update_url = urlencode($update_url);
        $update_title = urlencode($update_title);
        //save_log($user_name,$update_title,$update_url,$user_tel,$user_email,$remind_date,1);
}

function send_remindtel($user_name,$user_tel,$update_title,$update_url,$site_name){        
//用于测试所发送短信的内容
        echo "**********************************************<br>";
        echo $user_name.$site_name.":".$user_tel."::".$update_title.":".$update_url."<br>";
        echo "**********************************************<br>";
        $user_email='';
        $remind_date = date('Y-m-d   H:i:s');
        $update_url = urlencode($update_url);
        $update_title = urlencode($update_title);
        save_log($user_name,$update_title,$update_url,$user_tel,$user_email,$remind_date,1);
}
*/
$db= getdb();
?>