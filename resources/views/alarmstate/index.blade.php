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


@endsection