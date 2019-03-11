// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/grid/_GridSortSupport",["dojo/_base/declare","./coreUtils/sorting/GridSortUtil"],function(a,b){return a(null,{canSortCellFunc:null,getSorting:function(){return b.getSorting(this)},setSorting:function(c,a){b.setSorting(this,c,a)},getSortRowIndexMapping:function(){return b.getSortRowIndexMapping(this)},onSortingChanged:function(a){}})});