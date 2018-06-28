<?php
//设置http页面编码
  header("Content-type: text/html; charset=utf-8"); 
/*************************************************************
    连接数据库news_monitor的函数
****************************************************************/
/*
  function getdb() 
  {
    $host="localhost";
    $user="root";
    $pwd="";
    $db="news_monitor";
    $mysqli=new mysqli($host,$user,$pwd,$db) or die  (mysqli_connect_error());
   // echo "连接数据库成功"."</br>";
    return $mysqli;
  }
*/
/*************************************************************
    URL编码函数
****************************************************************/
   function myEncode($str)
   {
     $str = urlencode($str);
     return $str;
     
     
    }

/*************************************************************
    URL解码函数
****************************************************************/
   function myDecode($str)
   {
     $str = urldecode($str);
     return $str;
    }
         
/*************************************************************
    判断字符串编码是否为utf8的函数
****************************************************************/
   function is_utf8($str) 
   { 
     if   (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$str) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$str) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$str) == true) 
       {    
         return true;
          
       } 
     else 
       { 
         return false; 
        } 
    }
    
/*************************************************************
    获得网站编码
****************************************************************/
   function get_charset($url)
   { 
   	 try{
   	 $html_f = file_get_html($url);
   	 if($html_f!=null){
      	 preg_match("/<meta.+?charset=(.*)\">/i",$html_f,$charset);
        //print ($charset);
        $arr= explode("\"",$charset[1]);
         return $arr[0];
     }else{
     return  "gb2312";
     }
     }catch(exception $e){
       return  "gb2312";
       }
   }
/*************************************************************
    将未知字符串编码转换成utf8的函数
****************************************************************/
    function turn_utf8 ($str,$charset)
   { 
       // 	if(is_utf8($str)==0) 
       try{
       if(strlen($charset)<64){
         $str = iconv($charset,"UTF-8",$str); 
         return $str;
       }else{
        $str = iconv("gb2312","UTF-8",$str); 
        return $str;
       }
       }catch(exception $e){
       return  $str;
       }
         
       	    
    }
/*************************************************************
    判断url是否合法
****************************************************************/
    function url_legal($url) 
   { 
     try{
     $array = get_headers($url,1);
      
      //利用正则表达式判断表头
     if(preg_match('/404/',$array[0]))
      {
        echo "无效url！";
        return false;
      }
     else
      {
        //echo "合法url！";
        return true;
      } 
     }catch(exception $e){
      echo $url."----> No response.<br>";
     }
    }
/*************************************************************
    判断新闻url是相对地址还是绝对地址，
    如果是相对地址（.././），则转成绝对地址
    如果是绝对地址则甚么也不做
    (第一个参数是要判断的地址，第二个参数是抓取标题的地址)
****************************************************************/
    function url_Opposite($jug_url,$site_Url) 
   {
   	 if(substr($jug_url,0,7)!="http://")
   	 {
   	    //说明这是相对地址，需要转成绝对地址
   	   $real_Url=explode("/",$site_Url);
       $URL=$real_Url[0]."/".$real_Url[1]."/".$real_Url[2];
       $jug_url=str_replace(".././","",$jug_url);
       $jug_url=str_replace("./","",$jug_url);
       if(ord("/")==ord($jug_url))
       {
         $jug_url=$URL.$jug_url;
        }
       else
       {
       	 $jug_url=$URL."/".$jug_url;  
       }
   	   return $jug_url;
   	  }
     else{
       return $jug_url;	 
     }
   }

/*************************************************************
    判断新闻标题是从title中得到还是从plaintext中得到
****************************************************************/
    function titleOrPlain($ele,$url) 
   { 
     if($url=="http://xxglzx.jnxy.edu.cn/")
      {
        return $ele->title;
      }
      if($url=="http://laoganbu.jnxy.edu.cn/")
      {
        return $ele->title;
      }
      if($url=="http://dxwyb.jnxy.edu.cn/")
      {
        return $ele->title;
      }
     if($url=="http://www.jnxy.edu.cn/")
      {
        return $ele->title;
      }
     if($ele->title==null)
      {
        return $ele->plaintext;
      }
      else
      {
        return $ele->title;
      }
    }

