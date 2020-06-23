<?php
//error_reporting(0);
header("Access-Control-Allow-Origin: *");
require_once($_SERVER['DOCUMENT_ROOT'].'/xtamvideo/public/includes/connection.php');
?>
<script>
    var videos = document.querySelectorAll('[data-type="video"]');
    var ids = [];
    for (var v = 0; v < videos.length; v++) {
        var video = videos[v];
        ids.push(video.id);
    }
</script>
<?php
//// END DE LA CONEXION Y QUERYS
if ($_GET) {
   
    $startdate = $_GET['startdate'];
    $finishdate = $_GET['finishdate'];
    $starttime = $_GET['starttime'];
    $finishtime = $_GET['finishfime'];
    $array = $_GET['array'];
    
    if (count($array) > 0) {
        foreach ($array as $campo => $valor) {
            

            $querynginx = mysqli_query($con, "SELECT filename,format(timediff(timefinish,timestart),4) as timeduration, rt.route 
                                            from recordings as r
                                            inner join cameras as c on r.idCamara =  c.cameraid
                                            inner join routerecord as rt on rt.idcamara = c.cameraid
                                            where r.idcamara=" . $valor . " and (datetimestart between '$startdate $starttime'
                                                and '$finishdate $finishtime')
                                                order by datestart asc,timestart;");

            $numrowsnginx = mysqli_num_rows($querynginx);

            if ($numrowsnginx != 0) {

                $video_cam[] = $valor;
                $texto = "#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:5
#EXT-X-MEDIA-SEQUENCE:65
";
                while ($rownginx = mysqli_fetch_assoc($querynginx)) {
                    $texto .= "#EXTINF:" . $rownginx['timeduration'] . ",
" . $rownginx['filename'] . "
";
                    $route = $rownginx['route'];
                }
                $texto .= "#EXT-X-ENDLIST";
                //$fileconf="C:/laragon/www/listfolder/camara".$valor."/temp.m3u8";
                unlink($route . "/temp.m3u8");
                $fileconf = $route . "/temp.m3u8";
                $fh = fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
                fwrite($fh, $texto) or die("No se puede escribir en el archivo");
                fclose($fh);
            }
        }
    }
    
    if ($numrowsnginx != 0) {
        sleep(3);
        $array_cam = serialize($video_cam);
        $arraycam = unserialize(stripslashes($array_cam));

        if (count($arraycam) > 0) {
            // mostramos los valores del array
            foreach ($arraycam as $col => $cont) {
                

                $queryroute = mysqli_query($con, "SELECT route , cc.descripcion , c.dcamara , folder_record , ipserver from routerecord re inner join cameras c on c.cameraid = re.idcamara and c.cameraid=" . $cont . " inner join centro_comercial cc on cc.id = c.id_centrocomercial");
                                                 
                $rowroute = mysqli_fetch_assoc($queryroute);
                $url = $rowroute['route'];
                $cc = $rowroute['descripcion'];
                $cam = $rowroute['dcamara'];
                //$ip = substr($url, 18, -8);
                $ip = $rowroute['ipserver'];
                //$rout = substr($url, 31);
                $rout = $rowroute['folder_record'];
                $final = "http://" . $ip . "/listfolder/" . $rout . "/temp.m3u8";
                $ftp = $rowroute['route']. "/temp.m3u8";
                $a = $cc . $cam;
                $nombre = $a;
                ?>
    <script>
        if (Hls.isSupported()) {
            var txt = '<?php echo $nombre; ?>';
            txt = txt.replace(/ /g, "");
            var x = document.getElementById(<?php echo $cont; ?>);
            var y = new Hls();
            //x.setAttribute("id", $cont);
            y.loadSource('<?php echo $final; ?>');
            x.setAttribute("data-type", "video");
            x.setAttribute("value", '<?php echo $final; ?>');
            x.setAttribute("prop", '<?php echo $ftp; ?>');
            //x.setAttribute("style", "width: 37%");
            x.setAttribute("controls", "");
            x.setAttribute("name", txt);
            x.setAttribute("ondragover", "noAllowDrop(event)");
            y.attachMedia(x);
            y.on(Hls.Events.MANIFEST_PARSED, function() {

            });
            x.addEventListener('loadedmetadata', function() {
                progress.setAttribute('max', x.duration);
            });

            // As the video is playing, update the progress bar
            x.addEventListener('timeupdate', function() {
                // For mobile browsers, ensure that the progress element's max attribute is set
                if (!progress.getAttribute('max')) progress.setAttribute('max', x.duration);
                progress.value = x.currentTime;
                progressBar.style.width = Math.floor((x.currentTime / x.duration) * 100) + '%';
            });
            var divs = document.getElementsByTagName("VIDEO").length;
            if (divs <= 1) {
                x.setAttribute("style", "width: 80%");
            } else if (divs > 1) {
                var videos = document.querySelectorAll("video");
                for (var v = 0; v < videos.length; v++) {
                    console.log(v);
                    document
                        .getElementsByTagName("video")[0]
                        .setAttribute("style", "width: 43%");
                    x.setAttribute("style", "width: 43%");
                }
            }
        }
    </script>
<video id=<?php echo $cont; ?> data-type="video" class="video-js vjs-default-skin col-md-3">
</video>
<?php
            }
        }
    } else {
        ?>

<div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Información</h3>
            </div>
            <div class="modal-body">
                <h4>No se han encontrado los filtros de búsqueda seleccionados.</h4>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#mostrarmodal").modal("show");
    });
</script>

<?php
        $startdate = $_GET['startdate'];
        $finishdate = $_GET['finishdate'];
        $starttime = $_GET['starttime'];
        $finishtime = $_GET['finishfime'];
        $array = $_GET['array'];

        if (count($array) > 0) {

            // mostramos los valores del array
            foreach ($array as $col => $cont) {
                
                $queryroute = mysqli_query($con, "SELECT re.route , cc.descripcion , c.dcamara ,folder_record , ipserver from routerecord re inner join cameras c on c.cameraid = re.idcamara and c.cameraid=" . $cont . " inner join centro_comercial cc on cc.id = c.id_centrocomercial");
                
                $rowroute = mysqli_fetch_assoc($queryroute);

                $url = $rowroute['route'];
                $cc = $rowroute['descripcion'];
                $cam = $rowroute['dcamara'];
                //$ip = substr($url, 18, -8);
                //$rout = substr($url, 31);
                $ip = $rowroute['ipserver'];
                $rout = $rowroute['folder_record'];
                $ftp = $rowroute['route']. "/temp.m3u8";
                $final = "http://" . $ip . "/listfolder/" . $rout . "/index.m3u8";
                $a = $cc . $cam;
                $nombre = $a;
                ?>
<script>
    if (Hls.isSupported()) {
        var txt = '<?php echo $nombre; ?>';
        txt = txt.replace(/ /g, "");
        var x = document.getElementById(<?php echo $cont; ?>);
        var y = new Hls();
        //x.setAttribute("id", $cont);
        y.loadSource('<?php echo $final; ?>');
        x.setAttribute("data-type", "video");
        x.setAttribute("value", '<?php echo $final; ?>');
        x.setAttribute("prop", '<?php echo $ftp; ?>');
        //x.setAttribute("style", "width : 37%");
        x.setAttribute("name", txt);
        x.setAttribute("controls", "");
        x.setAttribute("ondragover", "noAllowDrop(event)");
        y.attachMedia(x);
        y.on(Hls.Events.MANIFEST_PARSED, function() {
l
        });
        x.addEventListener('loadedmetadata', function() {
            progress.setAttribute('max', x.duration);
        });

        // As the video is playing, update the progress bar
        x.addEventListener('timeupdate', function() {
            // For mobile browsers, ensure that the progress element's max attribute is set
            if (!progress.getAttribute('max')) progress.setAttribute('max', x.duration);
            progress.value = x.currentTime;
            progressBar.style.width = Math.floor((x.currentTime / x.duration) * 100) + '%';
        });

        var divs = document.getElementsByTagName("VIDEO").length;
        if (divs <= 1) {
            x.setAttribute("style", "width: 80%");
        } else if (divs > 1) {
            var videos = document.querySelectorAll("video");
            for (var v = 0; v < videos.length; v++) {
                console.log(v);
                document
                    .getElementsByTagName("video")[0]
                    .setAttribute("style", "width: 43%");
                x.setAttribute("style", "width: 43%");
            }
        }
    }
</script>
<video id=<?php echo $cont; ?> data-type="video" class="video-js vjs-default-skin col-md-3">
</video>
<?php
            }
        }
    }
}
?>