@extends('crudbooster::admin_template')
@section('content')

<?php
$userid=CRUDBooster::myId();
//echo "usuario".$userid;
$ip=$_GET['ip'];
$cliente=$_GET['cliente'];
// Database Constants
include"includes/connection.php";
$queryng =mysqli_query($con,"select * from cameras c inner join streamserver ss
on c.id_streamserver = ss.id inner join centro_comercial cc on cc.id=c.id_centrocomercial 
where ipserver='".$ip."';");

$queryng2 =mysqli_query($con,"select * from cameras c inner join streamserver ss
on c.id_streamserver = ss.id inner join centro_comercial cc on cc.id=c.id_centrocomercial 
where ipserver='".$ip."';");
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
	
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
	<title>Vloxy Security</title>
	<meta name="keywords" content="rtmp player, rtmp">
	<meta name="description" content="This page allows you to play RTMP streams online with no installation required.">
	<script async="" src="../RTMP Player - HLSPlayer_files/beacon.js"></script>
	<script type="text/javascript" async="" src="../RTMP Player - HLSPlayer_files/ga.js"></script>
	<script type="text/javascript">
	function popinfo(){
		var cam=<?php echo $userid; ?>;
      var r = confirm("Estas seguro de cerrar las cámaras?");
        if (r == true) {
          //if(cliente==0){
          camonly(cam);
          //}
        
        }
	}
	function camonly(ip) {
         
		 userid=ip;
		 
		 if (window.XMLHttpRequest) {
			 // code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp = new XMLHttpRequest();
		 } else {
			 // code for IE6, IE5
			 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		 }
		 xmlhttp.onreadystatechange = function() {
			 if (this.readyState == 4 && this.status == 200) {
				 //document.getElementById("txtHint").innerHTML = this.responseText;
			 }
		 };
		 xmlhttp.open("GET", "../nginxoff/camonly.php?userid=" + userid, true);
		 xmlhttp.send();

	 }
	</script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">

	</head>
<body>
<form>
<input type="button" onclick="popinfo()" value="Salir">
</form>


	
	<div class="hp-body">
		<div id="player-section">
			<div class="container-fluid ">
				<div class="row"  style="padding-top: 20px;">
									
				<!-- copiar aqui   -->
				
					<div class="row">
					<?php
					//$numrows=mysqli_num_rows($query);
					while($row=mysqli_fetch_assoc($queryng)){
						if($cliente==0){
							
							$query =mysqli_query($con,"update cameras set inuse=1 where cameraid=".$row['cameraid']);
							$queryinsert=mysqli_query($con,"insert into logchannelinuse(idcameras,iduser,inuse)values('".$row['cameraid']."','".CRUDBooster::myId()."','1')");
							   
						}	
					}
						nginx();
						
						while($row2=mysqli_fetch_assoc($queryng2)){
							
							if($cliente==0){
							$streaming="rtmp://".$row2['server'].":".$row2['port']."/".$row2['channelstreamserver'];
							
							}else{
							$streaming="rtmp://".$row2['ipserver'].":1935/".$row2['dcamara']; 
							}
					?>
						<div class="col-md-6" >
							<div id="capa" style="padding: 5px, 5px, 2px, 2px;">
							<div id="player-container" class="player-container" >
						<object type="application/x-shockwave-flash" id="player" data="../RTMP Player - HLSPlayer_files/GrindPlayer.swf" width="250" height="300" style="width: 98%;visibility: visible;">
							<param name="allowFullScreen" value="true">
							<param name="allowScriptAccess" value="always">
							<param name="wmode" value="opaque">
							<param name="flashvars" value="autoPlay=true&amp;src=<?php echo $streaming; ?>">
						</object>
							<div id="player-tip" style="display: none;"></div>
												
						
				
        		</div>	
						</div>
						</div>	<!-- end col-->	
						<?php } ?>
					</div>	<!-- end row-->	
					
				</div>
			</div>
		</div>
	</div>
	
	
</body>
</html>
<?php
function nginx(){
    include("includes/connection.php");
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
execInBackground($cmd2);
}
  
?>
 


@endsection