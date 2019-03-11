<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
$q = intval($_GET['q']);
$userid=$_GET['userid'];
include("../includes/connection.php");


//$sql="SELECT * FROM user WHERE id = '".$q."'";
/// camaras a cancelar el streaming queryes
error_reporting(0);
#if(!isset($_SESSION["session_username"])) {
#	header("location:login.php");
#} 
//$ip=$_GET['ip'];
$ip="";
$cc="Poligono";
$puntos=$_GET['q'];
echo "puntos".$puntos;
$puntos=str_replace(",", " ", $puntos);
$puntos=str_replace("*", ",", $puntos);
$puntos=str_replace("(", " ", $puntos);
$puntos=str_replace(")", " ", $puntos);
//echo $puntos;

	$querylonlat =mysqli_query($con,"select centrocomercial,longitud,latitud from cameras");
	class pointLocation {
			var $pointOnVertex = true; // Checar si el punto se encuentra exactamente en uno de los vértices?
		
			#function pointLocation() {
			#}
		
				function pointInPolygon($point, $polygon, $pointOnVertex = true) {
				$this->pointOnVertex = $pointOnVertex;
		
				// Transformar la cadena de coordenadas en matrices con valores "x" e "y"
				$point = $this->pointStringToCoordinates($point);
				$vertices = array(); 
				foreach ($polygon as $vertex) {
					$vertices[] = $this->pointStringToCoordinates($vertex); 
				}
		
				// Checar si el punto se encuentra exactamente en un vértice
				if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
					return "vertex";
				}
		
				// Checar si el punto está adentro del poligono o en el borde
				$intersections = 0; 
				$vertices_count = count($vertices);
		
				for ($i=1; $i < $vertices_count; $i++) {
					$vertex1 = $vertices[$i-1]; 
					$vertex2 = $vertices[$i];
					if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Checar si el punto está en un segmento horizontal
						return "boundary";
					}
					if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
						$xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
						if ($xinters == $point['x']) { // Checar si el punto está en un segmento (otro que horizontal)
							return "boundary";
						}
						if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
							$intersections++; 
						}
					} 
				} 
				// Si el número de intersecciones es impar, el punto está dentro del poligono. 
				if ($intersections % 2 != 0) {
					return "inside";
				} else {
					return "outside";
				}
			}
		
			function pointOnVertex($point, $vertices) {
				foreach($vertices as $vertex) {
					if ($point == $vertex) {
						return true;
					}
				}
		
			}
		
			function pointStringToCoordinates($pointString) {
				$coordinates = explode(" ", $pointString);
				return array("x" => $coordinates[0], "y" => $coordinates[1]);
			}
 
	}
	$pointLocation = new pointLocation();
					$points =array();
						while($row=mysqli_fetch_assoc($querylonlat)){
							$geopuntos= $row["latitud"].' '.$row["longitud"];	
							array_push($points,$geopuntos);   
						}
					
					$polygon = array();
					$puntoscoor="";
					for($i=0;$i<strlen($puntos);$i++){ 
						if($puntos[$i]!=","){
							$puntoscoor.=$puntos[$i];
						}else{
							array_push($polygon,$puntoscoor);
							$puntoscoor="";
						}
					}
					for($i=0;$i<strlen($puntos);$i++){ 
						if($puntos[$i]!=","){
							$puntoscoor.=$puntos[$i];
						}else{
							array_push($polygon,$puntoscoor);
							$i=strlen($puntos)+1;
							$puntoscoor="";
						}
					}  
						
					foreach($points as $key => $point) {
						
		#echo "point " . ($key+1) . " ($point): <b>" . $pointLocation->pointInPolygon($point, $polygon) . "</b><br>";
						$cadena=$pointLocation->pointInPolygon($point, $polygon);
						$cadena2=trim($cadena);
								
							if($cadena2!='outside'){
								$point=str_replace(" ", ",", $point);
								$posicion=strpos($point, ",");
								$tamaño=strlen($point);
								$latitud=substr($point, 0, $posicion);
								$longitud=substr($point, $posicion+1, $tamaño);
                                
                                $selectlog="select * from cameras inner join logchannelinuse
                                            on cameras.cameraid=logchannelinuse.idcameras
                                             where iduser<>'".$userid."' and logchannelinuse.inuse=1 and (longitud='".$longitud."' and latitud='".$latitud."')";
                                $resultlog = $con->query($selectlog);
                                $numlog=mysqli_num_rows($resultlog);
                                $Selectmycam=mysqli_query($con,"select * from cameras where longitud='".$longitud."' and latitud='".$latitud."'");
                                $rowmycam=mysqli_fetch_assoc($Selectmycam);
                                if($numlog==0){
								$queryup="update cameras set inuse=0 where longitud='".$longitud."' and latitud='".$latitud."'";
								$result = $con->query($queryup);
                                }
								$querylog=mysqli_query($con,"update logchannelinuse set inuse=0 where idcameras='".$rowmycam['cameraid']."' and iduser='".$userid."'");
								
								
							}
						
					}

