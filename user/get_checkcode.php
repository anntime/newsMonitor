<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>修改密码</title>
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
    <p class="lead"><a>修改密码</a></p>
  </div>
</header>


  <div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
      <div class="span3 bs-docs-sidebar">
       
      </div>
      <div class="span9">
      <div class="span9">





<?php
include ("../include/common.inc.php");
if($_GET!=null){
$check_code = $_GET["code"];
}
$judge_code = judge_code($check_code);
if ($judge_code==0) aler("您的验证信息无效！");
else dir_update();

if ($_POST!=null){
$user_name = $_POST["username"];
$user_password = $_POST["passcode"];
$user_confirm_password = $_POST["conpasscode"];
$change =update_password($user_name,$user_password,$check_code);
if ($change==1) alert ("恭喜您，修改成功！","index.php");
}
function judge_code($check_code){
$judge_code = "SELECT * FROM `user`  WHERE `checkcode` = '$check_code'";
		$db = getdb();
		$result = $db->query($judge_code);
		$row = $result->fetch_array();
		if ($row == null) return 0;
		else return 1;
}

function dir_update(){
  echo "<form class=\"bs-docs-example form-horizontal\" action=\"\" method=\"POST\">
            <div class=\"control-group\">
              <label class=\"control-label\" for=\"inputEmail\">UserName</label>
              <div class=\"controls\">
                <input id=\"username\" name=\"username\" type=\"text\" placeholder=\"用户名\">
              </div>
            </div>
            <div class=\"control-group\">
              <label class=\"control-label\" for=\"inputPassword\">Password</label>
              <div class=\"controls\">
                <input id=\"passcode\" name=\"passcode\" type=\"password\" placeholder=\"密码\" value=\"\"> 
               </div>
            </div>
            <div class=\"control-group\">
              <label class=\"control-label\" for=\"inputPassword\">Confirm Password</label>
              <div class=\"controls\">
                <input id=\"conpasscode\" name=\"conpasscode\" type=\"password\" placeholder=\"确认密码\" value=\"\"> 
                </div>
            </div>
            <div class=\"control-group\">
              <div class=\"controls\">
                <button type=\"submit\" class=\"btn\" onClick=\"CheckData()\">确认修改</button>
              </div>
            </div>
          </form>";
}
function update_password($username,$password,$check_code){
	$password = md5($password);
	$update_password = "UPDATE `user` SET `user_passwd` = '$password' where `user_name`='$username' AND `checkcode` = '$check_code' ";
	$db= getdb();
	$db->query($update_password);
	return 1;
}


?>


        </div>

        



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
    <script src="assets/js/checkData.js"></script>s
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
