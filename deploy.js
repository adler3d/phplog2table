resp_off();

var fn2body=fn=>({fn:fn,data:fs.readFileSync("phplog2table/"+fn).toString("binary"),from_js:"utf8->json->querystring->php->utf8_decode->fs"});

var qap_async_for=(arr,elem2obj,ok,err)=>{
  var tasks=[];var tasks_n=arr.length;
  var on=(ex,mode)=>(data=>{
    tasks.push({mode:mode,ex:ex,data:data});if(tasks_n!=tasks.length)return;
    if(tasks.filter(e=>e.mode=='ok').length==tasks_n){
      ok(tasks);
    }else err(tasks);
  });
  if(!tasks_n)cb(tasks,tmp);
  arr.map(ex=>xhr_post_with_to("http://qap.atwebpages.com/deploy.php",elem2obj(ex),on(ex,'ok'),on(ex,'fail'),1000*60));
};

var arr="index.php,eval.php,eval.html,logger.php,.htaccess".split(",");

var next=()=>{
  var all=fs.readdirSync("phplog2table").filter(e=>!e.includes(".git")).filter(e=>!arr.includes(e));
  qap_async_for(all,fn2body,()=>txt('qap_async_for :: ok'),()=>txt("qap_async_for :: fail"));
}
qap_async_for(arr,fn2body,next,()=>txt("qap_async_for :: fail"));
