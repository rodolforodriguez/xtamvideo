<?php
$video=$_GET['vid'];
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
                    <video src="<?php echo $video; ?>" autoplay controls></video>
							
					</div>	
				</div>
			</div>				
		</div>
	  </div>
	</div>
				
</body>
</html>
