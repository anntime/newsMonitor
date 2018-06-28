<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>欢迎访问智能信息提醒平台</title>
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
          <a class="brand" href="./index.html">智能新信息提醒平台</a>
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
<header class="jumbotron subhead">
  <div class="container">
    <h1>用户主页</h1>
    <p class="lead">欢迎您的到来，人工智能实验室竭诚为您服务！
  </div>
</header>

<?php
ob_start(); 
require "../include/common.inc.php";
//获取用户输入
$db=getdb();
$judge_user = judge_post($db);
$judge_cookie=judge_cookie($db);
if ($judge_user ==1) dir_user_main();
else if (($judge_cookie ==1)&&($_POST==null)) dir_user_main();
else if ($judge_user ==0 && $_POST !=null) alert("用户名密码错误，请重新登录!","index.php");
else alert("用户名密码错误，请重新登录!","index.php");
/*
$judge_cookie =judge_cookie($db);
if($judge_cookie!=1)
    alert("用户名密码错误，请重新登录!","index.php");
*/
function set_cookie($username,$passcode,$cookie){
	//设置用户的cookie
   	   switch($cookie)							//根据用户的选择设置cookie保存时间
	    	{
	    	case 0:								//保存Cookie为浏览器进程
				setcookie("username", $username);
				setcookie("password", $passcode);
				break;
			case 1:								//保存1天
				setcookie("username", $username, time()+24*60*60);
				setcookie("password", $passcode, time()+24*60*60);
				break;
			case 2:								//保存30天
				setcookie("username", $username, time()+30*24*60*60);
				setcookie("password", $passcode, time()+30*24*60*60);
				break;
			case 3:								//保存365天
				setcookie("username", $username, time()+365*24*60*60);
				setcookie("password", $passcode, time()+365*24*60*60);
				break;
		  }
		 return 1;
   }
function judge_post($db){
	if($_POST!= null){
    $username = urlencode($_POST['username']);
    $passcode = md5($_POST['passcode']);
    if(empty($_POST['cookie'])) $cookie = 0;
    else $cookie = $_POST['cookie'];
    set_cookie($username,$passcode,$cookie);
    $judge_user = login_user($db,$username,$passcode);
    if ($judge_user == 1) return 1;
    else return 0;
}
}
function judge_cookie($db){
	if(!empty($_COOKIE["username"])){
	$cookie_username = $_COOKIE["username"];
	$cookie_passcode = $_COOKIE["password"];
	$judge_user = login_user($db,$cookie_username,$cookie_passcode);
    if ($judge_user == 1) return 1;
    return 0;
	}
}
function dir_user_main(){
		echo "
<div class=\"container\">
    <!-- Docs nav
    ================================================== -->
    <div class=\"row\">
      <div class=\"span2\">
      </div>
      <div class=\"span9\">
        <h2 align=\"center\">使用说明</h2>
      <div class=\"bs-docs-example\">
              <div id=\"myCarousel\" class=\"carousel slide\">
                <div class=\"carousel-inner\">
                  <div class=\"item active\">
                    <img src=\"assets/img/bootstrap-mdo-sfmoma-01.png\" alt=\"\">
                    <div class=\"carousel-caption\">
                      <h4>用户订阅</h4>
                      <p>我们可以根据自己的需求，选择关心的网站，可以根据自己的需求设置提醒方式，如果想设置多个关键字的话，可以使用空格隔开！</p>
                    </div>
                  </div>
                  <div class=\"item\">
                    <img src=\"assets/img/bootstrap-mdo-sfmoma-02.png\" alt=\"\">
                    <div class=\"carousel-caption\">
                      <h4>查看订阅</h4>
                      <p>点击查看订阅，可以看到我们所订阅的信息！</p>
                    </div>
                  </div>
                 <div class=\"item\">
                    <img src=\"assets/img/bootstrap-mdo-sfmoma-03.png\" alt=\"\">
                    <div class=\"carousel-caption\">
                      <h4>删除订阅</h4>
                      <p>如果不需要我们提醒了，可以点击删除订阅！</p>
                    </div>
                  </div>
                </div>
                <a class=\"left carousel-control\" href=\"#myCarousel\" data-slide=\"prev\">&lsaquo;</a>
                <a class=\"right carousel-control\" href=\"#myCarousel\" data-slide=\"next\">&rsaquo;</a>
              </div>
            </div>
      </div>
      <div class=\"span1\">
    </div>
  </div>
 </div>
";
}
?>
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