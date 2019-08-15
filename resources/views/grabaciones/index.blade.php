<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
include "includes/connection.php";
?>
@extends('crudbooster::admin_template')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<div class="loader"></div>
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
        <span style="font-size: 20px;"> Grabaciones </span>
        <a href="{{CRUDBooster::adminPath()}}/maps" class="btn btn-sm btn-primary" title="Ver mapa">Ver mapa</a>
        <a href="{{CRUDBooster::adminPath()}}/cameras35" class="btn btn-sm btn-success" title="Búsqueda avanzada">Búsqueda avanzada</a>
    </div>
    <div class="box-body">
        <div class="row" style="margin-left: 0%;">
            <div class="col-md-3 col-xs-12 col-sm-12" style="position: sticky;">
                <div class="content">
                    <div class="sidenav" id="nav" style="min-height: 50vh;">
                        <div class="panel panel-default" style="border-color: #000;">
                            <div class="panel-heading" style="background-color: #c7c7c7;">
                                <h3 class="panel-title">Cámaras</h3>
                            </div>
                            <div class="panel-body" style="background-color: #efefef;">
                                <?php
                                foreach ($typecam as $type) {
                                    echo "<button class='dropdown-btn' style='background-color: #efefef;' > - " . $type->desc_cam . "<i class='fa fa-caret-down'></i> </button>";
                                    echo "<div class='dropdown-container' data-name='principal' style='background-color:#efefef;'>";
                                    $temp = '';
                                    foreach ($camaras as $camara) {
                                        if ($type->desc_cam == $camara->desc_cam) {
                                            if ($temp <> $camara->descripcion) {
                                                if ($temp <> '') {
                                                    echo "</div>";
                                                }
                                                $temp = $camara->descripcion;
                                                echo "<button class='dropdown-btn'  style='background-color: #efefef;'> * " . $camara->descripcion . "<i class='fa fa-caret-down'></i> </button>";
                                                echo "<div class='dropdown-container' style='background-color:#efefef;'>";
                                            }

                                            $ipserver = $camara->ipserver;
                                            $url = $camara->route;
                                            $carpeta = $camara->folder_record;


                                            $final = "http://" . $ipserver . "/listfolder/" . $carpeta . "/index.m3u8";
                                            echo "<a id='" . ($camara->cameraid) . "' href='#' value='" . ($final) . "' name='" . ($camara->descripcion . "-" . $camara->dcamara) . "' draggable='true' ondragstart='drag(event)' style='background-color:#efefef;'>" . $camara->dcamara . "</a>";
                                        }
                                    }
                                    if ($temp <> '') {
                                        echo "</div>";
                                    }
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default" style="border-color: #000;">
                            <div class="panel-heading" style="background-color: #c7c7c7;">
                                <h3 class="panel-title">Visualización de cámaras</h3>
                            </div>
                            <div class="VideoCont row" id="videoCont" ondrop="drop(event)" ondragover="allowDrop(event)" style="min-height: 50vh; ">

                            </div>
                            <div class=" panel-footer" id="Controls" style="min-height: 5vh; display: none;">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                        <div class="input-group date">
                                            <label class="control-label">Fecha inicial</label>
                                            <input type="date" class="form-control" name="fechastart" id="fechastart" value="2019-08-15" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
                                        <div class="input-group date">
                                            <label class="control-label">Hora inicial</label>
                                            <input type="time" class="form-control" name="horastart" id="horastart" value="12:06" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-0 col-lg-1">
                                        <div class="input-group date">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                        <div class="input-group date">
                                            <label class="control-label">Fecha final</label>
                                            <input type="date" class="form-control" name="fechafinish" id="fechafinish" value="2019-08-15" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
                                        <div class="input-group date">
                                            <label class="control-label">Hora final</label>
                                            <input type="time" class="form-control" name="horafinish" id="horafinish" value="13:29" required>
                                        </div>
                                    </div>
                                </div>
                                <hr>
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
                                <div class="row text-right">
                                    <div class="col-md-5 col-md-offset-7">
                                        <button type="button" class="btn btn-sm btn-warning" onclick="SubmitFormData();" style="width: 80px;">Buscar</button>
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
                        <!-- <div class="col-md-12">
                            <div class="input-group">
                                <input type="checkbox">
                                <label class="form-group"> Agregar fecha y hora</label>
                            </div>
                        </div>-->
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
@endsection