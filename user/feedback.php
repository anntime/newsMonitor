<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>用户反馈</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">

  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">

    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../index.html">智能信息提醒平台</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active">
                <a href="../index.html">主  页</a>
              </li>
              <li class="">
                <a href="./index.php">用户登录</a>
              </li>
              <li class="">
                <a href="./register.html">用户注册</a>
              </li>
              <li class="">
                <a href="./about.html">关于我们</a>
              </li>
              <li class="">
                <a href="./feedback.php">用户反馈</a>
              </li>
              
            </ul>
          </div>
        </div>
      </div>
    </div>

<!-- Masthead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <p class="lead"><a>用户反馈</a></p>
  </div>
</header>
	
	  <div class="container">
    <!-- Docs nav
    ================================================== -->
    <div class="row">
      <div class="span3">
      </div>
      <div class="span7">
       <form action="" method="post" onsubmit="return ck();" class="bs-docs-example form-horizontal">
            <div class="control-group">
              <label class="control-label" for="inputIcon">姓名</label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-user"></i></span>
                  <input class="span3" id="yourname"  name="yourname" type="text" placeholder="姓名"></input>
                </div>
              </div>
              <p></p>
               <label class="control-label" for="inputIcon">邮箱</label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-envelope"></i></span>
                  <input class="span3" id="email"  name="email" type="text" placeholder="邮箱"></input>
                </div>
              </div>
              <p></p>
               <label class="control-label" for="inputIcon">QQ号</label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-comment"></i></span>
                  <input class="span3" id="qq"  name="qq" type="text" placeholder="QQ"></input>
                </div>
              </div>
              <p></p>
              <label class="control-label" for="inputIcon">手机号</label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-home"></i></span>
                  <input class="span3" id="tel" name="tel" type="text" placeholder="手机号">
                </div>
              </div>
             <p></p>
              <label class="control-label" for="inputIcon">内容</label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-align-justify"></i></span>
                  <textarea class="span3" rows="7" id="message" name="message" ></textarea>
                </div>
              </div>
              <p></p>
              <p></p>
                <p  style="right:200px" align="center">
                 <input name="add" type="hidden" value="1" />
                 <button type="submit"name="Submit"  value="提交"  class="btn btn-primary">提交</button>
                </p>
          </form>
      </div>
    </div>
    <div class="span2">
    </div>
  </div>
 </div>



    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <p>欢迎批评指正   我们的成长源于您的支持！</p>
        <p>济宁学院计算机科学系人工智能实验室</p>
        <p>Copyright © 2103 the Smart Alert Platform </p>        
      </div>
    </footer>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/widgets.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-affix.js"></script>

    <script src="assets/js/holder/holder.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>

    <script src="assets/js/application.js"></script>



  </body>
</html>
<script type="text/javascript">
function G(id){
   return document.getElementById(id);	
}
function ck(){
   if(G('yourname').value == ''){
	alert("姓名不能为空！");
	G('yourname').focus();
	return false;
   }
   if(G('message').value == ''){
	alert("内容不能为空！");
	G('message').focus();
	return false;
   }
}
</script>
<?php
 include("../include/class.phpmailer.php");
 include("../include/class.smtp.php"); 
 include("../include/common.inc.php");

//你只需填写以下信息即可****************************

$smtp = "smtp.163.com";//必填，设置SMTP服务器 QQ邮箱是smtp.qq.com ，QQ邮箱默认未开启，请在邮箱里设置开通。网易的是 smtp.163.com 或 smtp.126.com

$youremail =  'xqnssa@163.com'; // 必填，开通SMTP服务的邮箱；也就是发件人Email。(本系统功能也就是自己给自己发邮件)

$password = "110120"; //必填， 以上邮箱对应的密码

$ymail = "xqnssa@qq.com"; //收信人的邮箱地址，也就是你自己收邮件的邮箱

$yname = "反馈测试"; //收件人称呼

//填写信息结束 ****************************

function get_ip(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
       $ip = getenv("HTTP_CLIENT_IP");
   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
       $ip = getenv("HTTP_X_FORWARDED_FOR");
   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
       $ip = getenv("REMOTE_ADDR");
   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
       $ip = $_SERVER['REMOTE_ADDR'];
   else
       $ip = "unknown";
   return($ip);
}
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true; 
$mail->Host = $smtp; 


$mail->Username = $youremail; 
$mail->Password = $password; //必填， 以上邮箱对应的密码

$mail->From = $youremail; 
$mail->FromName = "反馈系统"; 

$mail->AddAddress($ymail,$yname);

if(!empty($_POST['add'])){
	print_r($_POST);
	$yourname = $_POST['yourname'];
	$tel = $_POST['tel'];
	$qq = $_POST['qq'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$ip = get_ip();
	$mail->Subject = $yourname."-【留言反馈】"; 
	date_default_timezone_set('Asia/Shanghai');
	$time = date("Y-m-d H:i:s",time());
	$html = '姓名：'.$yourname.'<br>电话：'.$tel.'<br>QQ：'.$qq.'<br>邮箱：'.$email.'<br>IP：'.$ip.'<br>提交时间：'.$time.'<br>内容：'.$message;
	$mail->MsgHTML($html);
	$mail->IsHTML(true); 
	if(!$mail->Send()) {

		alert("提交失败了！");
	} else {
	    alert("提交成功！感谢你的反馈。","../index.html");
	}
}
?>
