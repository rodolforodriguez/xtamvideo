<?php

include "config.php";
$n = $_GET['n'];
$abonados1 = mysqli_query($con, "UPDATE parameter SET Last_IdAlarmaSelect='$n' where id=1");
$ResultadoUpdate = $abonados1[0];
echo $ResultadoUpdate;
exit;
