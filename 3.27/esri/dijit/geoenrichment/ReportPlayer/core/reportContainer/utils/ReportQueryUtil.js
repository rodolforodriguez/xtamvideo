// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/reportContainer/utils/ReportQueryUtil",["../ReportContainer"],function(b){return{getParentReportContainer:function(a){if(a instanceof b)return a;for(;a;){if(a.parentWidget instanceof b)return a.parentWidget;a=a.parentWidget||a.parentGrid}return null}}});