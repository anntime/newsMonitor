﻿<!DOCTYPE HTML>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>管理员管理</title>
    <link rel="stylesheet" href="style/common/common.css">
  <style type="text/css">
  body {
      margin:0;
      padding:0;
      background-color:#E4E8EC;
  }
  .wrap {
      margin:150px auto;
      width:380px;
      overflow:hidden;
  }
  .loginForm {
      box-shadow: 0 0 2px rgba(0, 0, 0, 0.2), 0 1px 1px rgba(0, 0, 0, 0.2), 0 3px 0 #fff, 0 4px 0 rgba(0, 0, 0, 0.2), 0 6px 0 #fff, 0 7px 0 rgba(0, 0, 0, 0.2);
      position:absolute;
      z-index:0;
      background-color:#FFF;
      border-radius:4px;
      height:380px;
      width:380px;
      background: -webkit-gradient(linear, left top, left 24, from(#EEE), color-stop(4%, #FFF), to(#EEE));
      background: -moz-linear-gradient(top, #EEE, #FFF 1px, #EEE 24px);
      background: -o-linear-gradient(top, #EEEEEE, #FFFFFF 1px, #EEEEEE 24px);
  }
  .loginForm:before {
      content:'';
      position:absolute;
      z-index:-1;
      border:1px dashed #CCC;
     top:5px;
      bottom:5px;
      left:5px;
      right:5px;
      box-shadow: 0 0 0 1px #FFF;
  }
  .loginForm h1 {
      text-shadow: 0 1px 0 rgba(255, 255, 255, .7), 0px 2px 0 rgba(0, 0, 0, .5);
      text-transform:uppercase;
      text-align:center;
      color:#666;
      line-height:3em;
      margin:16px 0 20px 0;
      letter-spacing: 4px;
      font:normal 26px/1 Microsoft YaHei, sans-serif;
  }
  fieldset {
      border:none;
      padding:10px 10px 0;
  }
  fieldset input[type=text] {
      background:url(style/default/images/user.png) 4px 5px no-repeat;
  }
  fieldset input[type=password] {
      background:url(style/default/images/password.png) 4px 5px no-repeat;
  }
  fieldset input[type=text], fieldset input[type=password] {
      width:100%;
      line-height:2em;
      font-size:12px;
      height:24px;
      border:none;
      padding:3px 4px 3px 2.2em;
      width:300px;
  }
  fieldset input[type=submit] {
      text-align:center;
      padding:2px 20px;
      line-height:2em;
      border:1px solid #FF1500;
      border-radius:3px;
      background: -webkit-gradient(linear, left top, left 24, from(#FF6900), color-stop(0%, #FF9800), to(#FF6900));
      background: -moz-linear-gradient(top, #FF6900, #FF9800 0, #FF6900 24px);
      background:-o-linear-gradient(top, #FF6900, #FF9800 0, #FF6900 24px);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF9800', endColorstr='#FF6900');
      -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF9800', endColorstr='#FF6900')";
      height:30px;
      cursor:pointer;
      letter-spacing: 4px;
      margin-left:10px;
      color:#FFF;
      font-weight:bold;
  }
  fieldset input[type=submit]:hover {
      background: -webkit-gradient(linear, left top, left 24, from(#FF9800), color-stop(0%, #FF6900), to(#FF9800));
      background: -moz-linear-gradient(top, #FF9800, #FF6900 0, #FF9800 24px);
      background:-o-linear-gradient(top, #FF6900, #FF6900 0, #FF9800 24px);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF6900', endColorstr='#FF9800');
      -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF6900', endColorstr='#FF9800')";
  }
  .inputWrap {
      background: -webkit-gradient(linear, left top, left 24, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 24px);
    background: -o-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 24px);
    border-radius:3px;
    border:1px solid #CCC;
    margin:10px 10px 0;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#EEEEEE', endColorstr='#FFFFFF');
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#EEEEEE', endColorstr='#FFFFFF')";
}
fieldset input[type=checkbox] {
    margin-left:10px;
    vertical-align:middle;
}
fieldset a {
    color:blue;
    font-size:12px;
    margin:6px 0 0 10px;
    text-decoration:none;
}
fieldset a:hover {
    text-decoration:underline;
}
fieldset span {
    font-size:12px;
}
</style>
<!--为了让IE支持HTML5元素，做如下操作：-->
<!--[if IE]>
<script type="text/javascript">
document.createElement("section");
document.createElement("header");
document.createElement("footer");
</script>
<![endif]-->
<script>
function newpage($url){

  window.location.assign($url)
}

</script>
<body>
<?php
	include('../include/common.inc.php');
	$db = getdb();
    $username = $_COOKIE['managername'];
    $passcode = $_COOKIE['password'];
    $judge_login = login_manager($db,$username,$passcode);
     if ($judge_login == 1){
     echo "  <div class=\"wrap\">
              <form >
               <section class=\"loginForm\">
                <header>
                 <h1>管理员功能管理</h1>
                </header>
                 <div class=\"loginForm_content\">
				  <fieldset align =\"center\">
                   <input class=\"inputWrap\" style=\"font-size:20px;width:200px;height:50px\" type=\"button\" value=\"开始抓取\" onclick=\"newpage('../take_news.php')\">
                  </fieldset>
                  <fieldset align =\"center\">
                   <input class=\"inputWrap\" style=\"font-size:20px;width:200px;height:50px\" type=\"button\" value=\"管理用户密码\" onclick=\"newpage('manage_user.php')\">
                  </fieldset>
                  <fieldset align = \"center\">
                   <input class=\"inputWrap\" style=\"font-size:20px;width:200px;height:50px\" type=\"button\" value=\"录入网站信息\" onclick=\"newpage('enter_site.php')\">
                  </fieldset>
                  <fieldset align = \"center\">
                   <input class=\"inputWrap\" style=\"font-size:20px;width:200px;height:50px\" type=\"button\" value=\"删除网站信息\" onclick=\"newpage('delete_site.php')\">
                  </fieldset>
                 </div>
                </section>
               </form>
              </div>";
        }
         else{ alert("请先登录！","manager_login.htm");}
?>

</body>
</html>