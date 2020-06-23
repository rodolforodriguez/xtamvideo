<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
include "includes/connection.php";
?>
@extends('crudbooster::admin_template')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- <script src="camvideo.js"></script> -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<div class="loader" id="loader"></div>
<div class="box-body">
    <div class="row" style="margin-left: 0%;">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default" style="border-color: #000;">
                        <div class="panel-heading" style="background-color: #331e4bb8;">
                            <h3 class="panel-title" style="color: #ffffff;">Cámaras</h3>
                        </div>

                        <?php

                        //error_reporting(0);
                        if ($_GET) {
                            $id = $_GET['id'];

                            

                            $idcam = mysqli_query($con, "SELECT cameraid , idcamara , route , folder_record , ipserver
                                        FROM cameras
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
                            //$rout = $dato['route'];
                            //$rout = substr($url, 31);
                            $final = "http://" . $ip . "/listfolder/" . $rout . "/index.m3u8";
                             // $final = $rout."/index.m3u8";
                            ?>
                        <div class="VideoCont row" id="videoCont">
                            <video id="video" controls></video>
                        </div>
                        <div id="respuesta">
                        </div>
                        <div id="found">
                        </div>

                        <div class=" panel-footer" id="Controls">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-2">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-2">
                                    <div class="input-group date">
                                        <label class="control-label">Fecha inicial: </label>
                                        <input class="form-control" type="date" name="fechastart" id="fechastart" value="2019-08-15" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-6 col-lg-2">
                                    <div class="input-group date">
                                        <label class="control-label">Hora inicial: </label>
                                        <input class="form-control" type="time" name="horastart" id="horastart" value="12:06" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-2">
                                    <div class="input-group date">
                                        <label class="control-label">Fecha final: </label>
                                        <input class="form-control" type="date" name="fechafinish" id="fechafinish" value="2019-08-15" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-6 col-lg-2">
                                    <div class="input-group date">
                                        <label class="control-label">Hora final: </label>
                                        <input class="form-control" type="time" name="horafinish" id="horafinish" value="13:29" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
                                    <div class="input-group date">
                                        <label class="control-label"> &nbsp; </label>
                                        <button type="button" class="form-control" onclick="SubmitFormData();"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<script type="text/javascript">
    document.body.className = "skin-red sidebar-collapse";
    document.getElementById("loader").style = "";
    //document.body.className = "sidebar-toggle style='display: none;'";
</script>

<script>
    if (Hls.isSupported()) {
        document.getElementById("loader").style = "";
        var video = document.getElementById("video");
        video.setAttribute("data-type", "video");
        video.setAttribute("value", "<?php echo $final; ?>");
        video.setAttribute("data-id", "<?php echo $id; ?>");
        var hls = new Hls();
        hls.loadSource("<?php echo $final; ?>");
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function() {
            // video.play();
            document.getElementById("loader").style = "display: none;";
        });
    } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
        video.src = "<?php echo $final; ?>";
        video.addEventListener("canplay", function() {
            video.play();
        });
    }
    // Búsqueda por filtros
    function SubmitFormData() {
        document.getElementById("loader").style = "";

        var videos = document.getElementById("video").value;
        var id = document.getElementById("video").getAttribute("data-id");
        var fechaI = document.getElementById("fechastart").value;
        var fechaF = document.getElementById("fechafinish").value;
        var horaI = document.getElementById("horastart").value;
        var horaF = document.getElementById("horafinish").value;
        var direccion =
            "http://localhost/xtamvideo/resources/views/camgrabaciones/create_m3u8.blade.php";

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

                var respuesta = this.responseText;
                var contiene = respuesta.includes('No se han encontrado');
                if (contiene === true) {
                    document.getElementById("found").innerHTML = this.responseText;
                } else {
                    document.getElementById("respuesta").innerHTML = this.responseText;
                    var x = document.getElementById("temp");
                    if (x) {
                        document.getElementById("videoCont").style = "display: none;";
                        if (Hls.isSupported()) {
                            var y = new Hls();
                            y.loadSource(x.getAttribute("value"));
                            y.attachMedia(x);
                            y.on(Hls.Events.MANIFEST_PARSED, function() {});
                        }
                    }
                }

                document.getElementById("loader").style = "display: none;";
            }
        };
        xmlhttp.open(
            "GET",
            direccion +
            "?id=" +
            id +
            "&startdate=" +
            fechaI +
            "&finishdate=" +
            fechaF +
            "&starttime=" +
            horaI +
            "&finishfime=" +
            horaF,
            true
        );
        xmlhttp.send();
    }
</script>
<?php
} else {
    echo "No se ha encontrado el video seleccionado";
}
?>
@endsection