/*************************************************************
    断点处理机制
****************************************************************/
class ExceptionHandler
 {
 	private $site_ID='1';
 	private $db;
 	private $lastException=array();
 	function __construct($db)
 	{
 	 		$this->db=$db;
 	}
 			
 	function __destruct()
    {
    }
 	
    function saveLastException($site_ID,$news_Title,$news_Url)
    {
    	$this->lastException=array();
 		$this->lastException["site_id"]=$site_ID;
 		$this->lastException["news_title"]=$news_Title;
 		$this->lastException["news_lasturl"]=$news_Url;
 				
 		$this->db->query("DELETE FROM `exceptions` WHERE 1") or die($this->db->error);
 		$sql="replace into exceptions(site_id,news_title,news_lasturl)values('".$this->db->real_escape_string($site_ID)."'," ."'".$this->db->real_escape_string($news_Title)."'," ."'".$this->db->real_escape_string($news_Url)."')";
 		//echo $sql;
 		$this->db->query($sql) or die($this->db->error);	
    } 	
    function getLastException()
 	{
 		$sql="select * from exceptions WHERE 1 ";
 		$result=$this->db->query($sql) or die($this->db->error);
 		//echo $sql;
 		$row=$result->fetch_array();
 		$this->lastException["site_id"]=$row["site_id"];
 		$this->lastException["news_title"]=$row["news_title"];
 		$this->lastException["news_lasturl"]=$row["news_lasturl"];	
 		
 		$sql="delete from exceptions WHERE `site_id` =".$this->site_ID."";
 		$this->db->query($sql) or die($this->db->error);
 	    //$this->db->query("DELETE FROM `exceptions` WHERE 1") or die($this->db->error);
 		//var_dump($this->lastException);
 		return $this->lastException;
 	}
 }

/*************************************************************
    判断信息抓取是一层抓取还是两层抓取
    没用了，有了更好的解决方法。。。

    function firstOrSecond($site_Url,$tag_f)
 	{
        $html_f = file_get_html($site_Url);
        foreach($html_f ->find($tag_f)as $eleF)
      {
          // echo turn_utf8($ele,$charset);
           if($eleF->href==null)
           {
              //echo $ele->src."</br>";
              if(ord(".")==ord($eleF->src))
              {
              	  $subUrl=str_replace(".",$url,$eleF->src);
              	  echo $subUrl."</br>";
              }else{
              	  $subUrl=$url.$eleF->src;
              	  echo $subUrl."</br>";
              }
              $html_s = file_get_html($subUrl);
              
           }
        }
    }
****************************************************************/



