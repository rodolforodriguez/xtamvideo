<template>
    <body class="claro">      
      <div id="viewDiv"></div>        
    </body>
</template>
<script>

import { loadModules } from 'esri-loader'
export default {  

  props:[''], 
               
  mounted () {
    //console.log('map: mounted')
    loadModules([
      'esri/Map',
      'esri/views/MapView',
      'esri/Graphic',
      'esri/geometry/Point',
      'esri/symbols/SimpleMarkerSymbol',
      'esri/geometry/Polyline',
      'esri/symbols/SimpleLineSymbol',
      'esri/geometry/Polygon',
      'esri/symbols/SimpleFillSymbol',
      'dojo/domReady!'
    ], {
      // use a specific version instead of latest 4.x
      url: 'https://js.arcgis.com/4.7/'
    }).then(([EsriMap, MapView,Graphic,Point,SimpleMarkerSymbol,
              Polyline, SimpleLineSymbol, Polygon, SimpleFillSymbol]) => {
        var map 
        map = new EsriMap({
          basemap: 'hybrid'
        });
  
        var view = new MapView({
            container: "viewDiv",  // Reference to the scene div created in step 5
            map: map,  // Reference to the map object created before the scene
            zoom: 18,  // Sets zoom level based on level of detail (LOD)
            center: [-74.098253, 4.647660]  // Sets center point of view using longitude,latitude
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
@import url('https://js.arcgis.com/4.7/esri/css/main.css');
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


