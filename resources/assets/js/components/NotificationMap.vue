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
                console.log('Pintar punto en el mapa')  

                    // First create a point geometry
                var point = new Point({
                  longitude: e.notificationLpr.longitud,
                  latitude: e.notificationLpr.latitud
                });

                // Create a symbol for drawing the point
                // Create a symbol for drawing the point
                // Create a symbol for drawing the point
                var markerSymbol = new SimpleMarkerSymbol({
                  color: [226, 119, 40],
                  size: '20px',
                  outline: {
                    color: [255, 255, 255],
                    width: 1
                  }
                });

        // Create attributes
        var attributes = {
          Name: "Placa reportada : " + e.notificationLpr.licensePlateText,  // The name of the pipeline
          Park: e.notificationLpr.centrocomercial,  // The owner of the pipeline
          City: e.notificationLpr.descamara,  // The length of the pipeline
          ira: "/notificationlpr/"+ e.notificationLpr.slug + "/edit"
        };
        
        // Create popup template
        var popupTemplate = {
          title: "{Name}",
          content: "Encontrada en <b>{Park}</b> ubicacion <b>{City}</b>. <a href='{ira}' target='_blank' rel='noopener noreferrer'>Ver...</a>"
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
        this.ShowAllCameras();
    },
  methods:{
            SimpleMarkerSymbol: function(d){
                return moment(d).fromNow();
          },
          ShowAllCameras: function(){
              
            
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


