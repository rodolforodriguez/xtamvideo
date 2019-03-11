<?php
include("../includes/connection.php");
$querynginx=mysqli_query($con,"select c.id_streamserver, ss.server, ss.port from cameras c inner join streamserver ss
on c.id_streamserver = ss.id group by(id_streamserver) order by port;");
$numrowsnginx=mysqli_num_rows($querynginx);
if($numrowsnginx!=0)
{
    $texto="worker_processes  1;
error_log  logs/error.log debug;
    events {
        worker_connections  1024;
    }
rtmp{
        ";
    while($rownginx=mysqli_fetch_assoc($querynginx))
    {  
        $query_stream=mysqli_query($con," select c.inuse,cc.ipserver,c.dcamara, ss.server, ss.port, c.channelstreamserver 
                                            from cameras c inner join streamserver ss
                                                on c.id_streamserver = ss.id
                                                    inner join centro_comercial cc on cc.id=c.id_centrocomercial 
                                                        where id_streamserver=".$rownginx['id_streamserver']."
                                                            order by port,channelstreamserver");
                                                        
        $numchannel=mysqli_num_rows($query_stream);                                                    
        
        $i=1;
        while($row_stream=mysqli_fetch_assoc($query_stream))
        {  
            if($row_stream['inuse']==1){
            $pull="pull rtmp://".$row_stream['ipserver'].":1935/".$row_stream['dcamara'].";";   
            }else{
            $pull="";    
            }
            if ($i==1){
                $texto.="
                    server {
                      listen ".$row_stream['port'].";
            
                        application ".$row_stream['channelstreamserver']." {
                            live on;
                            ".$pull."
                        }
                    ";
                }elseif($i==$numchannel){
                    $texto.="
                        application ".$row_stream['channelstreamserver']." {
                            live on;
                            ".$pull."
                        }
                    }
                    ";
                    }else{
                        $texto.="
                        application ".$row_stream['channelstreamserver']." {
                            live on;
                            ".$pull."
                        }
                        ";
                    }
        $i++;
        }

    }
}
$texto.="
}";
$fileconf="c:/nginx_vloxysecurity_V3/conf/nginx.conf";
//$fileconf="ftp://vloxy:123456@192.168.1.20/nginx_vloxysecurity_V3/conf/nginx.conf";
$fh=fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
fwrite($fh, $texto) or die("No se puede escribir en el archivo");
fclose($fh);
//echo $texto;
include("startnginx.php");  
?>