/*************************************************************
    数据入库的一般函数
****************************************************************/
    function getTitleAndUrl($site_ID,$site_Url,$news_Tag,$charset,$exceptionHandle)
 	{
          //获得当前系统时间
        $now_date = date('Y-m-d   H:i:s');
         //连接数据库
        $db=getdb();
         try{
        $html_f = file_get_html($site_Url);
        if($html_f!=null){
        foreach($html_f ->find($news_Tag)as $ele)
        {
          //获得新闻标题（进行判断，以便于获得最优结果）
         $news_Title=titleOrPlain($ele,$site_Url);
          //获得新闻链接
         $news_Url=$ele->href;
          //将新闻的绝对地址换成相对地址
         $news_Url=url_Opposite($news_Url,$site_Url);
          //将抓取的内容转换成utf8格式
         $news_Url=turn_utf8($news_Url,$charset);
         $news_Title=turn_utf8($news_Title,$charset);
          //将输出内容正规化
          $news_Title=formatString($news_Title);
          //输出抓取的内容
         //echo $news_Url."</br>";
         //echo $news_Title."</br>";
          //将新闻标题进行URL编码
         $news_Title=myEncode($news_Title);
         $news_Title=str_replace("+","",$news_Title);
          //随时记录信息抓取情况，即添加断点处理机制。
         try
         {
                  //检查新闻在两天内是否有重复
                 //$is_Exist=$db->query("select update_title from news_update where update_title='".$news_Title.
                //     "'and site_id='".$site_ID."'and `date` >= DATE_SUB(now(),INTERVAL 2 DAY);")or die($db->error);
              //检查新闻是否有重复
            $is_Exist=$db->query("select update_title from news_update where update_title='".$news_Title.
                  "'and site_id='".$site_ID."'or 'update_url'='$news_Url';")or die($db->error);
             //新闻不重复便入库。
            if($is_Exist->fetch_Array()==null&&($news_Title!=null)&&($news_Url!=null))
              {
				 /******************************************************************************
              	 * 			新增正文获取功能														*
              	 *   		修改原来入库的INSERT语句，在数据库的news_update表中新加一个			*
              	 *          news_content的字段，用来存放正文内容。								*
              	 *							BY  MR.Xiao											*
              	 * 							备注：以下7行代码为新加于2013.04.29					*
              	 *******************************************************************************/
				 $iTextExtractor = new textExtract($news_Url);
				 $news_content = $iTextExtractor->getPlainText();
			 	 if( $iTextExtractor->isGB ) $news_content = iconv( 'GBK', 'UTF-8//IGNORE', $news_content);
			 	 echo $news_content."<br>";
			 	 $news_content = urlencode ($news_content);
               	 $sql="INSERT INTO  `news_monitor`.`news_update` (`site_id` ,`update_title`,`news_content` ,`date` ,`update_url` ,`send` ,`isDelete`)".
           	     "VALUES ('".$site_ID."',  '".$news_Title."', '".$news_content."',  '".$now_date."',  '".$news_Url."',  '0',  '0');";
                 $db->query($sql)or die($db->error);
                 echo $news_Title."</br>";
                 echo $news_Url."</br>";
                 //echo $now_date."</br>";
                 echo "Update Completely! </br>";
                  //记录当前所抓取的页面
                 $exceptionHandle->saveLastException($site_ID,$news_Title,$news_Url);
             }
            else{
                // echo "Already exists! </br>";
                 $exceptionHandle->saveLastException($site_ID,$news_Title,$news_Url);
               }	
         }
         catch(Exception $e)
         	 {
                 //记录当前所抓取的页面
              	$exceptionHandle->saveLastException($site_ID,$news_Title,$news_Url);
             	die("Aborted @SubClass:$subURL<br />");
	
             }
            
       }
         }
         }catch(Exception $e)
         	 {
         	 
         	 echo "<font color=	#FF0000>".$site_Url."  无法访问！！！！！！</font><br>";
         	 }
    }

/*************************************************************
    标题正规化
    去掉类似于XXXX（2012-11-12）这样的东西。
    还排除了抓错了的标题
****************************************************************/
    function formatString($news_Title)
    {
    	$preg="((([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-".
    	"(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|".
    	"((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29))";
      if(preg_match($preg,$news_Title))
      {
    	preg_match($preg,$news_Title,$arr);
        $news_Title=str_replace("(".$arr[0].")","",$news_Title);
        if($news_Title=="more"||$news_Title=="更多 &gt;&gt;"||substr($news_Title,0,6)=="法桐"){
        	return "";
        }else{
        return $news_Title;
        }
      }else{
      	  return $news_Title;
      }
    }	



