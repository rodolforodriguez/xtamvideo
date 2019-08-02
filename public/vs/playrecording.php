<?php
require_once("../includes/connection.php");
$id=$_GET['id'];
?>

<!DOCTYPE html>
<!-- saved from url=(0037)https://www.hlsplayer.net/rtmp-player -->
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-extend.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
<body>

	<div class="container" >
	  <div class="row">
			<?php
			/// consulta en base de datos de las camaras que estan al rededor
			if(!!$id){
			$radius =mysqli_query($con,"SELECT rr.route , idcamara from routerecord rr inner join cameras c on c.cameraid = rr.idcamara where cameraid in(".$id.");");
			$numradius=mysqli_num_rows($radius);
			if($numradius!=0)
			{
				while($rowrad=mysqli_fetch_assoc($radius)){
				$url = $rowrad['route'];
				$ID =  $rowrad['idcamara'];
                $ip = substr($url, 18, -8);
                $rout = substr($url, 31);
                $final = "http://" . $ip . "/listfolder/recording" . $rout . "/index.m3u8";
			?>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="text-center">
					<div id="capa">
						<div id="player-container" class="player-container" style="background-color: black; width: 100%; height: 100%; position: relative;">
                        <video id=<?php echo $ID ?> controls></video>
                                <script>
                                if(Hls.isSupported())
                                {
									var video = document.getElementById('<?php echo $ID ?>');
									video.setAttribute("width","100%");
									video.setAttribute("height","300px");
                                    var hls = new Hls();
                                    hls.loadSource('<?php echo $final; ?>');
                                    hls.attachMedia(video);
                                    hls.on(Hls.Events.MANIFEST_PARSED,function()
                                    {
                                      //  video.play();
                                    });
                                }
                                else if (video.canPlayType('application/vnd.apple.mpegurl'))
                                {
                                    video.src = '<?php echo $final; ?>';
                                    video.addEventListener('canplay',function()
                                    {
                                        //video.play();
                                    });
                                }
                                </script>

						</div>
					</div>
				</div>
				<hr>
			</div>
			<?php
				}// end while

			} // end if
			/// end de la consulta
			}else 
			{
				?>
					<div>
						<h4>No se ha seleccionado ninguna camará</h4>
					</div>
				<?php
			}
			?>
			<div class="clearfix"></div>

		</div>
	</div>

</body>
</html>

