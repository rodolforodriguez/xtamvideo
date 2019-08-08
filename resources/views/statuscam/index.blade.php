<?php
include "includes/connection.php";
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

<div class="box">
    <div class="box-header">
        <span style="font-size: 20px;"> Estado de cámaras </span>
        <!-- <a href="{{CRUDBooster::adminPath()}}/maps" class="btn btn-sm btn-primary" title="Ver mapa">Ver mapa</a>
        <a href="{{CRUDBooster::adminPath()}}/cameras35" class="btn btn-sm btn-success" title="Búsqueda avanzada">Búsqueda avanzada</a>
       -->
    </div>
    <div class="box-body">
        <div Class="row">
            <form method="GET" name="camid" value="camid" action="">
                <div class="col-md-3 col-xs-4 col-sm-4">
                    <label id="ccname"> Centro comercial </label>
             

                </div>
                <div class="col-md-3 col-xs-4 col-sm-4">
                    <select name="cam" id="cam">
                        <option value="">Selecciónar:</option>
                        <option value="todos">Todos</option>
                        <?php
                        foreach ($centro_comercial as $ccomer) {
                            echo "<option value='" . ($ccomer->id) . "'>" . ($ccomer->descripcion) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 col-xs-4 col-sm-4">
                    <input class="btn btn-sm btn-primary" type="submit" value="Realizar test">
                </div>
            </form>
            <hr>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">

                <?php

                if ($_GET) {

                    function inactivecam($id)
                    {
                        include "includes/connection.php";
                        $querycam = mysqli_query($con, "SELECT cameraid,ipcam FROM cameras where id_centrocomercial=" . $id);
                        while ($rowcam = mysqli_fetch_assoc($querycam)) {
                            $sqlcam = "UPDATE cameras SET estado='inactive' WHERE cameraid=" . $rowcam['cameraid'];
                            mysqli_query($con, $sqlcam);
                        }
                    }
                    function camaras($idcc)
                    {
                        include "includes/connection.php";
                        // Check connection
                        if (mysqli_connect_errno()) {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }
                        $consulta = mysqli_query($con, "SELECT id,iptunelgre FROM centro_comercial where id=" . $idcc);
                        // $iptuelGre = mysqli_query("SELECT ");
                        echo '<br>';
                        echo '<label>conexión camaras</label>';
                        echo '<div id=ipcam></div>';
                        //espacio para las ip de las camaras.
                        $ip = mysqli_fetch_assoc($consulta);
                        $ipcam = $ip['iptunelgre'];
                        $url = "http://" . $ipcam . "/statecam/index.php?id=" . $idcc;

                        ?>

                        <script>
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
                                    document.getElementById("ipcam").innerHTML = this.responseText;
                                   
                                }
                            };
                            xmlhttp.open("GET", '<?php echo $url ?>', true);
                            xmlhttp.send();
                        </script>
                    <?php
                    }
                

                    if (isset($_GET["cam"]) && $_GET["cam"] == "todos") {
                        $consulta = mysqli_query($con, "SELECT id,descripcion,iptunelgre,ipsimcard,ipserver FROM centro_comercial;");
                    } else {
                        //DB_SERVER,DB_USER, DB_PASS,DB_NAME
                        $consulta = mysqli_query($con, "SELECT id,descripcion,iptunelgre,ipsimcard,ipserver FROM centro_comercial where id = " . $_GET["cam"] . ";");
                    }

                    $max_count = 10; //numero maximo de pings 
                    $unix      =  0; //si tu host donde vas a alojar este script es unix pon esto en 1 (la mayoria usa unix)
                    $windows   =  1; //si tu host donde vas a alojar este script es windows pon esto en 1 y en 0 la variable $unix

                    $register_globals = (bool) ini_get('register_gobals');
                    $system = ini_get('system');
                    $unix = (bool) $unix;
                    $win  = (bool)  $windows;
                    while ($row = mysqli_fetch_assoc($consulta)) {


                        $count  = 1;
                        $host   = $row['ipserver'];
                        $host = preg_replace("/[^A-Za-z0-9.-]/", "", $host);
                        $count = preg_replace("/[^0-9]/", "", $count);
                      

                        if ($unix) {
                            echo '<br>';
                            echo '<h3>Centro comercial '.$row['descripcion'].'</h3>';
                            echo '<label>Conexion Sitio Central</label>';
                            echo '<br>';
                            system("ping -c$count -w$count $host");
                            system("killall ping");
                            echo '<br>';
                        } else {
                            echo '<br>';
                            echo '<h3>Centro comercial '.$row['descripcion'].'</h3>';
                            echo '<label>Conexion Sitio Central</label>';
                            echo '<br>';
                            $result = trim(system("ping -n $count $host"));
                            echo '<br>';
                        }
                        // echo '</pre>';

                        if (($result != "vuelva a intentarlo.") && ($result != "(100% perdidos),")) {
                            $count  = 1;
                            $host   = $row['ipsimcard'];
                            $host = preg_replace("/[^A-Za-z0-9.-]/", "", $host);
                            $count = preg_replace("/[^0-9]/", "", $count);
                            /* echo '<body bgcolor="#FFFFFF" text="#000000"></body>';
                            echo("Ping Output:<br>");
                            echo '<pre>';    */

                            if ($unix) {
                                echo '<br>';
                                echo '<label>Conexion SimCard</label>';
                                echo '<br>';
                                system("ping -c$count -w$count $host");
                                system("killall ping");
                                echo '<br>';
                            } else {
                                echo '<br>';
                                echo '<label>Conexion SimCard</label>';
                                echo '<br>';
                                $result = trim(system("ping -n $count $host"));
                                echo '<br>';
                            }
                            if (($result != "vuelva a intentarlo.") && ($result != "(100% perdidos),")) {
                                $count  = 1;
                                $host   = $row['iptunelgre'];
                                $host = preg_replace("/[^A-Za-z0-9.-]/", "", $host);
                                $count = preg_replace("/[^0-9]/", "", $count);
                                //echo '<body bgcolor="#FFFFFF" text="#000000"></body>';
                                //echo("Ping Output:<br>");
                                // echo '<pre>';           

                                if ($unix) {
                                    echo '<br>';
                                    echo '<label>Conexion Tunel GRE</label>';
                                    echo '<br>';
                                    system("ping -c$count -w$count $host");
                                    system("killall ping");
                                    echo '<br>';
                                } else {
                                    echo '<br>';
                                    echo '<label>Conexion Tunel GRE</label>';
                                    echo '<br>';
                                    $result = trim(system("ping -n $count $host"));
                                    echo '<br>';
                                }

                                if (($result != "vuelva a intentarlo.") && ($result != "(100% perdidos),")) {
                                    /// AQUI SE CONSUME EL WS DE LOS SITIOS REMOTOS PARA PREGUNTAR POR LA CAMARA
                                    $result = "conexion Establecida";
                                    $connect = 1;
                                    $message = "Estado activo Tunel GRE";

                                    $idcc = $row['id'];
                                    camaras($idcc);
                                } else {
                                    $connect = 0;
                                    $message = "Error de Conexion Tunel GRE";
                                    inactivecam($row['id']);
                                }
                            } else {
                                $connect = 0;
                                $message = "Error de Conexion SimCard";
                                inactivecam($row['id']);
                            }
                        } else {
                            $connect = 0;
                            $message = "Error de Conexion Sitio Central";
                            inactivecam($row['id']);
                        }

                        // Perform queries 
                        //mysqli_query($con,"SELECT * FROM Persons");
                        mysqli_query($con, "INSERT INTO ping (resultado,conectividad,id_centrocomercial,message) 
	            	VALUES ('" . $result . "'," . $connect . "," . $row['id'] . ",'" . $message . "')");

                        //mysqli_close($con);
                        //	echo $result."</p>";
                        //	echo "Conectividad ".$connect;

                    }
                }
                ?>
            </div>
        </div>

    </div>
</div>

@endsection