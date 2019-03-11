<?php

function execInBackground($cmd) { 
    if (substr(php_uname(), 0, 7) == "Windows"){ 
        pclose(popen("start ". $cmd, "r"));
        echo("entro1");  
    } 
    else { 
        exec($cmd . " > /dev/null &");   
        echo("entro2");
    } 
}
$cmd2="c:/nginx_vloxysecurity_V3/reload_nginx.bat";
//$cm2="ftp://vloxy:123456@192.168.1.20/nginx_vloxysecurity_V3/reload_nginx.bat";   
execInBackground($cmd2);
//$cmd3="start nginx";
//execInBackground($cmd3);
?>