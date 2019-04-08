<?php
$userid = CRUDBooster::myId();
if ($userid === null) {
    ?>
    <script>
        window.location.replace("../../admin/login");
    </script>
<?php

} ?>

@extends('crudbooster::admin_template')
@section('content')
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Registro de Alarmas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="../call/ajax.js"></script>
</head>

<body>
    <header>
        <nav>
            <h2></h2>
        </nav>
        <header>
            <div id="contenedor">

                <div id="consultar">
                    <section class="widget">

                        <div class="datagrid" id="datagrid">

                        </div>
                    </section>
                </div>
            </div>
</body>

</html>

@endsection