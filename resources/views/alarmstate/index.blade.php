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
        <span style="font-size: 20px;">Cambio de estado de alarmas</span>
    </div>
    <object data="../update_alarm/index.php" style="width:100%; min-height:120vh; height:100%;"></object>
</div>
@endsection
