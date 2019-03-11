// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/utils/SymbolUtil",["esri/symbols/PictureFillSymbol","../ReportPlayer/dataProvider/commands/imageUtils/NodeToCanvasUtil","./PatternLibrary"],function(c,d,e){return{simpleFillSymbolToPictureFillSymbol:function(a){if(!a)return null;var f=e.createSvgForPictureFillSymbol({fillStyle:a.style,fillColor:a.color.toCss(!1),fillAlpha:a.color.a});return d.svgNodeToCanvasFunc(f,10,10).then(function(g){try{var b=new c(g.toDataURL("image/png"),a.outline,10,10);b.contentType="image/png";
return b}catch(h){return console.log(h),null}}).otherwise(function(a){console.log(a);return null})}}});