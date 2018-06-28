<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>重置密码</title>
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
              <li class="">
                <a href="../index.html">主  页</a>
              </li>
              <li class="">
                <a href="./order.php">用户订阅</a>
              </li>
              <li class="">
                <a href="./search.php">查看订阅</a>
              </li>
              <li class="">
                <a href="./cancel.php">取消订阅</a>
              </li>
              <li class="">
                <a href="./contact.html">联系我们</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1>修改密码</h1>
    <p class="lead">请如实填写您的个人信息！</p>
  </div>
</header>

    <?php
	    include ("../include/common.inc.php");
		require_once "../include/Text_Password.php";
		include ("../include/class.phpmailer.php");
		//print_r ($_POST);
		$base_url = "http://www.vrsmart.tk/newsmonitor/user/get_checkcode.php?code=";
        if ($_POST!=null){
		$user_name = $_POST["UserName"]; 
		$user_email = $_POST["Email"];
		}
        else aler("请输入您的信息！");
		$judge=judge_info($user_name,$user_email);


		if ($judge==0) alert("您输入的用户信息不存在，请重新输入！","resetpassword.php");
		else {
		$check_code = creatcode ();
		update_checkcode($user_email,$check_code);
		$send_url = $base_url."$check_code";
		echo $send_url;
		}
		$end_mail = send_Email($user_email,$send_url);
		if ($end_mail ==1) aler ("请登陆您的邮箱，进行重置密码！");
		else aler("系统正忙，请稍后重试！");

		
		function judge_info($username,$user_email){
		if ($user_name == null) 
			$judge_info ="SELECT * FROM `user`  WHERE `user_email` = '$user_email'"; 
		else
		$judge_info = "SELECT * FROM `user`  WHERE `user_name` = '$username' AND `user_email` = '$user_email'";
		$db = getdb();
		$result = $db->query($judge_info);
		$row = $result->fetch_array();
		if ($row == null) return 0;
		else return 1;
		echo $judge_info."<br>";
		}


		function update_checkcode($email,$checkcode){
		$update_code = "UPDATE `user` SET `checkcode`='$checkcode' WHERE user_email = '$email'";
		echo $update_code;
		$db =getdb();
		$db ->query($update_code);
		}



		function creatcode (){
		$checkcode =  Text_Password::create(48, 'unpronounceable', 'alphanumeric');
		//echo $checkcode;
		return $checkcode;
		}

function send_Email($user_email,$send_url){
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
        $subject="[智能信息提醒系统]请修改密码".":".$site_name."---".$update_title; 
        //加上?utf-8?B?".base64_encode($subject)."?="这句话主要是解决邮件标题的乱码错误！
        $mail->Subject="=?utf-8?B?".base64_encode($subject)."?=";
        $mail->WordWrap   = 250; // set word wrap  
        //发送内容由所关注的网站，新闻标题，新闻URL构成。
        $p0 = "<p>"."您好,"."</p>";
        $p1 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;"."请在24小时内，点击以下链接修改密码："."</p>";
        $p2 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>";
        $p3 = "<p>&nbsp;&nbsp;&nbsp;&nbsp;"."<a href=".$send_url.">"."点击重置密码"."</a>";
        $email_conetent=$p0.$p1.$p2.$p3;
        //echo $subject.":::".$email_conetent."<br>";
        $mail->Body=$email_conetent;  
        $mail->AddAddress("$user_email");
        $mail->IsHTML(true); // send as HTML  
        //生成发送的内容。
        if(!$mail->Send()) return 0; 
        else return 1;
} 

	?>	
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