/*************************************************************
   为奇葩济宁学院物理系的网页单独写的函数！！！！！！！！！！！！
   该网页是由一个个静态页面组成的有木有？？
****************************************************************/

    function sBwlx($site_ID,$exceptionHandle)
    {
      //include( "include/common.inc.php" );
     
      $site_Url="http://wlyxxgc.blog.163.com/";
      $tag_f="p a[href]";
      $html_f = file_get_html($site_Url);
      $charset=get_charset($site_Url);
      foreach($html_f ->find($tag_f)as $ele)
      {
      	$news_Url=turn_utf8($ele->href,$charset);
        $news_Url=url_Opposite($news_Url,$site_Url);
        $news_Title=turn_utf8($ele->plaintext,$charset)."</br>";
        if(substr($news_Title,0,6)=="阅读"||substr($news_Title,0,6)=="评论"||substr($news_Title,0,6)=="查看"||substr($news_Title,0,1)=="$")
      {
        $news_Title=null;
        }	
         //echo $news_Url."</br>";  
         //echo $news_Title."</br>";
         enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
  }

     $site_Url="http://wlx.jnxy.edu.cn/%E5%B0%B1%E4%B8%9A%E6%8C%87%E5%AF%BC/more%20.htm ";
     $tag_f="table[align=center] td[align=left] a[href]";
     $html_f = file_get_html($site_Url);
     $charset=get_charset($site_Url);
     foreach($html_f ->find($tag_f)as $ele)
      {
      	$news_Url=turn_utf8($ele->href,$charset);
        $news_Url=url_Opposite($news_Url,$site_Url);
        $news_Title=turn_utf8($ele->plaintext,$charset);
        $news_Title=str_replace(" ","",$news_Title);
        $news_Title=str_replace("	","",$news_Title);
        $news_Title=str_replace("&nbsp;","",$news_Title);
        $news_Title=str_replace("&gt;&gt;","",$news_Title);
        if($news_Title=="网站首页"||$news_Title=="欢迎光临济宁学院物理与信息工程系网站"||$news_Title=="您所在位置：网站首页就业指导就业更多..."||$news_Title=="更多就业信息"||$news_Title=="首页")
      {
        $news_Title=null;
        }
     //	echo $news_Url."</br>";  
         //echo $news_Title."</br>";
         enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
}

     $site_Url="http://wlx.jnxy.edu.cn/%E7%A7%91%E7%A0%94%E5%B7%A5%E4%BD%9C/more/more%E4%B8%BB%E9%A1%B5.htm ";
     $tag_f="table[align=center] td a[href]";
     $html_f = file_get_html($site_Url);
     $charset=get_charset($site_Url);
     foreach($html_f ->find($tag_f)as $ele)
      {
      	$news_Url=turn_utf8($ele->href,$charset);
        $news_Url=url_Opposite($news_Url,$site_Url);
        $news_Title=turn_utf8($ele->plaintext,$charset);
        $news_Title=str_replace(" ","",$news_Title);
       $news_Title=str_replace("	","",$news_Title);
        $news_Title=str_replace("&nbsp;","",$news_Title);
        $news_Title=str_replace("&gt;&gt;","",$news_Title);
        if($news_Title=="网站首页"||$news_Title=="的报告"||$news_Title=="您所在位置：网站首页就业指导就业更多..."||$news_Title=="更多就业信息"||$news_Title=="首页")
      {
        $news_Title=null;
        }
        //	echo  $news_Url."</br>";  
        // echo  $news_Title."</br>";
         enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
} 
         $site_Url="http://wlx.jnxy.edu.cn/%E6%95%99%E5%AD%A6%E5%B7%A5%E4%BD%9C/more%E4%B8%BB%E9%A1%B5.htm ";
         $tag_f="td a[href]";
         $html_f = file_get_html($site_Url);
         $charset=get_charset($site_Url);
         foreach($html_f ->find($tag_f)as $ele)
      {
      	$news_Url=turn_utf8($ele->href,$charset);
        $news_Url=url_Opposite($news_Url,$site_Url);
        $news_Title=turn_utf8($ele->plaintext,$charset);
        $news_Title=str_replace(" ","",$news_Title);
       $news_Title=str_replace("	","",$news_Title);
        $news_Title=str_replace("&nbsp;","",$news_Title);
        $news_Title=str_replace("&gt;&gt;","",$news_Title);
        if($news_Title=="网站首页"||$news_Title=="的报告"||$news_Title=="您所在位置：网站首页就业指导就业更多..."||$news_Title=="更多就业信息"||$news_Title=="首页")
      {
        $news_Title=null;
        }
        //	echo  $news_Url."</br>";  
         //echo  $news_Title."</br>";
         enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
}

     $site_Url="http://wlx.jnxy.edu.cn/%E4%B8%8B%E8%BD%BD%E4%B8%AD%E5%BF%83/more.html ";
         $tag_f="td a[href]";
         $html_f = file_get_html($site_Url);
         $charset=get_charset($site_Url);
         foreach($html_f ->find($tag_f)as $ele)
      {
      	$news_Url=turn_utf8($ele->href,$charset);
        $news_Url=url_Opposite($news_Url,$site_Url);
        $news_Title=turn_utf8($ele->plaintext,$charset);
        $news_Title=str_replace(" ","",$news_Title);
       $news_Title=str_replace("	","",$news_Title);
        $news_Title=str_replace("&nbsp;","",$news_Title);
        $news_Title=str_replace("&gt;&gt;","",$news_Title);
        if($news_Title=="网站首页"||$news_Title=="的报告"||$news_Title=="您所在位置：网站首页就业指导就业更多..."||$news_Title=="更多就业信息"||$news_Title=="首页")
      {
        $news_Title=null;
        }
        //	echo  $news_Url."</br>";  
        // echo  $news_Title."</br>";
         enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
 }

   $site_Url="http://wlx.jnxy.edu.cn/%E7%B3%BB%E5%86%85%E6%96%B0%E9%97%BB/more.html ";
         $tag_f="td.i_news a[href]";
         $html_f = file_get_html($site_Url);
         $charset=get_charset($site_Url);
         foreach($html_f ->find($tag_f)as $ele)
      {
      	$news_Url=turn_utf8($ele->href,$charset);
        $news_Url=url_Opposite($news_Url,$site_Url);
        $news_Title=turn_utf8($ele->plaintext,$charset);
        $news_Title=str_replace(" ","",$news_Title);
       $news_Title=str_replace("	","",$news_Title);
        $news_Title=str_replace("&nbsp;","",$news_Title);
        $news_Title=str_replace("&gt;&gt;","",$news_Title);
        if($news_Title=="网站首页"||$news_Title=="的报告"||$news_Title=="您所在位置：网站首页就业指导就业更多..."||$news_Title=="更多就业信息"||$news_Title=="首页")
      {
        $news_Title=null;
        }
        //	echo  $news_Url."</br>";  
        // echo  $news_Title."</br>";
         enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
}
    return "成功";
    }
