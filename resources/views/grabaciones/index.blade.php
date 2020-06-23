<?php
//error_reporting(0);
header("Access-Control-Allow-Origin: *");
include "includes/connection.php";
?>
@extends('crudbooster::admin_template')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<div id="loader" class="loader"></div>
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
<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
</script>

<?php
$userid = CRUDBooster::myId();
if ($userid === null) {
    ?>
<script>
    window.location.replace("../../admin/login");
</script>
<?php
}
?>
<div class="box">
    <div class="box-header">
        <div class="row">
            <div class="col-md-9">
                <span style="font-size: 20px;"> Grabaciones </span>
            </div>
            <div class="col-md-3">
                <a href="{{CRUDBooster::adminPath()}}/maps" class="btn btn-sm btn-primary" title="Ver mapa">Ver mapa</a>
                <a href="{{CRUDBooster::adminPath()}}/cameras35" class="btn btn-sm btn-success" title="Búsqueda avanzada">Búsqueda avanzada</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row" style="margin-left: 0%;">
            <div class="col-md-3 col-xs-12 col-sm-12" style="position: sticky;">
                <section class="sidebar" id="nav" style="background-color: #1e282c;">
                    <ul class=" sidebar-menu tree" data-widget="tree">
                        <li class="header" style="color: #ffffff; background-color: #241338;">Cámaras</li>
                        <li class="treeview menu-open">
                            <?php
                            foreach ($typecam as $type) {
                                echo "<a href='#'>";
                                echo "<i class='fa fa-share'></i>";
                                echo "<span>" . $type->desc_cam . "</span>";
                                echo "<span class='pull-right-container'>";
                                echo "<i class='fa fa-angle-left pull-right'>";
                                echo "</i>";
                                echo "</span>";
                                echo "</a>";
                                $temp = '';
                                foreach ($camaras as $camara) {
                                    if ($type->desc_cam == $camara->desc_cam) {
                                        if ($temp <> $camara->descripcion) { 
                                            if ($temp <> '') {
                                                echo "</div>";
                                            }
                                            $temp = $camara->descripcion;
                                            echo "<ul class='treeview-menu'>";
                                            echo "<li class='treeview'>";
                                            echo "<a href='#'>";
                                            echo "<i class='fa fa-circle-o'></i> " . $camara->descripcion . "<span class='pull-right-container'>";
                                            echo "<i class='fa fa-angle-left pull-right'>";
                                            echo "</i>";
                                            echo "</span>";
                                            echo "</a>";
                                        }
                                        $ipserver = $camara->ipserver;
                                        $url = $camara->route;
                                        $carpeta = $camara->folder_record;
                                        $final = "http://" . $ipserver . "/listfolder/" . $carpeta . "/index.m3u8";
                                        echo "<ul class='treeview-menu'>";
                                        echo "<li class='treeview'>";
                                        echo "<a href='#' data_route='" . ($camara->route) . "/index.m3u8'  id='" . ($camara->cameraid) . "' name='" . ($camara->descripcion . "-" . $camara->dcamara) . "' value='" . ($final) . "' draggable='true' ondragstart='drag(event)'  ><i class='fa fa-circle-o'></i>" . $camara->dcamara;
                                        echo "<span class='pull-right-container'>";
                                        echo "<i class='fa fa-angle-left pull-right'></i>";
                                        echo "</span>";
                                        echo "</a>";
                                        echo "</li>";
                                        echo "</ul>";
                                    }
                                }
                                if ($temp <> '') {
                                    echo "</ul>";
                                    echo "</a>";
                                }
                                echo "</a>";
                            }
                            ?>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default" style="border-color: #000;">
                            <div class="panel-heading" style="background-color: #241338;">
                                <h3 class="panel-title" style="color: #ffffff;">Visualización de cámaras</h3>
                            </div>
                            <div class="VideoCont row" id="videoCont" ondrop="drop(event)" ondragover="allowDrop(event)" style="min-height: 50vh; ">

                            </div>
                            <div class="panel-footer" id="Controls" style="min-height: 5vh; display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="video-controls" class="controls" data-state="hidden">
                                            <button id="playpause" type="button" class="btn btn-lg btn-default" data-state="play" title="Play/Pause">Play/Pause</button>
                                            <button id="stop" type="button" class="btn btn-lg btn-default" data-state="stop" title="Detener">Stop</button>
                                            <div class="progress">
                                                <progress id="progress" value="0" min="0">
                                                    <span id="progress-bar"></span>
                                                </progress>
                                            </div>
                                            <button id="mute" type="button" class="btn btn-lg btn-default" data-state="mute" title="Silenciar">Mute/Unmute</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                        <div class="input-group date">
                                            <label class="control-label">Fecha inicial</label>
                                            <input type="date" class="form-control" name="fechastart" id="fechastart" value="2019-11-25" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
                                        <div class="input-group date">
                                            <label class="control-label">Hora inicial</label>
                                            <input type="time" class="form-control" name="horastart" id="horastart" value="02:06" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                        <div class="input-group date">
                                            <label class="control-label">Fecha final</label>
                                            <input type="date" class="form-control" name="fechafinish" id="fechafinish" value="2019-11-25" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
                                        <div class="input-group date">
                                            <label class="control-label">Hora final</label>
                                            <input type="time" class="form-control" name="horafinish" id="horafinish" value="20:29" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
                                        <div class="input-group date">
                                            <label class="control-label"> &nbsp; </label>
                                            <button type="button" class="form-control" onclick="SubmitFormData();"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-right">
                                    <div class="col-md-5 col-md-offset-7">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#export" onclick="selectvideos();" style="width: 80px;">Exportar</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarElemento()" style="width: 80px;">Borrar</button>
                                        <div class="loader"></div>
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
<!-- Modal video export  -->
<div class="modal fade" id="export" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Exportar video</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-group"> Seleccionar video </label>
                                <select id="camid" class="form-control" type="text" onchange="changename(this)" required>
                                    <option value="0">seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-group">Formato de video</label>
                                <select id="formcam" class="form-control" type="text" required>
                                    <option value="1">mp4</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-group">Cambiar nombre</label>
                                <input id="chkname" type="text" class="form-control">
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                    <input type="submit" id="boton" value="Generar" class=" btn btn-sm btn-success" data-dismiss="modal" onclick="descargas()">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Búsqueda por filtros
    function SubmitFormData() {

        document.getElementById("loader").style = "";

        var videos = document.querySelectorAll('[data-type="video"]');
        var ids = [];
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            ids.push(video.id);
        }

        var fechastart = $("#fechastart").val();
        var fechafinish = $("#fechafinish").val();
        var horastart = $("#horastart").val();
        var horafinish = $("#horafinish").val();
        var array = ids;
        var URLdomain = window.location.host;
        $.get(
            "http://" +
            URLdomain +
            "/xtamvideo/resources/views/grabaciones/create_m3u8.blade.php", {
                startdate: fechastart,
                finishdate: fechafinish,
                starttime: horastart,
                finishfime: horafinish,
                array: array
            },
            function(data) {
                $("#videoCont").html(data);
                document.getElementById("loader").style = "display: none;";
                //$('#myForm')[0].reset();
            }
        );
    }
</script>
@endsection