// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/PlayerViewModes",[],function(){var b={FULL_PAGES:"fullPages",PANELS_IN_SLIDES:"panelsInSlides",PANELS_IN_STACK:"panelsInStack",PANELS_IN_ROW:"panelsInRow",isMobileSupported:function(a){return a===b.PANELS_IN_SLIDES||a===b.PANELS_IN_STACK||a===b.PANELS_IN_ROW},isStackLike:function(a){return a===b.PANELS_IN_STACK||a===b.PANELS_IN_ROW}};return b});