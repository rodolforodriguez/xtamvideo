<?php
include("../../includes/connection.php");

$url = $_GET["ruta"];
$name = $_GET["name"];
$format =  $_GET["formato"];

?>



<?php 
// echo"entro aqui";
        /*** convert video to flash ***/
        exec("ffmpeg.exe"); // load ffmpeg.exe
       exec("ffmpeg -i ".$url." -an ../output/".$name.".".$format);
       $ruta="../format/output/".$name.".".$format;
       $string="INSERT INTO record_download (`name`, `format`, `rote`) VALUES ('".$name."', '".$format."', '".$ruta."')";
       $query =mysqli_query($con,$string);
       
    


?>
