@extends('crudbooster::admin_template')
@section('content')
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
        <a href="http://xtamvideo.test/admin/maps" class="btn btn-sm btn-primary" title="Ver mapa">Ver mapa</a>
        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" title="Busqueda avanzada">Búsqueda avanzada</button>
    </div>
    <div class="box-body">
        <div class="col-md-3 col-xs-12 col-sm-12" style="position: sticky;">
            <div class="content">
                <div class="sidenav" id="nav" style="min-height: 50vh;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Camaras</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            foreach ($typecam as $type) {
                                echo "<button class='dropdown-btn'>" . $type->desc_cam . "<i class='fa fa-caret-down'></i> </button>";
                                echo "<div class='dropdown-container' data-name='principal'>";
                                $temp = '';
                                foreach ($camaras as $camara) {
                                    if ($type->desc_cam == $camara->desc_cam) {
                                        if ($temp <> $camara->descripcion) {
                                            if ($temp <> '') {
                                                echo "</div>";
                                            }
                                            $temp = $camara->descripcion;
                                            echo "<button class='dropdown-btn'>" . $camara->descripcion . "<i class='fa fa-caret-down'></i> </button>";
                                            echo "<div class='dropdown-container'>";
                                        }
                                        echo "<a id='" . ($camara->descripcion . "" . $camara->dcamara) . "' href='http://localhost/xtamvideo/resources/views/grabaciones/video.mp4' draggable='true' ondragstart='drag(event)'>" . $camara->dcamara . "</a>";
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Visualizacion de camaras</h3>
                        </div>
                        <div class="VideoCont row" id="videoCont" ondrop="drop(event)" ondragover="allowDrop(event)" style="min-height: 50vh; ">
                        </div>
                        <div class=" panel-footer" id="Controls" style="min-height: 5vh; display: none;">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                    <div class="input-group date">
                                        <label class="control-label">Fecha inicial</label>
                                        <input id="dateinitial" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hora inicial</label>
                                        <input type="time" id="timeinitial" class="form-control" name="timeinitial" required>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                    <div class="input-group date">
                                        <label class="control-label">Fecha final</label>
                                        <input id="dateinitial" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hora final</label>
                                        <input type="time" id="timeend" class="form-control" name="timeend" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="video-controls" class="controls" data-state="hidden">
                                        <button id="playpause" type="button" class="btn btn-lg btn-default" data-state="play">Play/Pause</button>
                                        <button id="stop" type="button" class="btn btn-lg btn-default" data-state="stop">Stop</button>
                                        <div class="progress">
                                            <progress id="progress" value="0" min="0">
                                                <span id="progress-bar"></span>
                                            </progress>
                                        </div>
                                        <button id="mute" type="button" class="btn btn-lg btn-default" data-state="mute">Mute/Unmute</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-right">
                                <div class="col-md-5 col-md-offset-7">
                                    <button class="btn btn-sm btn-warning">Ver</button>
                                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#export">Exportar</button>
                                    <button class="btn btn-sm btn-success">Actualizar</button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarElemento()">Borrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- popup search advanced -->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Filtro de búsqueda avanzada</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" name="x" placeholder="Palabra clave">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group" style="padding-top: 20px; padding-bottom: 20px;">
                                <label class="radio-inline control-label">
                                    <input type="radio" checked name="optradio">Todas las palabras
                                </label>
                                <label class="radio-inline control-label">
                                    <input type="radio" name="optradio">Cualquier palabra
                                </label>
                                <label class="radio-inline control-label">
                                    <input type="radio" name="optradio">Frase exacta
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">

                                <label type="text"> Nombre cámara </label>
                                <input type="text" class="form-control" name="x" placeholder="">

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">

                                <label type="text"> Tipo de cámara: </label>
                                <select class="form-control" type="text">
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">

                                <label type="text"> Tipo de cámara: </label>
                                <select class="form-control" type="text">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-sm btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" class=" btn btn-sm btn-danger" onclick="limpiaCampo()" data-dismiss="modal">Borrar</button>
                <button type="button" class=" btn btn-sm btn-success" onclick="redirect()" data-dismiss="modal">Consultar</button>
            </div>
        </div>
    </div>
</div>

<!-- popup video export  -->
<!-- Modal -->
<div class="modal fade" id="export" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Exportar video</h4>
            </div>

            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" onchange="checkformat(this.checked);" id="check">
                                <label class="form-group"> Cambiar formato de video</label>
                                <select id="id_select" class="form-control" type="text" disabled>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" onchange="checkname(this.checked);">
                                <label class="form-group"> Cambiar nombre</label>
                                <input id="chkname" type="text" class="form-control" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="checkbox">
                                <label class="form-group"> Agregar fecha y hora</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class=" btn btn-sm btn-success" data-dismiss="modal">Generar</button>
            </div>
        </div>
    </div>
</div>
@endsection