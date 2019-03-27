<?php $__env->startSection('content'); ?>

<?php

$cliente = $_SERVER['REMOTE_ADDR'];
$server = $_SERVER['SERVER_ADDR'];
////// helper que obtiene cliente que esta consumiendo
///// 1 local - 0 remoto
if ($server == $cliente) {
  $cliente = 1;
} else {
  $cliente = 0;
}
// Database Constants
include "includes/connection.php";

/// end conexion camaras privadas


$userid = CRUDBooster::myId();

// query of radio of the alarm and numbers of cam's to see
$query_parameter = mysqli_query($con, "select * from parameter");
$parameter = mysqli_fetch_assoc($query_parameter);
$alarm_radio = $parameter['alarm_radio'];
$max_cams = $parameter['max_cams'];
/// end conexion alarma y parametros

?>

<script src="<?php echo HOST; ?>/public/4.10/init.js"></script>
<link rel="stylesheet" href="<?php echo HOST; ?>/public/4.10/dijit/themes/nihilo/nihilo.css">
<link rel="stylesheet" href="<?php echo HOST; ?>/public/4.10/esri/css/main.css">

<style>
    /*body {font-family: Arial, Helvetica, sans-serif;}

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        /*z-index: 1; /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: -50px;
        width: 100%;
        /* Full width */
        height: 110%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 100%;
        height: 100%;
    }

    /* The Close Button */
    .close {
        color: black;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<body>

    <!-- Trigger/Open The Modal -->
    <button id="info3" class="btn btn-success" title="Haz click visualizar cámaras" style="width: 10%;height: 35px;"><img src="../includes/img/icons8-programa-de-televisión-60.png" width="" height="30" /></button></p>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="info4">Some text in the Modal..</p>
        </div>

    </div>

    <script>
        var cliente = <?php echo $cliente; ?>;
        var coordinates = "";
        var newcenter = "";
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("info3");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        /*btn.onclick = function() {
            modal.style.display = "block";
        }*/
        var cam = <?php echo $userid; ?>;

        function popinfo() {
            var r = confirm("Estas seguro de cerrar las cámaras?");
            if (r == true) {
                if (cliente == 0) {
                    camonly(cam);
                }

            }
        }


        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";


            }
        }
    </script>
    <div data-dojo-type="dijit/layout/BorderContainer" data-dojo-props="design:'headline', gutters:false" style="width:100%;height:100%;margin:0;">
        <div id="map" style="height: 80vh;min-height: 250px;">
            <span id="info2"></span>
            <!-- div de galeria de mapas -->
            <div style="position:absolute; right:20px; top:10px; z-Index:999;">
                <div class="btn btn-success" data-dojo-type="dijit/TitlePane" data-dojo-props="title:'TIPO DE MAPA', open:false">
                    <div data-dojo-type="dijit/layout/ContentPane" style="background-color: floralwhite;width:380px; height:280px; overflow:auto;">
                        <div id="basemapGallery"></div>
                    </div>
                </div>
            </div>
            <!-- end galerias de mapas -->

        </div>
    </div>
    <div id="info" class="esriSimpleSlider" title="Haz click para seleccionar el área">
        <button id="polygon" data-dojo-type="dijit.form.Button" style="border: 2px solid green;"><img src="../includes/img/poligono_simple.svg" width="25" height="25" /></button>
        <!--<button id="clear" data-dojo-type="dijit.form.Button">Clear Graphics</button>
      <button id="info3" class="btn btn-success" style="display:none;" ></button> -->
    </div>

