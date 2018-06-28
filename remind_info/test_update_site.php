<?php
/*
coryright by xuehuiyuan
*/
include("../include/common.inc.php");
echo "您所看到的就是我们数据库中所存放的所有的新闻信息！<br>";
$db_update_name = getdb();
$sql_get_update_name = "SELECT * FROM news_update";
$result = $db_update_name->query($sql_get_update_name);
while($row = $result->fetch_Array()){
$site_id = $row["site_id"];
$update_title = urldecode($row["update_title"]);
$date_news = $row["date"];
echo $site_id."%%%%".$update_title."&&&&".$date_news."<br>";
}
?>