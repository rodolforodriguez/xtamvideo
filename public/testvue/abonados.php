<?php

include "config.php";
$n=$_GET['n'];
$abonados = mysqli_query($con,"select abonados,VerAbonados from cms_notifications where id='$n' and abonados IS NOT NULL and VerAbonados='1'");
$response = array();

while($row = mysqli_fetch_assoc($abonados)){

    $response[] = $row;
}

    echo json_encode($response);


exit;

