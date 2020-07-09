<?php
require("includes/connection.php");

    //variables POST

    $estado = $_GET['estado'];
    $ipserver = $_GET['ipserver'];
    $channel = $_GET['channel'];
    

        $select="SELECT estado,cameraid FROM cameras c inner join centro_comercial cc on cc.id=c.id_centrocomercial
            where dcamara='".$channel."' and ipserver='".$ipserver."'";
            
        $regitro=mysqli_query($con, $select);
        $valor=mysqli_fetch_assoc($regitro);
        $valorvali=mysqli_num_rows($regitro);
        
        if($valorvali > 0){
            if($valor['estado']!=$estado){
                echo "entro";
                $consulta = "UPDATE cameras SET estado='" . $estado . "' WHERE cameraid=" . $valor['cameraid'];
                echo $consulta;
                $add = mysqli_query($con, $consulta);
                if ($add) {
                    echo "estado actualizado";
                } else {
                    echo "intente de nuevo";
                }

                $update_df_log="UPDATE rtsp_log set datefinish=now()
                where name_channel='".$channel."' and ip_remote='".$ipserver."' order by id_log desc limit 1;";
                $registerup= mysqli_query($con, $update_df_log);
                if ($registerup) {
                    echo "estado actualizado";
                } else {
                    echo "intente de nuevo";
                }
                $consulta = "INSERT INTO rtsp_log(`name_channel`, `ip_remote`, `status`) 
                VALUES ('" . $channel . "','" . $ipserver . "','" . $estado . "')";
                    //echo $consulta;
                $register = mysqli_query($con, $consulta);
                if ($register) {
                    echo "Log Insertado";
                } else {
                    echo "intente de nuevo";
                }
    
    
            }else{
                $select="SELECT * FROM rtsp_log
                    where name_channel='".$channel."' and ip_remote='".$ipserver."'";
            
                $regitro=mysqli_query($con, $select);
                $valor=mysqli_fetch_assoc($regitro);
                $valorvali=mysqli_num_rows($regitro);
                if($valorvali == 0){
                $consulta = "INSERT INTO rtsp_log(`name_channel`, `ip_remote`, `status`) 
                VALUES ('" . $channel . "','" . $ipserver . "','" . $estado . "')";
                $register = mysqli_query($con, $consulta);
                if ($register) {
                    echo "Log Insertado";
                } else {
                    echo "intente de nuevo";
                }

                }
        
            }
        }