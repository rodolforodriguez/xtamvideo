<?php

include "../includes/connection.php";
$n=$_GET['n'];
mysqli_set_charset($con, 'utf8');
if($n==1){
$cameras = mysqli_query($con,"select * from cameras c inner join streamserver ss
on c.id_streamserver = ss.id inner join centro_comercial cc
on cc.id=c.id_centrocomercial;" );
}elseif($n==2){
    $cameras = mysqli_query($con,"select * from cms_notifications where estado <> 'C' and is_read =0;" );
}
$response = array();

while($row = mysqli_fetch_assoc($cameras)){

    $response[] = $row;
}

echo json_encode($response);
exit;