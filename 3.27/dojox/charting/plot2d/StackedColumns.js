//>>built
define("dojox/charting/plot2d/StackedColumns",["dojo/_base/declare","dojo/_base/lang","./Columns","./commonStacked"],function(b,c,e,d){return b("dojox.charting.plot2d.StackedColumns",e,{getSeriesStats:function(){var a=d.collectStats(this.series,c.hitch(this,"isNullValue"));a.hmin-=.5;a.hmax+=.5;return a},rearrangeValues:function(a,b,c){return d.rearrangeValues.call(this,a,b,c)}})});