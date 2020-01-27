<?php

use Illuminate\Support\Facades\DB;
if(is_array($datos)){

    $texto="worker_processes  1;
error_log  logs/error.log debug;
    events {
        worker_connections  1024;
    }
rtmp{
        ";

    foreach ($datos as $d) {  
        
        $camaras = DB::table('cameras')
        ->join('streamserver','streamserver.id','=','cameras.id_streamserver')
        ->join('centro_comercial','centro_comercial.id','=','cameras.id_centrocomercial')
        ->where('cameraid','=', $d->cameraid )
        ->get();
                                                
    }      
 
    $numchannel = count($camaras);      
    $i=1;
    
    foreach($camaras as $uso)
    {
        echo $uso->inuse;
    }

    if($numchannel > 0)
    {
        foreach ($camaras as $row_stream) {
                 
            if ($row_stream->inuse == 1) {
               
                $pull = "pull rtmp://" . $row_stream->ipserver . ":1935/" . $row_stream->dcamara . ";";
            } else {
                $pull = "";
            }
            if ($i == 1) {
                $texto .= "
                    server {
                      listen " . $row_stream->port . ";
            
                        application " . $row_stream->channelstreamserver . " {
                            live on;
                            " . $pull . "
                        }
                    ";
            } elseif ($i == $numchannel) {
                $texto .= "
                        application " . $row_stream->channelstreamserver . " {
                            live on;
                            " . $pull . "
                        }
                    }
                    ";
            } else {
                $texto .= "
                        application " . $row_stream->channelstreamserver . " {
                            live on;
                            " . $pull . "
                        }
                        ";
            }
            $i++;
        }
$texto .= "
}";
$fileconf = "c:/nginx_vloxysecurity_V3/conf/nginx.conf";
//$fileconf="ftp://vloxy:123456@192.168.1.20/nginx_vloxysecurity_V3/conf/nginx.conf";
$fh = fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
fwrite($fh, $texto) or die("No se puede escribir en el archivo");
fclose($fh);
//echo $texto;
include("../resources/views/ApiConsumo/startnginx.php");

    }
    else 
    {
    echo "No se encontraron registros";
    }
}else
{
    echo "formato invalido";
}


?>