<?php

function execInBackground($cmd) { 
    if (substr(php_uname(), 0, 7) == "Windows"){ 
        pclose(popen("start ". $cmd, "r"));
        echo("Proceso exitoso");  
    } 
    else { 
        exec($cmd . " > /dev/null &");   
        echo("Proceso fallido");
    } 
}
$cmd2="c:/nginx_vloxysecurity_V3/reload_nginx.bat";  
execInBackground($cmd2);