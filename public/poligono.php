<?php
/*
Descripción: El algoritmo del punto en un polígono permite comprobar mediante
programación si un punto está dentro de un polígono o fuera de ello.
Autor: Michaël Niessen (2009)
Sito web: AssemblySys.com
 
Si este código le es útil, puede mostrar su
agradecimiento a Michaël ofreciéndole un café ;)
PayPal: https://www.paypal.me/MichaelNiessen
 
Mientras estos comentarios (incluyendo nombre y detalles del autor) estén
incluidos y SIN ALTERAR, este código está distribuido bajo la GNU Licencia
Pública General versión 3: http://www.gnu.org/licenses/gpl.html
*/
 
class pointLocation {
    var $pointOnVertex = true; // Checar si el punto se encuentra exactamente en uno de los vértices?
 
    function pointLocation() {
    }
 
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
$points = array("4.648144 -74.102844","4.646658 -74.101723","4.6488827 -74.101342","4.647374 -74.100548");
/*$points = array(    
"4.64737492601069 -74.1005489230156",
"4.64814486205878 -74.1028448939323",
"4.65268425957098 -74.1094350814819",
"4.64665845698823 -74.1017237305641",
"4.65382846115798 -74.1105991601943",
"4.65419203884295 -74.1099661588668",
"4.70363684813886 -74.0424817800521",
"4.70074981226138 -74.0425890684127",
"4.70069634852119 -74.0401536226272",
"4.70346576486486 -74.0407437086105",
"4.64888271664886 -74.101342856884",
);
*/
$polygon = array("4.648584 -74.104295","4.645184 -74.101226","4.648135 -74.098308","4.650274 -74.100711","4.648584 -74.104295");
/*$polygon = array(
"4.711916 -74.099099",
"4.70302 -74.093691",
"4.713456 -74.093262",
"4.711916 -74.099099",
//"4.652986 -74.110098",
);*/
// Las últimas coordenadas tienen que ser las mismas que las primeras, para "cerrar el círculo"
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}
?>