<?php
$userid = CRUDBooster::myId();
if ($userid === null) {
    ?>
    <script>
        window.location.replace("../../admin/login");
    </script>
<?php

}

$cliente = $_SERVER['REMOTE_ADDR'];
$server = $_SERVER['SERVER_ADDR'];
////// helper que obtiene cliente que esta consumiendo
///// 1 local - 0 remoto
if ($server == $cliente) {
    $cliente = 1;
} else {
    $cliente = 0;
}
// Database Constants
include "includes/connection.php";

/// end conexion camaras privadas
//$userid=CRUDBooster::myId();

$perms = DB::table('xtam_profile_inst')
    ->select('idProfile_inst')
    ->where('profile_StatusChek', '=', '1')
    ->get();
$val = substr($perms, 19, -2);

$centeralarm = DB::table('parameter')
    ->select('Alarm_center')
    ->get();
$AlmCenter = substr($centeralarm, 17, -2);

// query of radio of the alarm and numbers of cam's to see
$query_parameter = mysqli_query($con, "select * from parameter");
$parameter = mysqli_fetch_assoc($query_parameter);
$alarm_radio = $parameter['alarm_radio'];
$max_cams = $parameter['max_cams'];
$lastselect1 = $parameter['Last_IdAlarmaSelect'];
$query_selectlastcam = mysqli_query($con, "select * from cms_notifications where id='$lastselect1'");
$parameter_selectlastcam = mysqli_fetch_assoc($query_selectlastcam);
$latitud_selectlastcam = $parameter_selectlastcam['latitud'];
$longitud_selectlastcam = $parameter_selectlastcam['longitud'];
/// end conexion alarma y parametros
?>
<script>
    var cenAlarm = <?php echo $AlmCenter; ?>;
    var permisos = '<?php echo $val;  ?>';
    var cliente = <?php echo $cliente;  ?>;
    var dist = <?php echo $alarm_radio; ?>;
    var max_cams = <?php echo $max_cams; ?>;
    var userid = 2;
    var lastselect1 = <?php echo $lastselect1; ?>;
    if (lastselect1 == 0) {
        console.log("entro a 0");
        var lastselectLatitud =4.64766;
        var lastselectLongitud =-74.098253;
    } 
    else {
        console.log("entro a 1");
        var lastselectLatitud = '<?php echo $latitud_selectlastcam; ?>';
        var lastselectLongitud = '<?php echo $longitud_selectlastcam; ?>';
    }
</script>
<script>
    function myFunction(url) {
        var myWindow = window.open(url, "", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=400,height=400,titlebar=no,location=no,menubar=no");
    }

    function test(idAlarma) {
        var URLdomain = window.location.host;
        axios
            .get(
                `http://${URLdomain}/xtamvideo/public/testvue/CambiarVerestadoAbonado.php?n=${idAlarma}`
            )
            .then(function(response) {

                if (Object.keys(response.data).length !== 0) {
                    location.reload();
                    axios
                        .get(
                            `http://${URLdomain}/xtamvideo/public/testvue/UltimoAbonado.php?n=${idAlarma}`
                        )
                        .then(function(response) {

                            if (Object.keys(response.data).length !== 0) {
                                location.reload();
                            }
                        });

                }
            });
    }
</script>

<?php $__env->startSection('content'); ?>
<div id="coordclick"></div>
<div id="DivButton"></div>
<notification-map v-bind:likes="42"></notification-map>
<audio id="myAudio">
    <source src="../includes/sounds/bell_ring.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>