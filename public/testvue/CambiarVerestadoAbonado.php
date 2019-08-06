<?php

include "config.php";
$n = $_GET['n'];


$abonados = mysqli_query($con, "select VerAbonados from cms_notifications where id='$n' and abonados IS NOT NULL");
$row = mysqli_fetch_array($abonados);
$ResultadoColumna = $row[0];
$ResultadoUpdate = null;

if ($ResultadoColumna == 0) {
    echo ("cambio a 1");
    $abonados1 = mysqli_query($con, "UPDATE cms_notifications SET VerAbonados=1 where id='$n'");
    $ResultadoUpdate = $abonados1[0];
} else {
    echo ("cambio a 0");
    $abonados2 = mysqli_query($con, "UPDATE cms_notifications SET VerAbonados=0 where id='$n'");
    $ResultadoUpdate = $abonados2[0];
}

echo $ResultadoUpdate;
exit;
