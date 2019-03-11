<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
$userid=$_GET['userid'];
include("../includes/connection.php");

//error_reporting(0);
$selectallcamuser=mysqli_query($con,"select * from cameras inner join logchannelinuse
					on cameras.cameraid=logchannelinuse.idcameras
						where iduser='".$userid."' and logchannelinuse.inuse=1");
						
while($rowallcamuser=mysqli_fetch_assoc($selectallcamuser)){
	$longitud=$rowallcamuser['longitud'];
	$latitud=$rowallcamuser['latitud'];
	$selectlog="select * from cameras inner join logchannelinuse
				on cameras.cameraid=logchannelinuse.idcameras
					where iduser<>'".$userid."' and logchannelinuse.inuse=1 and (longitud='".$longitud."' and latitud='".$latitud."')";
	$resultlog = $con->query($selectlog);
	$numlog=mysqli_num_rows($resultlog);
	$Selectmycam=mysqli_query($con,"select * from cameras where longitud='".$longitud."' and latitud='".$latitud."'");
	$rowmycam=mysqli_fetch_assoc($Selectmycam);
	if($numlog==0){
	$queryup="update cameras set inuse=0 where longitud='".$longitud."' and latitud='".$latitud."'";
	$result = $con->query($queryup);
	}
	$querylog=mysqli_query($con,"update logchannelinuse set inuse=0 where idcameras='".$rowmycam['cameraid']."' and iduser='".$userid."'");
}
			

//// end de las camaras a cancelar streaming
/// reestructuracion streaming conf
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
                                                    inner join centro_comercial cc on cc.id=c.id_centrocomercial; 
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
//include("startnginx.php");
function execInBackground($cmd) { 
    if (substr(php_uname(), 0, 7) == "Windows"){ 
        pclose(popen("start ". $cmd, "r"));
        //echo("entro1");  
    } 
    else { 
        exec($cmd . " > /dev/null &");   
        //echo("entro2");
    } 
}
$cmd2="c:/nginx_vloxysecurity_V3/reload_nginx.bat";
//$cmd2="ftp://vloxy:123456@192.168.1.20/nginx_vloxysecurity_V3/reload_nginx.bat";

execInBackground($cmd2);
//// finalizacion reestructuracion streaming
mysqli_close($con);
?>
</body>
</html>