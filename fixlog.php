<?php
  {
    header("Content-Type: text/plain");
    echo "no way";exit;
  }
header("content-type: text/plain");

$A=file_get_contents("logs/".gmdate("Y-m-d").".log");
$C=$A;
//$C=explode('"}\n{"',$C);$C=implode('"}{"',$C);

$C=explode("\"}{\"",$C);$C=implode("\"}\n{\"",$C);

$g=explode("\n",$C);

$out=array();

foreach($g as $k=>$v){if(substr($v,-1)!='}'){$out[]=$k;$t=array_splice($g,$k,1);$out[]=$t[0];}}

file_put_contents("logs/".gmdate("Y-m-d").".log",implode("\n",$g));

echo $A;
echo "\n\nremoved:\n";
echo implode("\n",$out);
echo "\nend.\n";
echo implode("\n",$g);
?>
