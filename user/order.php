<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>用户订阅</title>
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
    <h1>用户订阅</h1>
    <p class="lead">您可以根据自己的喜好及需求选择自己需要的提醒内容及提醒方式。</p>
  </div>
</header>
<?php
include ("../include/common.inc.php");
$db = getdb();
$judge_cookie = judge_cookie($db);
if ($judge_cookie==0) alert("您还没有登录，请登录!","index.php");
else{
$user_name = $_COOKIE["username"];
$pur_site_name =get_user_group($db,$user_name);
//$pur_site_name = get_root_choose($db);
dir_choose($db,$pur_site_name);
}
function dir_choose($db,$pur_site_name){
echo "  <div class=\"container\">
    <!-- Docs nav
    ================================================== -->
    <div class=\"row-fluid\">  
           <div class=\"span1\">
           </div>
           <div class=\"span3\">
           <div class=\"bs-docs-example bs-docs-example-submenus\">
              <p class=\"muted\">请选择网站</p>
              <div class=\"well sidebar-nav\">
                <ul class=\"nav nav-list\">";
for ($i=0;$i<count($pur_site_name);$i++){
                echo "<li class=\"nav-header\">".$pur_site_name[$i]."</li>";
                $sub_category = get_sub_choose($db,$pur_site_name[$i]);
                for ($j=0;$j<count($sub_category);$j++){
                echo "<li><a href=\"javascript:onclick=jsd('".$sub_category[$j]."');\" >".$sub_category[$j]."</a></li>";
                }
             }
           echo "</ul>
             </div>
            </div>
          </div>
          <div id=\"demo\" class=\"span7\" >\n";
        for ($i=0;$i<count($pur_site_name);$i++){
        	$sub_category = get_sub_choose($db,$pur_site_name[$i]);
            for ($j=0;$j<count($sub_category);$j++){
            echo "<div name =\"subCategoryDiv\" id=\"".$sub_category[$j]."\" style=\"display:none\" class=\"bs-docs-example bs-docs-example-submenus\">
                       <p class=\"muted\">请选择订阅:".$pur_site_name[$i].">>>".$sub_category[$j]."</p>
                         <form name=\"".urlencode($sub_category[$j])."\" action=\"save_select.php\" method=\"post\">
               				<table class=\"table\">
                        		<tr><th>请选择关注的网站</th><th>提醒方式</th><th>关键字</th></tr>\n";
            $sub_sub_info =get_sub_sub_choose($db,$pur_site_name[$i],$sub_category[$j]);
            for ($m=0;$row=$sub_sub_info->fetch_array();$m++){
              $site_name = urldecode($row["site_name"]);
              $subsite_name = urldecode($row["subsite_name"]);
		      $site_id = $row["site_id"];
              $input_user_key = "<td><input class =\"input-medium\"  name="."\"user_key[]\""."type="."\"text\""."\"user_key\""."></input></td>"."\n";
              $select_remind = "<td><select class =\"input-medium\" name="."\"remind[]\""."id="."\"remind\"".">.<option value="."\"\"".">请选择</option><option value="."\"0\"".">邮件</option><option value="."\"1\"".">短信</option><option value="."\"2\"".">短信和邮件</option></select>"."</td>\n";
              echo "<tr><td><label class=\"checkbox\"/> <input type=\"checkbox\""."name="."\"get_subsite_name[]\""."value="."\"$site_id\""."/>"."$subsite_name"."</input></td>"."\n".$select_remind.$input_user_key."</label></tr>"."\n";
          }
          echo "</table>
                <p align=\"right\">
                 <button type=\"submit\"name=\"Submit\"value=\"提交\"  class=\"btn btn-primary\">提交</button>
                   <button type=\"button\" class=\"btn\">重置</button></p>
             		 </form>
         			  </div>\n";
      }
   }
         echo "</div>
           <div class=\"span1\">
           </div>
        
         </div>
           
         
    <!--end-container====================================-->
   </div>";

}
/**************************************************************************
*                获取root_sitename的值和sub_site_name 的值，并且去掉        *
*                重复项！                                                  *
*                     copyright by Mr.Xiao   2013.04.13                   *
***************************************************************************/
    function get_root_choose($db){
   $sql = "SELECT * FROM site where isDelete=0";
   $result = $db ->query($sql);
   $site_name = array();
   for($i=0;$row = $result->fetch_array();$i++){
   $site_name[$i] = urldecode($row["site_name"]);
   }
   $pur_site_name = array_unique($site_name);
   //让数组的编号从0开始
   sort($pur_site_name);
   return $pur_site_name;
 }
    function get_sub_choose($db,$site_name){
    $site_name = urlencode($site_name);
    $sql ="SELECT * FROM site WHERE site_name ='$site_name' AND isDelete = 0";
    $result = $db->query($sql);
    $sub_site_name = array();
    for($i=0;$row = $result->fetch_array();$i++){
    $sub_site_name[$i] = urldecode($row["site_category"]);
    }
    $pur_sub_site_name = array_unique($sub_site_name);
    sort($pur_sub_site_name);
    return $pur_sub_site_name;
 }
    function get_sub_sub_choose($db,$site_name,$sub_category){
    $site_name = urlencode($site_name);   
    $sub_category = urlencode($sub_category);
    $sql ="SELECT * FROM site WHERE site_name = '$site_name' AND site_category = '$sub_category' AND isDelete =0";
    $result = $db->query($sql);
    return $result; 
    /*
    if ($result){
    for ($n=0;$row=$result->fetch_array();$n++){
    $sub_sub_name[$n] = urldecode($row["subsite_name"]);
    //echo "ttt".$sub_sub_name[$n]."$$$$$$<br>";
    }
    //print_r($sub_sub_name);
    sort($sub_sub_name);
    return $sub_sub_name;
    }
  else return;
  */
    }
function get_user_group($db,$user_name){
   $sql = "SELECT user_group FROM user WHERE user_name =\"$user_name\"";
   $result = $db->query($sql);
   $row = $result->fetch_array();
   $user_group = $row["user_group"];
   $sql_sitename = "SELECT * FROM user_group WHERE group_name = \"$user_group\"";
   $result_site = $db->query($sql_sitename);
   $site_name = array();
   $i = 0;
   while ($row = $result_site->fetch_array()){
   $site_name[$i] = urldecode($row["site_name"]);
   $i++;
   }
   return $site_name;
}
function judge_cookie($db){
	if(!empty($_COOKIE["username"])){
	$cookie_username = $_COOKIE["username"];
	$cookie_passcode = $_COOKIE["password"];
	$judge_user = login_user($db,$cookie_username,$cookie_passcode);
    if ($judge_user == 1) return 1;
    else return 0;
	}
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
<script type="text/JavaScript">
    function jsd(subCategory){
    var demo = document.getElementById("demo");
	//alert(a);
    var divArray = demo.getElementsByTagName("div");
    //document.write(divArray[1]);
    $("[name=subCategoryDiv]").hide();
    $("#"+subCategory).fadeIn("normal");
   /* for (var i=0;i<divArray.length;i++) {
     if (divArray[i].id == subCategory) {
      divArray[i].style.display='';
     }else {
      divArray[i].style.display='none';
     }
    }*/
   }
</script> 
<script type="text/JavaScript">
    jsd('AIlab的部落格');
</script> 


    jsd('AIlab的部落格');
  </body>
</html>
