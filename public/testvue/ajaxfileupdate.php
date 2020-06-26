<?php

include "../includes/connection.php";
mysqli_set_charset($con, 'utf8');

$count = mysqli_query($con,
"select count(*) 'count' from cameras c 
inner join streamserver s on c.id_streamserver = s.id 
inner join centro_comercial cc on cc.id=c.id_centrocomercial
where updated_at >= DATE_ADD(NOW(),INTERVAL -5 SECOND);" );
$response = array();

while($row = mysqli_fetch_assoc($count)){
    $response[] = $row;
}

echo json_encode($response);
exit;