<?php
if ($_GET) {

    $startdate = $_GET['startdate'];
    $finishdate = $_GET['finishdate'];
    $starttime = $_GET['starttime'];
    $finishtime = $_GET['finishfime'];
    $id = $_GET['id'];
    require_once($_SERVER['DOCUMENT_ROOT'].'/xtamvideo/public/includes/connection.php');
    if ($id > 0) {

        

        $querynginx = mysqli_query($con, "SELECT filename,format(timediff(timefinish,timestart),4) as timeduration, rt.route 
                                            from recordings as r
                                            inner join cameras as c on r.idCamara =  c.cameraid
                                            inner join routerecord as rt on rt.idcamara = c.cameraid
                                            where r.idcamara=" . $id . " and (datetimestart between '$startdate $starttime'
                                                and '$finishdate $finishtime')
                                                order by datestart asc,timestart;");
            
        $numrowsnginx = mysqli_num_rows($querynginx);
    //echo $numrowsnginx;

        if ($numrowsnginx != 0) {

            $texto = "#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:5
#EXT-X-MEDIA-SEQUENCE:65
";
            while ($rownginx = mysqli_fetch_assoc($querynginx)) {
                $texto .= "#EXTINF:" . $rownginx['timeduration'] . ",
" . $rownginx['filename'] . "
";
                $route = $rownginx['route'];
            }
            //echo "Ruta" . $route;
            $texto .= "#EXT-X-ENDLIST";
            //$fileconf="C:/laragon/www/listfolder/recording/camara".$valor."/temp.m3u8";
            unlink($route . "/temp.m3u8");
            $fileconf = $route . "/temp.m3u8";
            $fh = fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
            fwrite($fh, $texto) or die("No se puede escribir en el archivo");
            fclose($fh);
        }
    }
    if ($numrowsnginx != 0) {
        sleep(3);
        

        $queryroute = mysqli_query($con, "SELECT route , cc.descripcion , c.dcamara , folder_record , ipserver
            from routerecord re 
            inner join cameras c on c.cameraid = re.idcamara and c.cameraid= " . $id . "
            inner join centro_comercial cc on cc.id = c.id_centrocomercial");

        $rowroute = mysqli_fetch_assoc($queryroute);

        $ip = $rowroute['ipserver'];
        $rout = $rowroute['folder_record'];
        $temp = "http://" . $ip . "/listfolder/" . $rout . "/temp.m3u8";
        //echo $temp;

        ?>
<div>
    <video id='temp' data-type='video' value='<?php echo $temp; ?>' controls data-found="true"></video>
</div>
<?php

    } else {
        ?>
<div class="container" style="text-align: center;">
    <h4>No se han encontrado los filtros de búsqueda seleccionados.</h4>
</div>
<?php
    }
}
?>