/*************************************************************
    为物理系和财务处写的信息入库函数
****************************************************************/ 
    function enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle)
    {
          //连接数据库
         $db=getdb();
          //获得系统当前时间
         $now_date = date('Y-m-d   H:i:s');
          //将新闻的url也进行url编码
         $news_Url=myEncode(myDecode($news_Url)); 
         $news_Url=str_replace("%2f","/",$news_Url);
         $news_Url=str_replace("%3a",":",$news_Url);
          //将新闻标题进行URL编码
         $news_Title=myEncode($news_Title);
         $news_Title=str_replace("+","",$news_Title);
          //随时记录信息抓取情况，即添加断点处理机制。
         try
         {
               //检查新闻在两天内是否有重复
              //$is_Exist=$db->query("select update_title from news_update where update_title='".$news_Title.
              //     "'and site_id='".$site_ID."'and `date` >= DATE_SUB(now(),INTERVAL 2 DAY);")or die($db->error);	 
            //检查新闻是否有重复
            $is_Exist=$db->query("select update_title from news_update where update_title='".$news_Title.
                  "'and site_id='".$site_ID."';")or die($db->error);
             //新闻不重复便入库。
            if($is_Exist->fetch_Array()==null&&($news_Title!=null)&&($news_Url!=null))
              {
				 /******************************************************************************
              	 * 			新增正文获取功能														*
              	 *   		修改原来入库的INSERT语句，在数据库的news_update表中新加一个			*
              	 *          news_content的字段，用来存放正文内容。								*
              	 *							BY  MR.Xiao											*
              	 * 							备注：以下8行代码为新加于2013.04.29					*
              	 *******************************************************************************/
				 $iTextExtractor = new textExtract($news_Url);
				 $news_content = $iTextExtractor->getPlainText();
			 	 if( $iTextExtractor->isGB ) $news_content = iconv( 'GBK', 'UTF-8//IGNORE', $news_content);
			 	 echo $news_content."<br>";
			 	 $news_content = urlencode ($news_content);
               	 $sql="INSERT INTO  `news_monitor`.`news_update` (`site_id` ,`update_title`,`news_content` ,`date` ,`update_url` ,`send` ,`isDelete`)".
           	     "VALUES ('".$site_ID."',  '".$news_Title."', '".$news_content."',  '".$now_date."',  '".$news_Url."',  '0',  '0');";
                 $db->query($sql)or die($db->error);
                echo myDecode($news_Url)."</br>";
                echo myDecode($news_Title)."</br>";
                // echo "Update Completely! </br>";
                  //记录当前所抓取的页面
                 $exceptionHandle->saveLastException($site_ID,$news_Title,$news_Url);
             }
            else{
                 //echo "Already exists! </br>";
                 $exceptionHandle->saveLastException($site_ID,$news_Title,$news_Url);
               }	
         }
         catch(Exception $e)
         	 {
                 //记录当前所抓取的页面
              	$exceptionHandle->saveLastException($site_ID,$news_Title,$news_Url);
             	die("Aborted @SubClass:$subURL<br />");
	
             }
    }
