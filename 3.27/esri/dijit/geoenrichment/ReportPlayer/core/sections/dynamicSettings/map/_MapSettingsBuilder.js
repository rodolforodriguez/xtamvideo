// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/sections/dynamicSettings/map/_MapSettingsBuilder",["dojo/when"],function(b){return{provideMapSettings:function(c){var a=c.getMapImages()[0];return a?b(a.getLoadMapPromise(),function(){return{showLegend:a.isLegendVisible()}}):null}}});