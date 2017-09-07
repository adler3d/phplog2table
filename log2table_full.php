<style type="text/css">
  table{border-collapse:collapse;font-family:Consolas;font-size:10pt;}th{background:#ccc;text-align:center;}td,th{border:1px solid #800;padding:4px;}
</style><?php
  function hint($msg){echo "<pre>".$msg."\n</pre>";}
  function PrintMyTable($answer)
  {
    $def_answer=array(
      array('id'=>1,'nick'=>'Owen'),
      array('id'=>2,'nick'=>'Kyle'),
      array('id'=>3,'nick'=>'Luke'),
    );
    if(!count($answer)){hint('table is empty');return;}
    if(!count($answer[0])){hint('table is empty');return;}
    $arr=array_keys((array)$answer[0]);
    $out="";
    foreach($arr as $key=>$value)
    {
      $out.='<th>'.htmlspecialchars($value).'</th>';
    }
    $out='<tr>'.$out.'</tr>';
    foreach($answer as $arr)
    {
      $tmp="";
      $arr=(array)$arr;
      foreach($arr as $value){
        $tmp.='<td>'.htmlspecialchars($value).'</td>';
      }
      $out.='<tr>'.$tmp.'</tr>';
    }
    $out='<table>'.$out.'</table>';
    return $out;
  }
  function group($arr,$field)
  {
    $buff=array();
    foreach($arr as $rec)
    {
      $recarr=(array)$rec;
      $value=$recarr[$field];
      $buff[$value]++;
    }
    foreach($buff as $key=>$value)
    {
      if($field=='time')if($value<=1){continue;}
      $outarr[]=array('value'=>$key,'count'=>$value);
    }
    return $outarr;
  }
  function CMD_Stats($logs)
  {
    $arr=array_keys((array)$logs[0]);
    $output="";
    foreach($arr as $key=>$value)
    {
      $group=group($logs,$value);
      $group=count($group)?$group:array(array("table"=>"empty"));
      $table=PrintMyTable($group);
      $output.="<b>$value</b>\n".$table."\n";
    }
    hint($output);
  }
  function hide_dot_tmp($arr)
  {
    $illegals=array(0=>'/favicon.ico',1=>'/.tmb/');
    $out=array();
    foreach($arr as $key=>$value){
      $skip=false;
      foreach($illegals as $k=>$v)
      {
        $ex=substr($value->request_uri,0,strlen($v));
        if($v==$ex)$skip=true;
      }
      if($skip)continue;
      $out[]=$value;
    }
    return $out;
  }
  $arr=glob("logs/*");
  $out=array();
  foreach($arr as $k=>$v){
    $tmp=json_decode("[\n".implode(",\n",explode("\n",file_get_contents($v)))."\n]");
    $c=count($tmp);
    for($i=0;$i<$c;$i++)$out[]=$tmp[$i];
  }
  $logs=hide_dot_tmp($out);
  //hint(print_r($logs,true));
  CMD_Stats($logs);
  hint(PrintMyTable($logs));
  //hint("<h1>Stats</h1>");
?>
