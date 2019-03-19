<template>
    <body class="claro">      
      <div id="viewDiv" style="height: 80vh;min-height: 250px;"></div>  
      
    </body>
</template>
<script>
import axios from 'axios'
import { loadModules } from 'esri-loader'
export default {  

  props:[''], 
               
  mounted () {
    //console.log('map: mounted')
    loadModules([
      'esri/tasks/Locator',
      'esri/widgets/Sketch',
      'esri/Map',
      'esri/views/MapView',
      'esri/Graphic',
      "esri/layers/GraphicsLayer",
      "esri/Color",
      'esri/geometry/Point',
      'esri/symbols/SimpleMarkerSymbol',
      'esri/geometry/Polyline',
      "esri/geometry/Circle",
      'esri/symbols/PictureMarkerSymbol',
      'esri/symbols/SimpleLineSymbol',
      'esri/geometry/Polygon',
      'esri/symbols/SimpleFillSymbol',
      'dojo/domReady!'
    ], {
      // use a specific version instead of latest 4.x
      url: 'http://xtamvideo.test/4.10/init.js'
    }).then(([Locator, Sketch,EsriMap, MapView,Graphic,GraphicsLayer,Color,Point,SimpleMarkerSymbol,
              Polyline, Circle,PictureMarkerSymbol, SimpleLineSymbol, Polygon, SimpleFillSymbol]) => {
        
        const layer = new GraphicsLayer();
        // Create a locator task using the world geocoding service
        var locatorTask = new Locator({
            url: "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer"
        });                
        var map, coords="", coordinates="" 


        map = new EsriMap({
          basemap: 'hybrid',
          layers: [layer]
        });
  
        var view = new MapView({
            container: "viewDiv",  // Reference to the scene div created in step 5
            map: map,  // Reference to the map object created before the scene
            zoom: 15,  // Sets zoom level based on level of detail (LOD)
            center: [-74.098253, 4.647660]  // Sets center point of view using longitude,latitude
        });  


       ///// end iconografia
          axios.get('http://xtamvideo.test/testvue/ajaxfile.php?n=1')
                        .then(function(response) {
                       
                          console.log(response);
                          
                          var cameras=response.data;
                          var value=cameras.length;
                           console.log(value);
                            //cameras = response.data;
                            ///// cameras recording data base

                      
               for(let i = 0; i < value; i++){
                 //// estados de las camaras

                  var tipocamara='';
                  var n=cameras[i].typecam;
                  switch (n) {
                    case 1:
                      tipocamara +='publica';
                    break;
                    case 2:
                      tipocamara +='privada';
                    break;
                    case 3:
                      tipocamara +='lpr';
                    break;
                    default:
                      tipocamara +='privada';
                  }
                  var estado=cameras[i].estado;
                  switch (estado) {
                    case 'active':
                      tipocamara +='a';
                    break;
                    case 'inactive':
                      tipocamara +='i';
                    break;
                    default:
                      tipocamara +='i';
                  }
                   //// iconografia alarma y camaras
                  var iconBase = '../includes/img/';
                  var icon='';
                    if(tipocamara =='publicaa'){
                        icon= iconBase + 'cam-green.png'
                    }else if( tipocamara == 'publicai'){
                        icon=iconBase + 'cam-red.png'
                      }else if( tipocamara == 'privadaa'){
                        icon=iconBase + 'cam-green.png'
                      }else if( tipocamara == 'privadai'){
                        icon=iconBase + 'cam-red.png'
                      }else if( tipocamara == 'lpra'){
                        icon=iconBase + 'dome-green.png'
                      }else if( tipocamara == 'lpri'){
                        icon=iconBase + 'dome-red.png'
                      }else if( tipocamara == 'alarm'){
                        icon= iconBase + 'alert50_marker.gif'
                      }
                    
                var server=cameras[i].cameraid;   
                var camara=cameras[i].cameraid;
                if(cliente==1){
                var channel=cameras[i].dcamara;
                }else{
                var channel=cameras[i].channelstreamserver;
                }
                ///// end estados de las camras 
                /// puntos de las camaras ene el mapa
                var point = new Point({
                  longitude: cameras[i].longitud,
                  latitude: cameras[i].latitud
                });
                
                // Create a symbol for drawing the point
                // Create a symbol for drawing the point
                // Create a symbol for drawing the point
               /* var markerSymbol = new SimpleMarkerSymbol({
                  color: [226, 119, 40],
                  size: '20px',
                  outline: {
                    color: [255, 255, 226],
                    width: 1
                  }
                });*/
               
                var markerSymbol =  new PictureMarkerSymbol({
                // type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                url: icon,
                width: "24px",
                height: "24px"
                });

        /// link a abrir en otra ventana
        var link='../vs/streaming.php?ip='+server+'&state='+cliente+'&userid='+userid;
              
        // Create attributes
        var attributes = {
        XCoord:cameras[i].longitud,
        YCoord:cameras[i].latitud,
        Plant:cameras[i].descripcion,
        Link:"<A class='btn btn-success btn-sm' onclick=myFunction('"+link+"')>Ver Cámara</A>",
        Adresss:cameras[i].direccion,
        Embebed:'<iframe style="position: relative;" src="../vs/streaming.php?ip='+server+'&state='+cliente+'&userid='+'userid" id="iframe" frameborder="0" allowfullscreen="allowfullscreen"></iframe>'
        };
                
        
        // Create popup template
        var popupTemplate = {
        title: "{Plant}",
        content:"<div>" +
                 "Latitude: {YCoord}<br/>Longitude: {XCoord}<br/>Dirección:{Adresss}<br/>Camaras:  {Link}"+
                 '</div>'
        };

        

        // Create a graphic and add the geometry and symbol to it
         if(estado == 'active'){
         var pointGraphic = new Graphic({
          geometry: point,
          symbol: markerSymbol,
          attributes: attributes,
          popupTemplate: popupTemplate
         });
        }else{
          var pointGraphic = new Graphic({
          geometry: point,
          symbol: markerSymbol,
          attributes: attributes
          
         });
        }
        

        // Add the graphics to the view's graphics layer
        view.graphics.add(pointGraphic); 
        }
        ///// end point cameras



                            
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

        /// alarmas no gestionadas
        axios.get('http://xtamvideo.test/testvue/ajaxfile.php?n=2')
                        .then(function(response) {
                       
                          console.log(response);
                          
                          var cameras=response.data;
                          var value=cameras.length;
                           console.log(value);
                            //cameras = response.data;
                            ///// cameras recording data base

                      
               for(let i = 0; i < value; i++){
                 //// estados de las camaras

                  
                  var estado=cameras[i].estado;
                  var caseupdate="";
                  var colorcase="";
                  switch (estado) {
                    case 'C':
                      caseupdate='Cerrado';

                    break;
                    case 'P':
                      caseupdate='Pendiente';
                      colorcase=[255,0,0,0.5];
                    break;
                    case 'E':
                      caseupdate='En Proceso';
                      colorcase=[255,255,0,0.5];
                    break;
                    default:
                      caseupdate='Pendiente';
                      colorcase=[255,255,0,0.5];
                  }
                  
                
                ///// end estados de las camras 
                /// puntos de las camaras ene el mapa
                var point = new Point({
                  longitude: cameras[i].longitud,
                  latitude: cameras[i].latitud
                });
                
                // Create a symbol for drawing the point
                
               var markerSymbol = new SimpleMarkerSymbol({
                  //color: [226, 119, 40],
                  size: '24px',
                  style: "circle",
                  //color: [255,0,0,0.5],
                  color: colorcase,
                  outline: {
                    color: [255, 255, 255],
                    width: 0.5
                  }
                });
               
                
        /// link a abrir en otra ventana
        var link='../vs/alarm/index.php?lng='+point.longitude+'&lat='+point.latitude+'&dist='+dist+'&max_cams='+max_cams+'&state='+cliente+'&userid='+userid;
        //../vs/alarm/index.php?lng='+longitud+'&lat='+latitud+'&dist='+dist+'&max_cams='+max_cams+'&state='+cliente+'&userid='+userid;
              
        // Create attributes
        var attributes = {
        XCoord:cameras[i].longitud,
        YCoord:cameras[i].latitud,
        Plant:cameras[i].municipio,
        Link:"<A class='btn btn-success btn-sm' onclick=myFunction('"+link+"')>Ver Cámara</A>",
        Adresss:cameras[i].direccion,
        Barrio:cameras[i].barrio,
        DesCaso:cameras[i].descripcion_caso,
        Fecha:cameras[i].fecha
        //Embebed:'<iframe style="position: relative;" src="../vs/streaming.php?ip='+server+'&state='+cliente+'&userid='+'userid" id="iframe" frameborder="0" allowfullscreen="allowfullscreen"></iframe>'
        };
                
        
        // Create popup template
        var popupTemplate = {
        title: "{Plant}",
        content:"<div>" +
                 "Latitud: {YCoord}<br/>Longitud: {XCoord}<br/>Dirección:{Adresss}<br/>Barrio:  {Barrio}<br/>Descripción Caso:  {DesCaso}<br/>Fecha:  {Fecha}<br/>Camaras:  {Link}"+
                 '</div>'
        };

        

        // Create a graphic and add the geometry and symbol to it
         
         var pointGraphic = new Graphic({
          geometry: point,
          symbol: markerSymbol,
          attributes: attributes,
          popupTemplate: popupTemplate
         });
        
        
        

        // Add the graphics to the view's graphics layer
        //if (estado =! "C"){
        view.graphics.add(pointGraphic); 
        //}
        }
        ///// end point cameras



                            
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

////// end de alarmas


        
        view.when(function() {

            const sketch = new Sketch({
                layer: layer,
                view: view
            });

            view.ui.add(sketch, "bottom-left");
        });

        //popup con cordenadas en el mapa.
        /*view.popup.autoOpenEnabled = false;
        view.on("click", function(event) {
            // Get the coordinates of the click on the view
            // around the decimals to 3 decimals
            var lat = Math.round(event.mapPoint.latitude * 100000) / 100000;
            var lon = Math.round(event.mapPoint.longitude * 100000) / 100000;
            var cordinates = lat + "," + lon + "*";
           
        });*/
       
        //coordenadas en el mapa 
        var coordsWidget = document.createElement("div");
        coordsWidget.id = "coordsWidget";
        coordsWidget.className = "esri-widget esri-component";
        coordsWidget.style.padding = "7px 15px 5px";

      var DivButton =  document.getElementById("DivButton");

        //ubicacion de Cordenadas en el mapa 
        //view.ui.add(coordsWidget, "bottom-right");
        // Add widget to   top right corner of the view
       // view.ui.add(toggle, "top-right");

        //** ADD **//
        //var url="<a onclick=myFunction('../vs/Pcampoly.php?userid=2&state=1&var=(%20";
      function showCoordinates(pt) {
        coords = pt.latitude.toFixed(3) + "," + pt.longitude.toFixed(3) + "*";
        coordsWidget.innerHTML += coords;
          var linkGoTo = 'http://xtamvideo.test/vs/Pcampoly.php?userid=2&state=1&var=(%20' + coordsWidget.innerHTML + '*)';
          var content = `<a class="btn btn-success btn-sm" onclick="myFunction('${linkGoTo}')">Ver Cámaras</a>`;
          DivButton.innerHTML = content;      
      }
        //url +="style='color:  white;font-size: small;'><img src='../includes/img/icons8-programa-de-televisión-60.png' width='40' height='30'/></a>";
        //document.getElementById("info3").innerHTML =url;
        //** ADD **//
        /*view.watch(["stationary"], function() {
            showCoordinates(view.center);
        });*/

        view.on(["pointer-down"], function(evt) {
            showCoordinates(view.toMap({
                x: evt.x,
                y: evt.y
            }));
           
        });

        
        
               

        Echo.channel('channelDemoEvent')
                .listen('eventTrigger',(e)=>{     
                console.log(e)  

                    // First create a point geometry
                var point = new Point({
                  longitude: e.longitud,
                  latitude: e.latitud
                });

                // Create a symbol for drawing the point
                if (e.estado == 'P'){
                  var markerSymbol = new SimpleMarkerSymbol({
                    color: [255, 0, 0],
                    size: '24px',
                    outline: {
                      color: [255, 255, 255],
                      width: 1
                    }
                  });                  
                }
                else if (e.estado == 'E'){
                  var markerSymbol = new SimpleMarkerSymbol({
                    color: [255, 255, 0],
                    size: '24px',
                    outline: {
                      color: [255, 255, 255],
                      width: 1
                    }
                  });                  
                }
                else{
                  var markerSymbol = new SimpleMarkerSymbol({
                    color: [0, 102, 0],
                    size: '24px',
                    outline: {
                      color: [255, 255, 255],
                      width: 1
                    }
                  });                  
                }
                
        var link='../vs/alarm/index.php?lng='+e.longitud+'&lat='+e.latitud+'&dist='+dist+'&max_cams='+max_cams+'&state='+cliente+'&userid='+userid;
        // Create attributes
         var attributes = {            
            XCoord:e.longitud, 
            YCoord:e.latitud,
            Plant:e.municipio,
            Link:"<A class='btn btn-success btn-sm' onclick=myFunction('"+link+"')>Ver Cámara</A>",
            Adresss:e.direccion,
            Barrio:e.barrio,
            DesCaso:e.descripcion_caso,
            Fecha:e.fecha
            //Embebed:'<iframe style="position: relative;" src="../vs/streaming.php?ip='+server+'&state='+cliente+'&userid='+'userid" id="iframe" frameborder="0" allowfullscreen="allowfullscreen"></iframe>'             
        };
        
        // Create popup template
        var popupTemplate = {
          title: "{Plant}",          
          content:"<div>" +
                 "Latitud: {YCoord}<br/>Longitud: {XCoord}<br/>Dirección:{Adresss}<br/>Barrio:  {Barrio}<br/>Descripción Caso:  {DesCaso}<br/>Fecha:  {Fecha}<br/>Camaras:  {Link}"+
                 '</div>'
        };

        // Create a graphic and add the geometry and symbol to it
        var pointGraphic = new Graphic({
          geometry: point,
          symbol: markerSymbol,
          attributes: attributes,
          popupTemplate: popupTemplate
        });

        // Add the graphics to the view's graphics layer
        view.graphics.add(pointGraphic); 

        });
    })
        
    },
  methods:{
            SimpleMarkerSymbol: function(d){
                return moment(d).fromNow();
          },                      
  }
}
</script>
<style scoped>
@import url('http://xtamvideo.test/4.10/esri/css/main.css');
#viewDiv {
  height: 500px;
  width: 100%;
}
.title
{
  margin-top: 50px;
}
.info
{
  font-weight: 300;
  color: #9aabb1;
  margin: 0;
  margin-top: 10px;
}
.button
{
  margin-top: 50px;
}
</style>



