<?php

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

// query of radio of the alarm and numbers of cam's to see
$query_parameter = mysqli_query($con, "select * from parameter");
$parameter = mysqli_fetch_assoc($query_parameter);
$alarm_radio = $parameter['alarm_radio'];
$max_cams = $parameter['max_cams'];

/// end conexion alarma y parametros
?>
<script>
    var permisos = '<?php echo $val;  ?>';
    var cliente = <?php echo $cliente;  ?>;
    var dist = <?php echo $alarm_radio; ?>;
    var max_cams = <?php echo $max_cams; ?>;
    var userid = 2;
</script>
<script>
    function myFunction(url) {
        var myWindow = window.open(url, "", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=400,height=400,titlebar=no,location=no,menubar=no");
    }
</script>
@extends('crudbooster::admin_template')
@section('content')
<div id="coordclick"></div>
<div id="DivButton"></div>
<notification-map></notification-map>
<audio id="myAudio">
    <source src="../includes/sounds/bell_ring.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
@endsection 