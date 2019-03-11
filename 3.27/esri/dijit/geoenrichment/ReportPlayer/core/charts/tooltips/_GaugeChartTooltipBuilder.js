// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/charts/tooltips/_GaugeChartTooltipBuilder",["dojo/dom-construct","dojo/string","./_BuilderUtil","dojo/i18n!esri/nls/jsapi"],function(e,f,c,d){d=d.geoenrichment.dijit.ReportPlayer.ChartTooltip;return{buildGaugeChartTooltip:function(b,a){c.addTitle(a,b.label,b.color);a=e.create("div",{"class":"chartTooltip_row esriGERowHigh"},a);c.addRowOffset(a);b.isUnavailableData?c.addLabel(d.unavailableData,a):c.addLabel(f.substitute(d.gaugeChartTooltip_label,{value:b.valueLabel,
total:b.sumValueLabel}),a)}}});