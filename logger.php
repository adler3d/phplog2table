<?php

if(!function_exists("mime_content_type"))
{
  function mime_content_type($f)
  {
    return trim ( exec ("file -bi " . escapeshellarg ( $f ) ) ) ;
  }
}

function logger_entry_point()
{
  $indexes=array("index.php","index.html","index.htm","index.shtml","index.phtml");
  {
    $log_filename=dirname(__FILE__)."/logs/".gmdate("Y-m-d").".log";
    $log_flag=file_exists($log_filename);
    $log_object=array();
    $log_object['time'] = gmdate('Y-m-d H-i-s');
    $log_object['ip'] = getenv('REMOTE_ADDR');
    $log_object['request_uri'] = getenv('REQUEST_URI');
    $log_object['user_agent'] = getenv('HTTP_USER_AGENT');
    $log_object['referrer'] = getenv('HTTP_REFERER');
    $log_string=$log_flag?"\n":"";
    $log_string.=json_encode($log_object);
    $fd=fopen($log_filename,"a");
    if(flock($fd, LOCK_EX)){
      fwrite($fd,$log_string);
      fflush($fd);
      flock($fd,LOCK_UN);
    }else{
      $fp=fopen("logger_entry_point.flock.failed.txt","a");
      fwrite($fp,$log_string);
      fclose($fp);
    }
    fclose($fd);
  }
  $filename=dirname(__FILE__).preg_replace("/^(.*?)\?.*$/","$1",$_SERVER["REQUEST_URI"]);
  $forbidden=1;
  if(file_exists($filename)){
    if(!is_file($filename)){
      foreach($indexes as $directory_index){
        if(!is_file($filename) && file_exists($filename.$directory_index)){
          $filename=$filename.$directory_index;
          $forbidden=0;
          break;
        }
      }
    }else{
      $forbidden=0;
    }
  }else{
    header("HTTP/1.x 404 Not Found");
    echo "Not Found";
    die;
  }
  if($forbidden){
    header("HTTP/1.x 403 Forbidden");
    echo "Forbidden";
    die;
  }
  if(preg_match("/^.*php(\?.*){0,1}$/",$filename)){
    $this_file=dirname(__FILE__)."/logger.php";
    if($filename==$this_file){echo "lol\n";die;}
    if($filename!=$this_file)include($filename);
    die;
  }else{
    function readfile_chunked($filename,$retbytes=true)
    {
      $chunksize=1*(1024*1024);
      $buffer ='';
      $cnt=0;
      $handle=fopen($filename,'rb');
      if($handle===false){return false;}
      while(!feof($handle))
      {
        $buffer=fread($handle,$chunksize);
        echo $buffer;
        ob_flush();flush();
        if($retbytes){$cnt+=strlen($buffer);}
      }
      $status=fclose($handle);
      if($retbytes&&$status){return $cnt;}
      return $status;
    }
    header('Content-Type: '.mime_content_type($filename));
    header('Content-Length: '.filesize($filename));
    readfile_chunked($filename);
    die;
  }
};
logger_entry_point();
?>
