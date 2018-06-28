<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
//调出所有的新闻标题
require "../include/common.inc.php";
$db = getdb();
$sql="SELECT * FROM site";
$result = $db->query($sql);
while($row = $result->fetch_Array()){
	$subsite_name = urldecode($row["subsite_name"]);
	$site_id = $row["site_id"];
	$site_category = urldecode($row["site_category"]);
	echo $site_id.">>>>".$site_category."<<<<".$subsite_name."<br>"; 
}

?>
</body>
</html>