//// end de las camaras a cancelar streaming
/// reestructuracion streaming conf
$querynginx=mysqli_query($con,"select c.id_streamserver, ss.server, ss.port from cameras c inner join streamserver ss
on c.id_streamserver = ss.id group by(id_streamserver) order by port;");
$numrowsnginx=mysqli_num_rows($querynginx);
if($numrowsnginx!=0)
{
    $texto="worker_processes  1;
error_log  logs/error.log debug;
    events {
        worker_connections  1024;
    }
rtmp{
        ";
    while($rownginx=mysqli_fetch_assoc($querynginx))
    {  
        $query_stream=mysqli_query($con," select c.inuse,cc.ipserver,c.dcamara, ss.server, ss.port, c.channelstreamserver 
											from cameras c inner join streamserver ss
												on c.id_streamserver = ss.id
													inner join centro_comercial cc on cc.id=c.id_centrocomercial; 
														where id_streamserver=".$rownginx['id_streamserver']."
															order by port,channelstreamserver");
                                                        
        $numchannel=mysqli_num_rows($query_stream);                                                    
        
        $i=1;
        while($row_stream=mysqli_fetch_assoc($query_stream))
        {  
            if($row_stream['inuse']==1){
            $pull="pull rtmp://".$row_stream['ipserver'].":1935/".$row_stream['dcamara'].";";   
            }else{
            $pull="";    
            }
            if ($i==1){
                $texto.="
                    server {
                      listen ".$row_stream['port'].";
            
                        application ".$row_stream['channelstreamserver']." {
                            live on;
                            ".$pull."
                        }
                    ";
                }elseif($i==$numchannel){
                    $texto.="
                        application ".$row_stream['channelstreamserver']." {
                            live on;
                            ".$pull."
                        }
                    }
                    ";
                    }else{
                        $texto.="
                        application ".$row_stream['channelstreamserver']." {
                            live on;
                            ".$pull."
                        }
                        ";
                    }
        $i++;
        }

    }
}
$texto.="
}";
$fileconf="c:/nginx_vloxysecurity_V3/conf/nginx.conf";
$fh=fopen($fileconf, 'w') or die("Ocurrio un error al abrir el archivo");
fwrite($fh, $texto) or die("No se puede escribir en el archivo");
fclose($fh);
//echo $texto;
//include("startnginx.php");
function execInBackground($cmd) { 
    if (substr(php_uname(), 0, 7) == "Windows"){ 
        pclose(popen("start ". $cmd, "r"));
        //echo("entro1");  
    } 
    else { 
        exec($cmd . " > /dev/null &");   
        //echo("entro2");
    } 
}
$cmd2="c:/nginx_vloxysecurity_V3/reload_nginx.bat";   
execInBackground($cmd2);
//// finalizacion reestructuracion streaming
mysqli_close($con);
?>
</body>
</html>