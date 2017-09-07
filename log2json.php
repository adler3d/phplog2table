<?php
  header("Content-type: text/plain");
  $filename=dirname(__FILE__)."/logs/".date("Y-m-d").".log";
  $content="[\n".implode(",\n",explode("\n",file_get_contents($filename)))."\n]";
  echo $content;
?>
