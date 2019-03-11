// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/charts/utils/builder/ChartBuilder",["esri/dijit/geoenrichment/ReportPlayer/config","../ChartTypes","./round/RoundChartBuilder","./columnBarLine/ColumnBarLineChartBuilder"],function(c,b,d,e){return{supportConditionalStyling:function(a){return b.isConditionalStylingEnabled(a)},getChartBuilder:function(a){return b.isRoundChart(a)?d:e},checkSeriesAreValid:function(a){return c.charts.showErrorIfHasUnavailableData?!a.some(function(a){return a.data.some(function(a){return a.isUnavailableData})}):
!0}}});