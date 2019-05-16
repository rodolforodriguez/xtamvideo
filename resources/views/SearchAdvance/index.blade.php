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
@extends('crudbooster::admin_template')
@section('content')

<style>
    /* Fixed sidenav, full height */
    .sidenav {
        height: 100%;
        width: 100%;
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow-x: hidden;
    }

    /* Style the sidenav links and the dropdown button */
    .sidenav a,
    .dropdown-btn {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
        border: none;
        background: #fff;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
    }

    /* On mouse-over */
    .sidenav a:hover,
    .dropdown-btn:hover {
        color: #afadad;
    }

    /* Main content */
    .main {
        margin-left: 200px;
        /* Same as the width of the sidenav */
        font-size: 20px;
        /* Increased text to enable scrolling */
        padding: 0px 10px;
    }

    /* Add an active class to the active dropdown button */
    .active {
        background-color: #ecf0f5;
        color: #000;
    }

    /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
    .dropdown-container {
        display: none;
        background-color: #fff;
        padding-left: 8px;
    }

    /* Optional: Style the caret down icon */
    .fa-caret-down {
        float: right;
        padding-right: 8px;
    }

    /* Some media queries for responsiveness */
    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 5px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }
</style>
<!-- estilos de popup -->

<div class="box">
    <div class="box-header">
        <span style="font-size: 20px;"> Grabaciones </span>
        <a href="http://xtamvideo.test/admin/maps" class="btn btn-sm btn-primary" title="Ver mapa">Ver mapa</a>
        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" title="Busqueda avanzada">Búsqueda avanzada</button>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Búsqueda avanzada</h3>
                        </div>
                        <div class="panel-body" id="videoCont" style="min-height: 40vh; " ondrop="drop(event)" ondragover="allowDrop(event)">
                            <div class="container">
                                <div class="row">
                                    <form class="navbar-form navbar-left">
                                        <div class="form-group"> <input class="form-control" placeholder="Search"> </div>
                                        <button type="submit" class="btn btn-success">Buscar</button>
                                    </form>
                                </div>
                                <hr>
                                <div class="row">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">C.Comercial</th>
                                                <th scope="col">Dirección</th>
                                                <th scope="col">Longitud</th>
                                                <th scope="col">Latitud</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Ip Server</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Ver cámara</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                            </tr>                                        
                                        </tbody>
                                    </table>

                                </div>
                                <hr>
                                <div class="row" style="text-align: right;" >
                                    <button class="btn btn-sm btn-primary">Ver cámaras</button>
                                </div>
                            </div>
                        </div>
                        <div class=" panel-footer" id="Controls" style="min-height: 5vh; display: none;">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Desde</label>
                                        <input id="date" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hora</label>
                                        <input type="time" id="appt" class="form-control" name="appt" min="9:00" max="18:00" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hasta</label>
                                        <input id="date" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hora</label>
                                        <input type="time" id="appt" class="form-control" name="appt" min="9:00" max="18:00" required>
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
                                            <progress class="progress-bar progress-bar-striped bg-success" style="height: 10px;" id="progress" value="20" min="0" max="100 ">
                                                <span id="progress-bar"></span>
                                            </progress>
                                        </div>
                                        <button id="mute" type="button" class="btn btn-lg btn-default" data-state="mute">Mute/Unmute</button>
                                        <button id="volinc" type="button" class="btn btn-lg btn-default" data-state="volup">Vol+</button>
                                        <button id="voldec" type="button" class="btn btn-lg btn-default" data-state="voldown">Vol-</button>
                                        <button id="fs" type="button" class="btn btn-lg btn-default" data-state="go-fullscreen">Fullscreen</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-right">
                                <div class="col-md-5 col-md-offset-7">
                                    <button class="btn btn-sm btn-warning">Ver</button>
                                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#export">Exportar</button>
                                    <button class="btn btn-sm btn-success">Actualizar</button>
                                    <button class="btn btn-sm btn-danger">Borrar</button>
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
                <button type="button" class=" btn btn-sm btn-danger" data-dismiss="modal">Borrar</button>
                <button type="button" class=" btn btn-sm btn-success" onclick="redirect()" data-dismiss="modal">Consultar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function redirect() {
        window.location.replace("../../admin/searchadvanced");
    }
</script>

<script>
    // sidevar collapsed
    document.body.className = "skin-red sidebar-collapse";
    // sidevar collapsed
</script>


<!-- sidebar -->
<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
@endsection