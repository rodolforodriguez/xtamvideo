<?php
error_reporting(0);
$ip=$_GET['ip'];
$cliente=$_GET['state'];
$userid=$_GET['userid'];
// Database Constants
include("../includes/connection.php");
/// end conexion camaras privadas
$query =mysqli_query($con,"select c.cameraid, cc.ipserver, c.dcamara, ss.server, ss.port, c.channelstreamserver
                            from cameras c
                                inner join streamserver ss on c.id_streamserver = ss.id
                                inner join centro_comercial cc on cc.id=c.id_centrocomercial 
                                    where cameraid=".$ip."
                                        order by port,channelstreamserver");
          $numrows=mysqli_num_rows($query);
          if($numrows!=0)
          {
            $row=mysqli_fetch_assoc($query);
            if($cliente==0){
			$query =mysqli_query($con,"update cameras set inuse=1 where cameraid=".$ip);
			$queryinsert=mysqli_query($con,"insert into logchannelinuse(idcameras,iduser,inuse)values('".$row['cameraid']."','".$userid."','1')");
            $streaming="rtmp://".$row['server'].":".$row['port']."/".$row['channelstreamserver'];
            nginx();
            //echo"<a href='../nginx_vloxysecurity_V3/find.php'>test</a>"; 
            }else{
            $streaming="rtmp://".$row['ipserver'].":1935/".$row['dcamara'];    
            }
          }
?>

<!DOCTYPE html>
<!-- saved from url=(0037)https://www.hlsplayer.net/rtmp-player -->
<html lang="en">
<head>
	<style>
		#player{
        width: 100%;	
       /* height: 600px;*/		
      }
	</style>	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta http-equiv="refresh" content="3000;url=../index.php"/>-->
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
	<title>Xtam</title>
	<meta name="keywords" content="rtmp player, rtmp">
	<meta name="description" content="This page allows you to play RTMP streams online with no installation required.">
	<script async="" src="./RTMP Player - HLSPlayer_files/beacon.js"></script>
	<script type="text/javascript" async="" src="./RTMP Player - HLSPlayer_files/ga.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
	<script>
		  $(window).ready(function (){		
		  	 var player = $("#player");
              player.height($(this).height()-10);
		  }); 
		  $(window).resize(function (){
             var player = $("#player");
              player.height($(this).height()-10);
          });
	</script>
	</head>
<body>
	
	<div class="container" >
	  <div class="row">								
		<div class="col-md-12">
			<div class="text-center">
				<div id="capa">
					<div id="player-container" class="player-container" style="background-color: black; width: 100%; height: 100%; position: relative;">
							<object type="application/x-shockwave-flash"
							 id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf">
							<param name="allowFullScreen" value="true">
							<param name="allowScriptAccess" value="always">
							
							<param name="flashvars" value="autoPlay=true&amp;src=<?php echo $streaming; ?>">
							</object>
							
					</div>	
				</div>
			</div>				
		</div>
	  </div>
	</div>
				
</body>
</html>
<?php
function nginx(){
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
        $query_stream=mysqli_query($con,"select c.inuse,cc.ipserver,c.dcamara, ss.server, ss.port, c.channelstreamserver 
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
//$fileconf="ftp://vloxy:123456@192.168.1.20/conf/nginx.conf";
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
//$cm2="ftp://vloxy:123456@192.168.1.20/reload_nginx.bat"; 
execInBackground($cmd2);
}  
?>