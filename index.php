<?php
session_start();

$key = "";
$time = new DateTime("2020-12-26");
$_SESSION["licencia"] = $time;
$date = new DateTime("now", new DateTimeZone('America/Bogota'));
$date = new DateTime($date->format('Y-m-d'));
$diference = $date->diff($time);
?>

<html
    style="background-image: url(public/includes/img/login.png); background-repeat: no-repeat; background-size: cover; background-position: center;">


<head>
    <title>Xtam</title>
</head>

<style>
html,
body {
    margin: 0;
    height: 100%;
    overflow: hidden
}

h1 {
    color: white;
    text-align: center;
}

h3 {
    color: white;
    text-align: center;
}


p {
    color: white;
    text-align: center;
}

img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>


<?php

if ($date > $time) {

?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12" style="margin: 18% auto;">
                <img src="public/includes/img/logo.png">
                <h1> La licencia ha expirado </h1>
                <h3><?php echo $time->format('Y-m-d'); ?></h3>
                <p>Contactate con uno de nuestros asesores</p>
            </div>
        </div>
    </div>
</body>

<?php
} else {

?>
<meta http-equiv="refresh" content="5; URL='public/admin/login'" />

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12" style="margin: 18% auto;">
                <img src="public/includes/img/logo.png">
                <h1> Su licencia esta vigente </h1>
                <h3><?php echo $time->format('Y-m-d'); ?> Quedan <?php echo $diference->days ?> Dias </h3>
                <p> Espere por favor, será redireccionado en 5 segundos. en caso contrario dar click <a
                        href="public/admin/login" style="color: yellow;"> Aqui</a></p>
            </div>
        </div>
    </div>
</body>
<?php
}

?>

</html>