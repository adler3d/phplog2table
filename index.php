<?php
  if(isset($_REQUEST['msg']))
  {
    $log_filename=dirname(__FILE__)."/msg.log";
    $tmp=file_exists($log_filename)?file_get_contents($log_filename):"";
    file_put_contents($log_filename,$tmp."\n".$_REQUEST['msg']);
  }
  file_put_contents(dirname(__FILE__)."/passed_time.txt",gmdate('Y-m-d H-i-s'));
  $fn=dirname(__FILE__).'/passed.txt';
  $count=file_get_contents($fn);
  $count++;
  file_put_contents($fn,$count);
  echo "count = ".$count;
?>
