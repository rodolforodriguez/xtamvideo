//>>built
define("dstore/charting/StoreSeries",["dojo/_base/lang","dojo/_base/declare","dojo/_base/array"],function(e,f,g){return f(null,{constructor:function(a,b){this.collection=a.track?a.track():a;this.value=b?"function"===typeof b?b:"object"===typeof b?function(a){var c={},d;for(d in b)c[d]=a[b[d]];return c}:function(a){return a[b]}:function(a){return a.value};this.data=[];this._initialRendering=!1;this.fetch()},destroy:function(){var a=this.collection.tracking;a&&a.remove()},setSeriesObject:function(a){this.series=
a},fetch:function(){var a=this.collection,b=e.hitch(this,this._update);a.fetch().then(e.hitch(this,function(c){this.objects=c;b();if(a.tracking)a.on("add, update, delete",b)}))},_update:function(){var a=this;this.data=g.map(this.objects,function(b){return a.value(b,a.collection)});this.series&&(this.series.chart.updateSeries(this.series.name,this,this._initialRendering),this._initialRendering=!1,this.series.chart.delayedRender())}})});