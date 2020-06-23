
<!DOCTYPE html>
<!-- saved from url=(0037)https://www.hlsplayer.net/rtmp-player -->
<html lang="en"><link rel="stylesheet" href="./RTMP Player - HLSPlayer_files/font-awesome.min.css">
<head>
<style>
		#player{
        width: 100%;	
       /* height: 600px;*/		
      }
</style>	
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
<title>Xtam</title>
<meta name="keywords" content="rtmp player, rtmp">
<meta name="description" content="This page allows you to play RTMP streams online with no installation required.">
<script async="" src="./RTMP Player - HLSPlayer_files/beacon.js"></script>
<script type="text/javascript" async="" src="./RTMP Player - HLSPlayer_files/ga.js"></script>
<script async="" src="./RTMP Player - HLSPlayer_files/cloudflare.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
<?php
error_reporting(0);
$ip=$_GET['ip'];
$cliente=$_GET['state'];
$userid=$_GET['userid'];
// Database Constants
include("../includes/connection.php");
$query =mysqli_query($con,"select descripcion,ipserver from centro_comercial cc inner join cameras c on c.id_centrocomercial=cc.id
where c.cameraid=".$ip);
$row=mysqli_fetch_assoc($query);
?>

</head>
<body>
	
	<ul class="list-group">
      
          <li class="list-group-item list-group-item-danger"><a href ="../admin/cameras"><?php echo $row['descripcion'];?></a></li>
          
        </ul>
	<div class="hp-body">
		<div id="player-section">
			<div class="container-fluid ">
				<div class="row"  style="padding-top: 20px;">
									
				<!-- columna   -->
					<div class="col-md-6">
						<div class="row" >
							<div id="capa" style="padding: 5px, 5px, 2px, 2px;">
								<div id="player-container" class="player-container" >
									<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf" 
									width="250" height="300" style="width: 98%;visibility: visible;">
										<param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always">
										<param name="wmode" value="opaque"><param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $row['ipserver']?>:1935/channel1&amp;streamType=live&amp;scaleMode=letterbox">
									</object>
									<div id="player-tip" style="display: none;"></div>
								</div>	
							</div>
						</div>

						<div class="row">
							<div id="capa" style="padding: 5px, 2px, 5px, 5px;">
								<div id="player-container" class="player-container" >
									<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf" 
									width="250" height="300" style="width: 98%;visibility: visible;"><param name="allowFullScreen" value="true">
									<param name="allowScriptAccess" value="always">
									<param name="wmode" value="opaque">
									<param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $row['ipserver']?>:1935/channel2&amp;streamType=live&amp;scaleMode=letterbox">
									</object>
									<div id="player-tip" style="display: none;"></div>
								</div>	
							</div>							
						</div>
					</div>
	  			<!-- end columna   -->

				<!-- columna   -->  
					<div class="col-md-6">
						<div class="row">
							<div id="capa" style="padding: 2px, 5px, 2px, 5px;">
								<div id="player-container" class="player-container" >
									<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf"  
									width="250" height="300" style="width: 98%;visibility: visible;">
									<param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always">
									<param name="wmode" value="opaque">
									<param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $row['ipserver']?>:1935/channel3&amp;streamType=live&amp;scaleMode=letterbox">
									</object>
									<div id="player-tip" style="display: none;"></div>
								</div>	
							</div>
						</div>

						<div class="row" >
							<div id="capa" style="padding: 2px, 2px, 5px, 5px;">
								<div id="player-container" class="player-container" >
									<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf" 
									width="250" height="300" style="width: 98%;visibility: visible;"><param name="allowFullScreen" value="true">
									<param name="allowScriptAccess" value="always">
									<param name="wmode" value="opaque"><param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $row['ipserver']?>:1935/channel4&amp;streamType=live&amp;scaleMode=letterbox">
									</object>
									<div id="player-tip" style="display: none;"></div>
								</div>	
							</div>						
						</div>
					</div>
				<!-- end columna   -->				
				</div>
				<!-- end Row big   -->
			</div>
		</div>
	</div>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="jquery-1.7.1.min.js"%3E%3C/script%3E'))</script>
	
<script src="./RTMP Player - HLSPlayer_files/jquery.min.js"></script>
<script src="./RTMP Player - HLSPlayer_files/bootstrap.min.js"></script>
<script src="./RTMP Player - HLSPlayer_files/swfobject.min.js"></script>
<script src="./RTMP Player - HLSPlayer_files/main.js"></script>


</body></html>