</body>
<script>
    var app = {};
    app.map = null;
    app.toolbar = null;
    app.tool = null;
    app.symbols = null;
    app.printer = null;
    require([
        "dojo/dom",
        "esri/geometry/webMercatorUtils",
        "dojo/dom-attr",
        "dojo/_base/array",
        "dojo/number",

        "dijit/registry",
        "esri/dijit/BasemapGallery",
        "esri/arcgis/utils",
        "dojo/parser",
        "esri/config",

        "esri/map",
        "esri/Color",

        "esri/tasks/BufferParameters",
        "esri/toolbars/draw",

        "esri/symbols/SimpleFillSymbol",
        "esri/graphic",
        "esri/layers/GraphicsLayer",
        "esri/geometry/Circle",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/renderers/ClassBreaksRenderer",
        "esri/geometry/Point",


        "esri/symbols/Font",
        "esri/symbols/TextSymbol",
        "dijit/layout/BorderContainer",
        "dijit/layout/ContentPane",
        "dijit/TitlePane",
        "dojo/domReady!"

    ], function(
        dom, webMercatorUtils, domAttr, array, number, registry, BasemapGallery, arcgisUtils, parser, esriConfig,
        Map,
        Color,
        BufferParameters, Draw,
        SimpleFillSymbol, Graphic, GraphicsLayer,
        Circle,
        SimpleMarkerSymbol, SimpleLineSymbol,
        ClassBreaksRenderer,
        Point,
        Font, TextSymbol
    ) {
        parser.parse();
        <?php

        $host = $_SERVER["HTTP_HOST"];
        $url = $_SERVER["REQUEST_URI"];
        $link = "http://" . $host . $url;
        if ($_GET) {
          /// aqui se recibe y se gestiona los parametros de la alarma SINAP
          $n = $_GET['n'];
          $query_data = mysqli_query($con, "select * from cms_notifications where timestamp='" . $n . "'");
          $register_data = mysqli_fetch_assoc($query_data);
          $center = $register_data['longitud'] . ", " . $register_data['latitud']; //'-74.042600, 4.701859'; 
          $longitud = $register_data['longitud']; //'-74.042600';
          $latitud = $register_data['latitud']; //'4.701859';
          $cc = $register_data['barrio']; //"Unicentro Norte";
          $url1 = 'Pcam5';
          $dcamara = "Cam1";
          $direccion = $register_data['direccion'];
        } else {
          $center = '-74.098253, 4.647660'; //can
        }
        ?>
        app.map = new Map("map", {
            basemap: "hybrid",
            center: [<?php echo $center; ?>],
            zoom: 15
        });
        //add the basemap gallery, in this case we'll display maps from ArcGIS.com including bing maps
        var basemapGallery = new BasemapGallery({
            showArcGISBasemaps: true,
            map: app.map
        }, "basemapGallery");
        basemapGallery.startup();

        basemapGallery.on("error", function(msg) {
            console.log("basemap gallery error:  ", msg);
        });
        //// end basemap gallery
        <?php if ($_GET) { ?>
        ////create Circle
        var symbol = new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID,
            new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASHDOT,
                new Color([30, 144, 255]), 0.1), new Color([30, 144, 255, 0.4]));
        var gl = new GraphicsLayer({
            id: "circles"
        });
        //var geodesic = dom.byId("geodesic");
        app.map.addLayer(gl);
        app.map.on("load", function() {
            var radius = <?php echo $alarm_radio; ?>;
            var circle = new Circle({
                center: [<?php echo $center; ?>],
                zoom: 18,
                geodesic: true,
                radius: radius
            });
            var graphic = new Graphic(circle, symbol);
            app.map.graphics.add(graphic);
            gl.add(graphic);
        });
        //// end circle

        <?php 
      } ?>
        app.map.on("load", function() {

            /// poligono

            //after map loads, connect to listen to mouse move & drag events
            //app.map.on("mouse-move", showCoordinates);
            //app.map.on("mouse-drag", showCoordinates);


            document.getElementById("info3").style.display = "none";
            // create a toolbar for the map
            app.toolbar = new Draw(app.map);
            app.toolbar.on("draw-end", addToMap);


            // activate a drawing tool when a button is clicked
            registry.byId("polygon").on("click", function() {
                app.map.on("mouse-down", showCoordinates);
                app.toolbar.activate(Draw.POLYGON);
                app.map.hideZoomSlider();
                dom.byId("info3").innerHTML = '<img src="../includes/img/icons8-programa-de-televisión-60.png" width="" height="30"/>';
                dom.byId("info4").innerHTML = "";
                coordinates = "";
                document.getElementById("info3").style.display = "none";
            });

            /*registry.byId("clear").on("click", function() {
              //app.map.graphics.clear();
              dom.byId("info3").innerHTML = "";
              coordinates="";
              document.getElementById("info3").style.display="none";
              app.map.showZoomSlider();
              app.map.setZoom(16);
            });*/
            function addToMap(evtObj) {
                //app.map.graphics.clear();
                var geometry = evtObj.geometry;
                // add the drawn graphic to the map
                var symbol = new SimpleFillSymbol(
                    SimpleFillSymbol.STYLE_SOLID,
                    new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID, new Color([0, 0, 0]), 2),
                    new Color([0, 0, 255, 0.5]));
                var graphic1 = new Graphic(geometry, symbol);
                //alert(newcenter);
                app.map.graphics.add(graphic1);
                //var point2 = [-74.10522674, 4.64622706];
                var ncenter = newcenter.split(",", 2);
                //alert(ncenter)
                //var point3=[];

                //dom.byId("info2").innerHTML = ncenter + "</p>"+ point2;

                app.map.centerAndZoom(ncenter, 16);
                //app.map.setZoom(17);
                //app.map.centerAt(new Point(ncenter));

                //app.map.centerAt(new Point(-74.10200809, 4.65097500));
                //// iniciar aca ojo 07/03/2019 5:55 
                document.getElementById("info3").style.display = "";
                //<iframe style="position: relative;" src='../vs/Pcampoly.php?var=(%20"+coordinates+")' style='color:  white;font-size: small;' id="iframe" frameborder="0" allowfullscreen="allowfullscreen"></iframe>  
                dom.byId("info3").innerHTML = "<a onclick=myFunction('../vs/Pcampoly.php?userid=<?php echo $userid; ?>&state=<?php echo $cliente; ?>&var=(%20" + coordinates + ")') style='color:  white;font-size: small;'><img src='../includes/img/icons8-programa-de-televisión-60.png' width='40' height='30'/></a>";
                //"<iframe style='height: 80vh;min-height: 850px;width: 100%;' src='../vs/Pcampoly.php?userid=<?php  ?>&state=<?php  ?>&var=(%20"+coordinates+")' style='color:  white;font-size: small;' id='iframe' frameborder='0' allowfullscreen='allowfullscreen'></iframe>";  
                // "<a href='../vs/Pcampoly.php?userid=<?php echo $userid; ?>&state=<?php echo $cliente; ?>&var=(%20"+coordinates+")' style='color:  white;font-size: small;'><img src="../includes/img/icons8-programa-de-televisión-60.png" width="" height="30"/></a>"; 
                // simplify polygon so it can be used in the get label points request
                //geometryService.simplify([geometry], getLabelPoints);
            }

            function showCoordinates(evt) {
                //the map is in web mercator but display coordinates in geographic (lat, long)

                var mp = webMercatorUtils.webMercatorToGeographic(evt.mapPoint);

                //display mouse coordinates
                coordinates = coordinates + mp.y.toFixed(8) + "," + mp.x.toFixed(8) + "*";
                //dom.byId("info2").innerHTML = coordinates;
                newcenter = mp.x.toFixed(8) + ", " + (mp.y.toFixed(8));

            }
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {


                var r = confirm("Estas seguro de cerrar las cámaras p?");
                if (r == true) {
                    modal.style.display = "none";
                    //app.map.graphics.remove(graphic1);

                    if (cliente == 0) {
                        //showUser(coordinates);
                        camonly(cam);
                    }
                }

            }




            /// end poligono

            var iconBase = '../includes/img/';
            var icons = {
                publicaa: {
                    icon: iconBase + 'cam-green.png'
                },
                publicai: {
                    icon: iconBase + 'cam-red.png'
                },
                privadaa: {
                    icon: iconBase + 'cam-green.png'
                },
                privadai: {
                    icon: iconBase + 'cam-red.png'
                },
                lpra: {
                    icon: iconBase + 'dome-green.png'
                },
                lpri: {
                    icon: iconBase + 'dome-red.png'
                },
                alarm: {
                    icon: iconBase + 'alert50_marker.gif'
                }
            };

            <?php 
            $query = mysqli_query($con, "select * from cameras c inner join streamserver ss
          on c.id_streamserver = ss.id;");
            $numrows = mysqli_num_rows($query);
            if ($numrows != 0) {
              while ($row = mysqli_fetch_assoc($query)) {
                if ($row['dcamara'] == "Cam1") {
                  $url = "Pcam1";
                } elseif ($row['dcamara'] == "Cam1") {
                  $url = "Pcam2";
                } elseif ($row['dcamara'] == "Cam3") {
                  $url = "Pcam3";
                } elseif ($row['dcamara'] == "Cam8") {
                  $url = "Pcam1";
                }
                $tipocamara = "";
                $n = $row["typecam"];
                switch ($n) {
                  case 1:
                    $tipocamara .= "publica";
                    break;
                  case 2:
                    $tipocamara .= "privada";
                    break;
                  case 3:
                    $tipocamara .= "lpr";
                    break;
                  default:
                    $tipocamara .= "privada";
                }
                $estado = $row["estado"];
                switch ($estado) {
                  case "active":
                    $tipocamara .= "a";
                    break;
                  case "inactive":
                    $tipocamara .= "i";
                    break;
                  default:
                    $tipocamara .= "i";
                }
                $server = $row["cameraid"];
                ?>

            var camara = <?php echo $row["cameraid"]; ?>;


            <?php

            if ($cliente == 1) {

              $channel = $row["dcamara"];
            } else {

              $channel = $row["channelstreamserver"];
            }


            ?>
            //document.getElementsByClassName("tittle"+cameraid).id="idcam"+cameraid;
            //$( "#idcam"+cameraid ).click(function() {





            var myPoint = {
                "geometry": {
                    "x": <?php echo $row["longitud"]; ?>,
                    "y": <?php echo $row["latitud"]; ?>,
                    //"spatialReference":{"wkid":4326}
                },
                "attributes": {
                    "XCoord": <?php echo $row["longitud"]; ?>,
                    "YCoord": <?php echo $row["latitud"]; ?>,
                    "Plant": "CC <?php echo $row["centrocomercial"]; ?>",
                    //http://localhost/vloxysec/public/vs//vloxysec/public/admin/lprMaps?n=1533047960.php?ip=18.220.66.20&cc=Milenio%20Plaza
                    //"Link":'<a href="streaming?ip=<?php  ?>&state=<?php  ?>" >'+
                    //         '<?php  ?></a>',
                    "Link": "<A class='btn btn-success btn-sm' onclick=myFunction('../vs/streaming.php?ip=<?php echo $server; ?>&state=<?php echo $cliente; ?>&userid=<?php echo $userid; ?>')>Ver Cámara</A>",
                    "Adresss": "<?php echo $row["direccion"]; ?>",
                    "Embebed": '<iframe style="position: relative;" src="../vs/streaming.php?ip=<?php echo $server; ?>&state=<?php echo $cliente; ?>&userid=<?php echo $userid; ?>" id="iframe" frameborder="0" allowfullscreen="allowfullscreen"></iframe>'
                },
                "symbol": {
                    "url": icons.<?php echo $tipocamara; ?>.icon,
                    "height": 20,
                    "width": 20,
                    "type": "esriPMS",
                    "angle": 0
                },
                <?php if ($estado != "inactive") { ?> "infoTemplate": {
                    "title": "${Plant}",
                    "content": "<div>" +
                        //"Latitude: ${YCoord}<br/>Longitude: ${XCoord}<br/>Dirección:${Adresss}<br/>Camaras:${Link}<br/>${Embebed}"+
                        "Latitude: ${YCoord}<br/>Longitude: ${XCoord}<br/>Dirección:${Adresss}<br/>Camaras:  ${Link}" +
                        '</div>'
                }
                <?php 
              } ?>
            };
            //var cameraid=<?php  ?>;
            var gra = new esri.Graphic(myPoint);
            app.map.graphics.add(gra);

            <?php

          }
        }
        ?>
            <?php if ($_GET) {
              // point the circle
              ?>
            var myPoint = {
                "geometry": {
                    "x": <?php echo $longitud; ?>,
                    "y": <?php echo $latitud; ?>,
                    //"spatialReference":{"wkid":4326}
                },
                "attributes": {
                    "XCoord": <?php echo $longitud; ?>,
                    "YCoord": <?php echo $latitud; ?>,
                    "Plant": " <?php echo $cc; ?>",
                    /*"Link":"<form action='../vs/alarm/' method='POST'>" +
                            "<input type='hidden' name='lng' value=<?php  ?>>" +
                            "<input type='hidden' name='lat' value=<?php  ?>>"+
                            "<input type='hidden' name='dist' value=<?php  ?>>"+
                            "<input type='hidden' name='max_cams' value=<?php  ?>>"+
                            "<input type='hidden' name='state' value=<?php  ?>>"+
                            "<input type='hidden' name='userid' value=<?php  ?>>"+
                            
                            //"<input type='submit' class='btn btn-success' value='Ver Camaras'>"+
                            "</form>",*/
                    "Link": "<A class='btn btn-success btn-sm' onclick=myFunction('../vs/alarm/index.php?lng=<?php echo $longitud; ?>&lat=<?php echo $latitud; ?>&dist=<?php echo $alarm_radio; ?>&max_cams=<?php echo $max_cams; ?>&state=<?php echo $cliente; ?>&userid=<?php echo $userid; ?>')>Ver Cámaras</A>",
                    "Adresss": "<?php echo $direccion; ?>",
                    "Embebed": '<iframe style="position: relative;" src="../vs/alarm/index.php?lng=<?php echo $longitud; ?>&lat=<?php echo $latitud; ?>&dist=<?php echo $alarm_radio; ?>&max_cams=<?php echo $max_cams; ?>&state=<?php echo $cliente; ?>&userid=<?php echo $userid; ?>" id="iframe" frameborder="0" allowfullscreen="allowfullscreen"></iframe>'
                },
                "symbol": {
                    "url": icons.alarm.icon,
                    "height": 20,
                    "width": 20,
                    "type": "esriPMS",
                    "angle": 0
                },
                "infoTemplate": {
                    "title": "${Plant}",
                    "content": "<div class='embed-responsive embed-responsive-1by1' style='display: contents;'>" +
                        "Latitude: ${YCoord}<br/>Longitude: ${XCoord}<br/>Dirección:${Adresss}<br/>${Link}" +
                        '</div>'
                }
            };

            var gra = new esri.Graphic(myPoint);
            app.map.graphics.add(gra);
            <?php
      // end point the circle
          }
          ?>
        });

    });
</script>

<script>
    //// open new window the camera
    function myFunction(url) {
        var myWindow = window.open(url, "", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=400,height=400,titlebar=no,location=no,menubar=no");
    }
    /// end funcionality
    function showUser(coordinates) {
        str = coordinates;
        userid = <?php echo $userid; ?>;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "../nginxoff/form.php?userid=" + userid + "&q=" + str, true);
        xmlhttp.send();

    }

    function camonly(ip) {

        userid = ip;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "../nginxoff/camonly.php?userid=" + userid, true);
        xmlhttp.send();

    }
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>