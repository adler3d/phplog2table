<?php
//header("content-type: text/plain");
function f($v){
  $D="</td><td>";
  return "<tr><td><a href=\"".$v."\">".$v."</a>".$D." size: ".filesize($v)." bytes".$D." mtime: ".date("Y-m-d H-i-s",filemtime($v))."</td></tr>";
}
$style='<style type="text/css">table{border-collapse:collapse;font-family:Consolas;font-size:10pt;}th{background:#ccc;text-align:center;}td,th{border:1px solid #800;padding:4px;}</style>';
echo "<html><body>$style<pre><table>".implode(array_map(f,glob("*")),"\n")."</table></pre></body></html>";
?>
