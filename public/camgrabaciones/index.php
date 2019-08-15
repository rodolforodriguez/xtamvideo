<link rel="stylesheet" href="video.css" media="all" />
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- <script src="camvideo.js"></script> -->


<!-- boostrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


<?php

//error_reporting(0);
if ($_GET) {
    $id = $_GET['id'];

    $con = mysqli_connect("18.217.79.142", "administrator", "0kOZh0B1GBskiRWg", "xtamdb") or die(mysql_error());
    mysqli_select_db($con, "xtamdb") or die("No hay conexion en la base de datos");

    $idcam = mysqli_query($con, "SELECT cameraid , idcamara , route , folder_record , ipserver
    FROM xtamdb.cameras
    inner join routerecord ON routerecord.idcamara = cameras.cameraid
    inner join centro_comercial ON centro_comercial.id = cameras.id_centrocomercial
    where cameras.cameraid =" . $id);
    $dato = mysqli_fetch_assoc($idcam);

    if ($dato === NULL) {
        ?>
<h3 style="text-align: center;">No se han encontrado grabaciones para esta cámara</h3>
<?php
    }
    //$url = $dato['route'];
    $ip = $dato['ipserver'];
    $rout = $dato['folder_record'];
    //$rout = substr($url, 31);
    $final = "http://" . $ip . "/listfolder/" . $rout . "/index.m3u8";
    ?>
<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('../images/cargando.gif') 50% 50% no-repeat rgb(249, 249, 249);
        opacity: .8;
    }
</style>
<div class="loader" id="loader"></div>
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="VideoCont row" id="videoCont">
                <video id="video"></video>
            </div>
        </div>
    </div>
    <div id="respuesta">

    </div>
    <div class="row">
        <div id="video-controls" class="controls">
            <button id="playpause" type="button" data-state="play">Play/Pause</button>
            <button id="stop" type="button" data-state="stop">Stop</button>
            <div class="progress">
                <progress id="progress" value="0" min="0">
                    <span id="progress-bar"></span>
                </progress>
            </div>
            <button id="mute" type="button" data-state="mute">Mute/Unmute</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Fecha inicial: </label>
                <input class="form-control" type="date" name="fechastart" id="fechastart" value="2019-08-15" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Hora inicial: </label>
                <input class="form-control" type="time" name="horastart" id="horastart" value="12:06" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Fecha final: </label>
                <input class="form-control" type="date" name="fechafinish" id="fechafinish" value="2019-08-15" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Hora final: </label>
                <input class="form-control" type="time" name="horafinish" id="horafinish" value="13:29" required>
            </div>
        </div>
    </div>
    <div style="text-align: right;">
        <button type="button" class="btn btn-warning btn-sm" onclick="SubmitFormData();">Buscar</button>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#export" onclick="selectvideos();">Exportar</button>
    </div>

</div>
<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
</script>

<script>
    if (Hls.isSupported()) {
        var video = document.getElementById('video');
        video.setAttribute("data-type", "video");
        video.setAttribute("value", '<?php echo $final; ?>');
        video.setAttribute('data-id', '<?php echo $id; ?>');
        video.addEventListener('play', function() {
            changeButtonState('playpause');
        }, false);
        video.addEventListener('pause', function() {
            changeButtonState('playpause');
        }, false);


        var hls = new Hls();
        hls.loadSource('<?php echo $final; ?>');
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function() {
            // video.play();
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = '<?php echo $final; ?>';
        video.addEventListener('canplay', function() {
            video.play();
        });
    }

    // Display the user defined video controls
    var videoControls = document.getElementById("video-controls");
    var stop = document.getElementById("stop");
    var mute = document.getElementById("mute");
    var progress = document.getElementById("progress");
    var progressBar = document.getElementById("progress-bar");
    videoControls.setAttribute("data-state", "visible");

    //funcionalidad de botones play pause mute
    var changeButtonState = function(type) {
        // Play/Pause button
        if (type == "playpause") {
            var videos = document.querySelectorAll('[data-type="video"]');
            for (var v = 0; v < videos.length; v++) {
                var video = videos[v];
                if (video.paused || video.ended) {
                    playpause.setAttribute("data-state", "play");
                } else {
                    playpause.setAttribute("data-state", "pause");
                }
                if (type == "mute") {
                    mute.setAttribute(
                        "data-state",
                        video.muted ? "unmute" : "mute"
                    );
                }
            }
        }
    };

    stop.addEventListener("click", function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            video.pause();
            video.currentTime = 0;
            progress.value = 0;
            // Update the play/pause button's 'data-state' which allows the correct button image to be set via CSS
            changeButtonState("playpause");
        }
    });

    mute.addEventListener("click", function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            video.muted = !video.muted;
            changeButtonState("mute");
        }
    });

    //navegador bloquea los elementos play pause
    playpause.addEventListener("click", function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            if (video.paused || video.ended) {
                video.play();
            } else {
                video.pause();
            }
            video.addEventListener("loadedmetadata", function() {
                progress.setAttribute("max", video.duration);
            });

            // As the video is playing, update the progress bar
            video.addEventListener("timeupdate", function() {
                // For mobile browsers, ensure that the progress element's max attribute is set
                if (!progress.getAttribute("max"))
                    progress.setAttribute("max", video.duration);
                progress.value = video.currentTime;
                progressBar.style.width =
                    Math.floor((video.currentTime / video.duration) * 100) + "%";
            });
        }
    });

    // React to the user clicking within the progress bar
    progress.addEventListener("click", function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            var pos = (e.pageX - this.offsetLeft) / this.offsetWidth;
            video.currentTime = pos * video.duration;
        }
    });

    // Búsqueda por filtros
    function SubmitFormData() {

        document.getElementById("loader").style = "";

        var videos = document.getElementById('video').value;
        var id = document.getElementById('video').getAttribute("data-id");
        var fechaI = document.getElementById('fechastart').value;
        var fechaF = document.getElementById('fechafinish').value;
        var horaI = document.getElementById('horastart').value;
        var horaF = document.getElementById('horafinish').value;
        var direccion = "http://192.168.2.7/xtamvideo/public/camgrabaciones/create_m3u8.blade.php";

        var xmlhttp;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("respuesta").innerHTML = this.responseText;
                document.getElementById("loader").style = "display: none;";
                //console.log('respuesta');
            }
        };
        xmlhttp.open("GET", direccion + '?id=' + id + '&startdate=' + fechaI + '&finishdate=' + fechaF + '&starttime=' + horaI + '&finishfime=' + horaF, true);
        xmlhttp.send();

        console.log(xmlhttp);
    }
</script>
<?php
} else {
    echo "No se ha encontrado el video seleccionado";
}

?>