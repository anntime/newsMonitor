<?php
 /*************************************************************
    连接数据库news_monitor的函数
****************************************************************/
  function getdb() 
  {
    $host="localhost";
    $user="root";
    $pwd="";
    $db_name="news_monitor";
    $mysqli=new mysqli($host,$user,$pwd,$db_name) or die  (mysqli_connect_error());
   // echo "连接数据库成功"."</br>";
    return $mysqli;
  }
/*************************************************************
    判断用户的用户名和密码是否有效
****************************************************************/ 
  function login_user($db,$username,$passcode){
	//判断用户的用户名和密码是否有效
    $sql = "SELECT * FROM user WHERE isDelete =0";
    $result = $db->query($sql);
    while($row = $result->fetch_array()){
	   global $user_num;
       $user_num = $row["user_num"];
       $cmp_username = $row["user_name"];
       $cmp_passwd = $row["user_passwd"];
       $cmp = (($cmp_username == $username)&&($cmp_passwd==$passcode));
       if ($cmp == 1)  break;
       else  continue;
         }
    return $cmp;
}
/*************************************************************
    判断管理员的用户名和密码是否有效
****************************************************************/ 
  function login_manager($db,$username,$passcode){
	//判断用户的用户名和密码是否有效
    $sql = "SELECT * FROM manager ";
    $result = $db->query($sql);
    while($row = $result->fetch_array()){
	   global $manager_num;
       $manager_num = $row["manager_num"];
       $cmp_name = $row["manager_name"];
       $cmp_passwd = $row["manager_passwd"];
       //echo $cmp_name  .$cmp_passwd;
       $cmp = (($cmp_name == $username)&&($cmp_passwd==$passcode));
       if ($cmp == 1)  break;
       else  continue;
         }
    return $cmp;
}

 /*************************************************************
    弹出警告对话框！！！
****************************************************************/ 
    function aler($msg)
    {
      echo "<script language=javascript>";
      echo "alert(\"$msg\");";
      echo "</script>";
    } 
    function alert($msg,$goto)
    {
      echo "<script language=javascript>";
      echo "alert(\"$msg\");";
      if(!empty($goto))
      echo "location=\"$goto\";";
   else
      echo "history.go(-1);";
      echo "</script>";
    }

    
/*************************************************************
    获得密码随机数。
****************************************************************/    
     function domake_password($pw_length)
      {
         $password1='';
         $low_ascii_bound=48;
         $upper_ascii_bound=57;
         $notuse=array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
         $i=0;
        while($i<$pw_length){
 
          mt_srand((double)microtime()*1000000);
          $randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);

            if(!in_array($randnum,$notuse)){
   
              if ($i==0 && $randnum==0) {
    
                $i=0;
                $password1='';
                domake_password(4);
               }

              $password1=$password1.chr($randnum);
              $i++;
            }
         }
        return $password1;
      }	
      
 
?>
 