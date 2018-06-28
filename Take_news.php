<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
</meta>
	<title>信息抓取</title>
</head>

<body>

<?php
  //include('include/simple_html_dom_old.php');
  include('include/simple_html_dom.php');
  include("include/sphider.inc.php");
  include("include/remind.inc.php");
    //设置http页面编码
  header("Content-type: text/html; charset=utf-8"); 
  //终止缓冲
  ob_end_clean(); 
    //获得当前系统时间
  date_default_timezone_set('PRC');    
  $now_date = date('Y-m-d   H:i:s');
  echo date('Y-m-d   H:i:s');
    //连接数据库
  $db=getdb();
  $exceptionHandle= new ExceptionHandler($db);
   //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行. 
  ignore_user_abort(); 
   // 执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去
  set_time_limit(0);  
   // 每隔一小时运行
  $interval=60*10; 
  //$interval=10; 
  //设置抓取次数
  $totleCount=0; 
  //do
 //{ 
   global $jug_Result;
   global $site_ID;
   global $CurrentUrl;
   global $CurrentTime;
   $CurrentTime=time();
   $siteInfor=null;
   echo"信息抓取开始！"."<br>";
   flush();
    //读取exception表，查看上次是否是意外退出
  $exceptionArr=$exceptionHandle->getLastException();
  $exceptionSql="SELECT  `site_id`,  `url` ,  `site_description`,`subsite_name`  FROM  `site` WHERE  `site_id` >=".$exceptionArr["site_id"]."AND isDelete =0";
  $exceptionResult=$db->query($exceptionSql);
  if($exceptionResult==null)
  {
    //读取site表，获得网站信息，比如：site_id、url和抓取新闻的tag
    $siteInfor=$db->query("SELECT `site_id`,`url`,`site_description`,`subsite_name` FROM `site` WHERE`isDelete`=0");
  }else{
  	   //判断一下Exception中是不是存储的最后一个网站，如果是就不处理，如果不是就处理
  	  $jug_sql="SELECT max(`site_id`) FROM `site` WHERE 1";
  	  $jug_Result=$db->query($jug_sql)->fetch_Array();
  	  if($jug_Result["max(`site_id`)"]==$exceptionArr["site_id"]||$jug_Result["max(`site_id`)"]<$exceptionArr["site_id"])
  	  {
  	    $siteInfor=$db->query("SELECT `site_id`,`url`,`site_description`,`subsite_name` FROM `site` WHERE`isDelete`=0");
  	  }else{
  	  	  $siteInfor=$exceptionResult;
  	      $db->query("UPDATE  `news_monitor`.`news_update` SET  `isDelete` =  '1' WHERE `news_update`.`site_id`="
  	       .$exceptionArr["site_id"]."AND  `news_update`.`update_title` ="
  	       .$exceptionArr["news_title"]."AND  `news_update`.`update_url` ="
  	       .$exceptionArr["news_lasturl"]);
  	  }
  }
     $total_count=$siteInfor->num_rows;
     $num_count=0;
     OutLing($totleCount);
    //从搜索结果中分别得到site_id、url和抓取新闻的tag
   while ($row=$siteInfor->fetch_Array())
    {
      $site_ID = $row['site_id'];
      $site_Url = $row["url"];
      //echo $row["url"];
      echo myDecode($row["subsite_name"])."<br>";
      //flush();
      $num_count++;
      SetLingData($num_count);
       /*
       判断网页是否能打开
       */
         // 创建一个cURL资源
      //$ch = curl_init();
         // 设置URL和相应的选项
      //curl_setopt($ch, CURLOPT_URL, $site_Url);
      //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      if(page_exists($site_Url)){
       //echo "???";
      //判断所给url是否合法
      url_legal($site_Url);
       if($site_Url=="http://wlx.jnxy.edu.cn/"){
        	$vars= sBwlx($site_ID,$exceptionHandle);
         }
       if($site_Url=="http://cwc.jnxy.edu.cn"){
            $vars=cwcGetNews($site_ID,$exceptionHandle);
         }
            //得到网站字符编码
          $charset=get_charset($site_Url);
          //echo"ok?";
           //获取网页内容
          $html_f = file_get_html($site_Url);
          //echo $html_f;
          if(!$html_f){
           echo "<font color=	#FF0000>".$site_Url."  无法访问！！！！！！</font><br>";
           continue;
          }
         
           //判断该网页是一层抓取还是两层抓取
          $news_TagF = $row["site_description"];
           
           if(strpos($news_TagF,"<TAG>"))
            {
              $news_Tag=explode("<TAG>",$news_TagF);
              $news_TagF=$news_Tag[0];
              $news_TagS=$news_Tag[1];;	  
                
                //两层抓取要进行双层嵌套
              foreach($html_f ->find($news_TagF)as $ele)
               {
               	   
                  //获得第二层页面的链接
                 $subUrl=$ele->src;
                 $subUrl=url_Opposite($subUrl,$site_Url);
                  //目前为止，只有济宁学院的人事处和文化传播系用得到两层抓取，暂时先这么解决。。
                  //我将dom改了，就解决了。
                 //if(strpos($subUrl,"jnxy")){
                    //调用数据入库函数
                   getTitleAndUrl($site_ID,$subUrl,$news_TagS,$charset,$exceptionHandle);
                 //}
               }
            }else{
     	       getTitleAndUrl($site_ID,$site_Url,$news_TagF,$charset,$exceptionHandle);
     	       
              }
         remind_main($db);
      }else{
   	     echo "<font color=	#FF0000>".$site_Url."  无法访问！！！！！！</font><br>";
   	     flush();
   	     $exceptions=fopen("exception.txt","a");
   	     fwrite($exceptions,$site_Url."---".date('Y-m-d   H:i:s')."\n");
   	     fclose($exceptions);
      }
        // 关闭cURL资源，并且释放系统资源
        //curl_close($ch);
      //echo "???";  
    }
    
        // 等待10分钟
       //sleep($interval);
       exeStop(); 
       $totleCount++;
       echo"这是第".($totleCount+1)."次抓取！<br>"; 
//}while(true);
?>