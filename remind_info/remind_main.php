<html><head>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
require "../include/common.inc.php";
require "../include/class.phpmailer.php";
require "../include/PHPFetion.php";
require "../include/remind.inc.php";
$db=getdb();
remind_main($db);
?>
</body>
</html>