/*************************************************************
    使程序停止的函数
****************************************************************/       
      //这个函数检查目录中有没有"exeStop"这个文件。如果有，则停止程序。 
      //也就是说，如果你想要停止程序。只要在目录下建一个文件"exeStop"。 
    function exeStop() 
     { 
       $fileName="exeStop"; 
       if(file_exists($fileName)) 
        { 
           //根据网上资料，以下5行任何一行都能kill掉这个进程。 
           //但是我被这个程序吓怕了，多带点符防鬼。 
         ignore_user_abort(false); 
         set_time_limit(10); 
         ob_end_flush(); 
        echo "STOP"; 
        exit(); 
      } 
   }

/*************************************************************
    财务处获得新闻标题与新闻url
    因为财务处的网页总是get不到，所以就想办法用curl得到
****************************************************************/
    function cwcGetNews($site_ID,$exceptionHandle) 
     { 
     	 $url="http://cwc.jnxy.edu.cn/cwkx/Index.asp";
          // 初始化一个 cURL 对象
         $curl = curl_init();
          // 设置你需要抓取的URL
         curl_setopt($curl, CURLOPT_URL,$url);
          // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          // 运行cURL，请求网页
         $data = curl_exec($curl);
          // 关闭URL请求
         curl_close($curl);
          // 显示获得的数据
          //var_dump($data);
          //判断得到的数据是不是字符串
          //$jude=is_string($data);
         $html_f = str_get_html($data);
         $tag_f="td[align=left] a[href][title]";
         foreach($html_f->find($tag_f)as $ele){
           if($ele->title==null)
            {
              $news_Title=$ele->plaintext;
             }
           else{
            $news_Title=$ele->title;
           }
           //获得新闻链接
            $news_Url=$ele->href;
           //将新闻的绝对地址换成相对地址
          $news_Url=url_Opposite($news_Url,$url);
           //将抓取的内容转换成utf8格式
          $news_Url=turn_utf8($news_Url,"gb2312");
          $news_Title=turn_utf8($news_Title,"gb2312");
         if(($news_Title!=null)&&($news_Url!=null))
         {
           //输出抓取的内容
          //echo $news_Url."</br>";
          //echo $news_Title."</br>";
           //将新闻入库
          enter_database($site_ID,$news_Title,$news_Url,$exceptionHandle);
          }
     }
   return "抓取信息成功！";
 }

/*************************************************************
    设置抓取程度进度条
****************************************************************/
function OutLing($totleCount){
    global $total_count;
   echo  "<br /><div style=\"width:500px;height:30px;margin:0 auto;border:#000000 solid 1px;\">" ;
   echo "<div id=\"login".$totleCount."\" style=\"background:#0000FF;width:1px;height:30px;\"></div><span id=\"num".$totleCount."\"></span> Update completed, $total_count in total</div>\n";
   echo "<script type=\"text/jscript\">\n";
   echo "function $(value,nums){\n";
   echo "document.getElementById(\"login".$totleCount."\").style.width =value +  \"px\";\n";
   echo "document.getElementById(\"num".$totleCount."\").innerHTML=nums;\n";
   echo "}\n";
   echo "$(0,0);\n";
   echo "</script>\n"; 
   flush();
}

function SetLingData($I){
    global $total_count;
   echo "<script>$(".($I/$total_count*500).",".$I.")</script>"; 
   flush();
}






?>

