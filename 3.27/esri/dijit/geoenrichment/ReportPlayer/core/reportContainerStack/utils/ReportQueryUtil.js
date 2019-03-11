// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/reportContainerStack/utils/ReportQueryUtil",["esri/dijit/geoenrichment/utils/DomUtil"],function(d){return{getPanelInfoByNode:function(b,e){var a={panelIndex:-1,panelScale:void 0};b.infographicPage.getSections().some(function(f,c){if(d.isChildOf(e,f.domNode))return a.panelIndex=c,a.panelScale=b.infographicPage.getPanelScaleAt(c),!0});return a}}});