<!DOCTYPE html>
<html lang="es">
<head>
<title>Registro de empleados</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="ajax.js"></script>
</head>
<body>
<header>
    <nav>
        <h2>Insertar/Mostrar Datos con AJAX y PHP</h2>
    </nav>
<header>
<div id="contenedor">
    <div id="inscribir">
    <section class="widget">
<h4 class="widgettitulo">Inscribir Nuevo Empleado</h4>
 <form name="empleado" onsubmit="return false" action="return false">
            <input type="text" id="cedula" name="cedula" placeholder="Nº CEDULA" autocomplete="off" tabindex="1" required>
            <input type="text" id="nombre" name="nombre" placeholder="NOMBRE" autocomplete="off" tabindex="2" required>
            <input type="text" id="fecha" name="fecha_nacimiento" placeholder="FECHA DE NACIMIENTO" tabindex="4" required>
            <input type="text" id="cargo" name="cargo" placeholder="CARGO EN LA EMPRESA" tabindex="4" required>
            <button onclick="Registrar();" tabindex="7">Guardar
            <br style="clear:both;">
        </form>
        <div id="respuesta"></div>
    </section>
    </div>
    <div id="consultar">
    <section class="widget">
        <h4 class="widgettitulo">Listado de Empleados</h4>
        <div class="datagrid" id="datagrid" style="color: #006699;">

        </div>  
    </section>
    </div>
</div>     
</body>
</html>  