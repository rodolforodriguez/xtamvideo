<?php
require_once("../includes/connection.php");
$lng=$_GET['lng'];
$lat=$_GET['lat'];
$distance=1;
?>

<!DOCTYPE html>
<!-- saved from url=(0037)https://www.hlsplayer.net/rtmp-player -->
<html lang="en">
<head>
	<style>
		#player{
        width: 100%;	
       height: 300px;
      }
	</style>	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="refresh" content="300;url=../index.php"/>
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
	<title>Xtam</title>
	<meta name="keywords" content="rtmp player, rtmp">
	<meta name="description" content="This page allows you to play RTMP streams online with no installation required.">
	<script async="" src="./RTMP Player - HLSPlayer_files/beacon.js"></script>
	<script type="text/javascript" async="" src="./RTMP Player - HLSPlayer_files/ga.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-extend.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
	
	</head>
<body>
	
	<div class="container" >
	  <div class="row">
			<?php
			/// consulta en base de datos de las camaras que estan al rededor
			
			$radius =mysqli_query($con,"SELECT latitud,longitud,ipserver,dcamara, 
							( 6371 * acos(cos(radians(".$lat.")) * cos(radians(latitud)) * cos(radians(longitud)
							- radians(".$lng.")) + sin(radians(".$lat.")) * sin(radians(latitud)))) AS distance
							FROM cameras inner join centro_comercial cc on cc.id= cameras.id_centrocomercial HAVING distance < ".($distance/10)." ORDER BY distance;");
		
			$numradius=mysqli_num_rows($radius);
			if($numradius!=0)
			{
				while($rowrad=mysqli_fetch_assoc($radius)){
					$ip=$rowrad['ipserver'];
					$channel=$rowrad['dcamara'];
			?>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="text-center">
					<div id="capa">
						<div id="player-container" class="player-container" style="background-color: black; width: 100%; height: 100%; position: relative;">
								<object type="application/x-shockwave-flash"
								id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf">
								<param name="allowFullScreen" value="true">
								<param name="allowScriptAccess" value="always">
								
								<param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $ip;?>:1935/<?php echo $channel;?>">
								</object>
								
						</div>	
					</div>
				</div>
				<hr></hr>				
			</div>
			<?php
				}// end while
				
			} // end if
			/// end de la consulta
			?>
			<div class="clearfix"></div>
		
		</div>
	</div>
				
</body>
</html>

