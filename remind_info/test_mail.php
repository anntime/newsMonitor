<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
require "../include/class.phpmailer.php";

require "../include/common.inc.php";

function send_RemindEmail($user_name,$user_email,$update_title,$update_url,$site_name){
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
        $mail->FromName = "Mr.Xiao";  
        $subject="新闻提醒".":".$site_name."---".$update_title; 
        //加上?utf-8?B?".base64_encode($subject)."?="这句话主要是解决邮件标题的乱码错误！
        $mail->Subject="=?utf-8?B?".base64_encode($subject)."?=";
        $mail->WordWrap   = 250; // set word wrap  
        
        //发送内容由所关注的网站，新闻标题，新闻URL构成。
        $p0 = "<p>"."您好,您关注的页面"."<b>".$site_name."</b>"."有新信息:"."</p>";
        $p1 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;".$update_title."</p>";
        $p2 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;"."<a href=".$update_url.">"."详情请点击"."</a>";
        $email_conetent=$p0.$p1.$p2;
        echo $subject.":::".$email_conetent."<br>";
        $mail->Body=$email_conetent;  

        $mail->AddAddress("$user_email","$user_name");
        $mail->IsHTML(true); // send as HTML  
        //生成发送的内容。
        if(!$mail->Send()) { echo "Mailer Error: " . $mail->ErrorInfo;} 
        else {echo "Message has been sent";} 
} 
function test_email(){
    $user_name="xqnssa";
    $user_email="xqnssa@qq.com";
    $update_title="这是一封测试邮件";
    $update_url="http://xqnssa.blog.163.com";
    $site_name = "济宁学院AIlab";
    send_RemindEmail($user_name,$user_email,$update_title,$update_url,$site_name);        
}
test_email();

/*
$db = getdb();
$sql="SELECT * FROM USER ";
$result=$db->query($sql);
while ($row=$result->fetch_array()){
    $user_name =$row["user_name"];
    $user_email = $row["user_email"];
    $user_tel = $row["user_tel"];
    $remind_site = "济宁学院";
    $remind_title="这是一封群发的测试邮件！";
    $remind_url="xqnssa.blog.163.com";
    send_RemindEmail($user_name,$user_email,$remind_site,$remind_title,$remind_url); 
    
}
*/
?>
</body>
</html>