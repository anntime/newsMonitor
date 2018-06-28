<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>取消订阅</title>
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

<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1>取消订阅</h1>
    <p class="lead">您可以取消您自己之前订阅的所有内容。</p>
  </div>
</header>
<div class="container">
<!-- Docs nav
================================================== -->
<div class="row-fluid">
    <div class="span3">
      </div>
<?php
require "../include/common.inc.php";
$db = getdb();
if(!empty ($_COOKIE['username'])){
$username = $_COOKIE['username'];
$passcode = $_COOKIE['password'];
$judge_login = login_user($db,$username,$passcode);
if ($judge_login == 1) {
$user_num = get_usernum($db,$username);
get_choose($db,$user_num);
if ($_POST!=null) {
   get_post();
   //print_r($get_select);
   delete_select($db,$get_select,$user_num);
   if($_POST["Submit"]!=null)
   alert("系统已经接受您的修改","cancel.php");
   }
}
}
else alert("请先登录","index.php");
function get_usernum($db,$username){
	$sql = "SELECT * FROM user WHERE user_name="."\"$username\"";
    $result = $db->query($sql);
    $row = $result->fetch_array();
    $user_num = $row["user_num"];
    return $user_num;
}
function get_choose($db,$user_num){
	//列出用户所订阅的网站，并且用checkbox列出
    echo "<div class=\"span6\">
          <div id=\"demo1\" style=\"display:\" class=\"bs-docs-example bs-docs-example-submenus\">
              <p class=\"muted\">您已经选择的订阅</p>
        	<form name=\"form1\" method=\"post\" action=\"\">
                 	<table class=\"table\">
                        		<tr><th>请选择关注的网站</th><th>提醒方式</th><th>关键字</th></tr>\n";
	$sql_user = "SELECT * FROM user_site WHERE user_num = $user_num AND isDelete = 0";
	$result_user = $db->query($sql_user);
	$site_id = array();
	for ($i=0;$row = $result_user->fetch_array();$i++){
	$site_id[$i] = $row["site_id"];
	$user_key[$i] = urldecode($row["user_key"]);
	if ($row["remind"]==0) $remind[$i] ="邮件";
	else if($row["remind"]==1) $remind[$i] = "短信";
	else $remind[$i] = "邮件和短信";
	}
	$count_user = count($site_id);
	$sql_site = "SELECT * FROM site WHERE isDelete = 0";
	$result_site = $db->query($sql_site);
    while ($row=$result_site->fetch_array()){
    $name_site_id = $row["site_id"];
    for ($i = 0;$i<$count_user;$i++){
    if($name_site_id== $site_id[$i]) {
    $subsite_name =urldecode ($row["subsite_name"]);
    $select_checkbox="<input type=\"checkbox\""."name="."\"get_select[]\""."value="."\"$site_id[$i]\""."/>";
    echo "<p><tr><td>"."$select_checkbox."."$subsite_name</td><td>$remind[$i]</td><td>$user_key[$i]</td></tr></p>\n";
    }
    else continue;
   }
  }
	   echo"<tr>     </tr>";
} 
function get_post(){
	/*用于接收用户选择订阅的板块的内容
	$get_choose用于接收订阅的板块
	$get_remind用于接收提醒方式
	$get_user_key用于接收关键字
	*/
	global $get_select;
	if(!empty($_POST)){
	   $get_select = $_POST['get_select'];
	}
}
function delete_select($db,$get_select,$user_num){
	$count_select = count($get_select);
	for ($i=0;$i<$count_select;$i++){
	
	$sql = "UPDATE user_site SET isDelete = 1 WHERE user_num =$user_num AND site_id = $get_select[$i]";
	$db->query($sql);
	//echo $sql."<br>";
	}
}
?>
</table>
	<p align="right">
                 <button type="submit"name="Submit" value="提交"  class="btn btn-primary">提交</button>
                   <button type="reset" class="btn" name="reset" value="重置">重置</button></p>
</form>
</div>
</div>
<div class="span3">
</div>
</div>
<!--end-container====================================-->
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
