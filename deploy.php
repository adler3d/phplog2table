<?php
  if(array_key_exists('glob',$_GET)){
    $arr=glob(dirname(__FILE__)."/*");
    if(array_key_exists('json',$_GET)){header("content-type: text/plain");echo json_encode($arr);exit();}
    echo "<pre>".implode($arr,"\n")."\n\n";
    exit();
  }
  function f($fn,$del){return count(explode($del,$fn));}
  header("content-type: text/plain");
  if(array_key_exists('data',$_POST)){
    $fn=array_key_exists('fn',$_POST)?$_POST['fn']:"g_obj.json";
    //if(f($fn,"/")>1||f($fn,"\\")>1||f($fn,".")>2||f($fn,".json")<1){
    //  echo "wrong fn, but ok, let's use default(g_obj.json)\n";$fn="g_obj.json";
    //}
    echo file_put_contents(dirname(__FILE__)."/".$fn,$_POST['data']);echo "\n";
    echo file_put_contents(dirname(__FILE__)."/last_backup_fn.txt",$fn);echo "\n";
    echo "done!\n";
  }
  echo "---\nend!";
?>
