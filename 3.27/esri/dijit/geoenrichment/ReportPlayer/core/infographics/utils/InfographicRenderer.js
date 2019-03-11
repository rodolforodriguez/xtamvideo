// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/infographics/utils/InfographicRenderer",["dojo/dom-construct","../InfographicContainer"],function(c,d){return{createInfographicPage:function(a,b){var e=a.node?c.create("div",null,a.node):void 0;b=new (b||d)(a.creationParams,e);"function"===typeof a.placeFunc&&a.placeFunc(b);b.updateInfographic(a.json);return b}}});