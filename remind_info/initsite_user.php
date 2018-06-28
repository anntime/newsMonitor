<?php
/*初始化site_user表
测试remind_main模块
*/
require "../include/common.inc.php";
$db = getdb(); 
$user_key="%E6%8B%9B%E8%81%98";
$remind = 2;
$sql_del="delete from user_site where 1";
$db->query($sql_del);
for ($user_num=1;$user_num<=4;$user_num++){
      for($site_id=1;$site_id<=25;$site_id++){
      $sql = "INSERT INTO user_site values ($user_num,$site_id,$remind,'$user_key',0)";
      echo $sql."<br>";
      $db->query($sql);
      }
}
?>