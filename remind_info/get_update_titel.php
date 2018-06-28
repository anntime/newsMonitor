<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
//调出所有的新闻标题
require "../include/common.inc.php";
$db = getdb();
$sql="SELECT * FROM news_update where 1 ";
$result = $db->query($sql);
while($row = $result->fetch_Array()){
	$update_title = $row["update_title"];
	$update_title = urldecode($update_title);
	$t = $row["date"];
	$update_url = urldecode($row["update_url"]);
	echo $update_title.":".$update_url."###".$t."<br>"; 
}

?>
</body>
</html>