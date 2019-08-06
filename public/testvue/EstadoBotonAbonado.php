<?php

include "config.php";
$n=$_GET['n'];
$abonados = mysqli_query($con,"select VerAbonados from cms_notifications where id='$n'");
$response = array();

while($row = mysqli_fetch_assoc($abonados)){

    $response[] = $row;
}

    echo json_encode($response);


exit;

