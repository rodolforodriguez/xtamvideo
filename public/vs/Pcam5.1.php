<?php
$ip="localhost";
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
	<meta http-equiv="refresh" content="3000;url=../index.php"/>
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

	</head>
<body>
	
	
	<div class="hp-body">
		<div id="player-section">
			<div class="container-fluid ">
				<div class="row"  style="padding-top: 20px;">
									
				<!-- copiar aqui   -->
					<div class="col-md-6">
						<div class="row" >
														<div id="capa" style="padding: 5px, 5px, 2px, 2px;">
								<div id="player-container" class="player-container" >
							<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf" width="250" height="300" style="width: 98%;visibility: visible;"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $ip;?>:1935/channel1&amp;streamType=live&amp;scaleMode=letterbox"></object>
							<div id="player-tip" style="display: none;"></div>
												
						
				
        		</div>	
						</div>
						</div>
						<div class="row">
													<div id="capa" style="padding: 5px, 2px, 5px, 5px;">
								<div id="player-container" class="player-container" >
							<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf" width="250" height="300" style="width: 98%;visibility: visible;"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><param name="flashvars" value="autoPlay=true&amp;src=rtmp://<?php echo $ip;?>:1935/channel2&amp;streamType=live&amp;scaleMode=letterbox"></object>
							<div id="player-tip" style="display: none;"></div>
												
						
				
        		</div>	
						</div>							
						</div>
					</div>		
					<div class="col-md-6">
						<div class="row">
							<div id="capa" style="padding: 2px, 5px, 2px, 5px;">
								<div id="player-container" class="player-container" >
							<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf"  width="250" height="300" style="width: 98%;visibility: visible;"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><param name="flashvars" value="autoPlay=true&amp;src=rtsp://Admin:1234@192.168.1.200:554/h264_2&amp;streamType=live&amp;scaleMode=letterbox"></object>
							<div id="player-tip" style="display: none;"></div>
												
						
				
        		</div>	
						</div>
						</div>
						<div class="row" >
													<div id="capa" style="padding: 2px, 2px, 5px, 5px;">
								<div id="player-container" class="player-container" >
							<object type="application/x-shockwave-flash" id="player" data="./RTMP Player - HLSPlayer_files/GrindPlayer.swf" width="250" height="300" style="width: 98%;visibility: visible;"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><param name="flashvars" value="autoPlay=true&amp;src=rtsp://192.168.1.200:554/h264_2&amp;streamType=live&amp;scaleMode=letterbox"></object>
							<div id="player-tip" style="display: none;"></div>
												
							<video src="rtsp://Admin:1234@192.168.1.200:554/h264_2">
    Your browser does not support the VIDEO tag and/or RTP streams.
</video>	
				
        		</div>	
						</div>						
						</div>
					</div>			
				</div>
			</div>
		</div>
	</div>
	
	
</body>
</html>