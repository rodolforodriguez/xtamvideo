// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/utils/PortalUtil",["dojo/_base/lang","./requests/EveryRequest"],function(k,l){return{query:function(g,a,d,b){a=a||{};d=d||"results";b=b||100;var e="number"===typeof a.num?a.num:-1,f=a.num=0>e||a.num>b?b:a.num;a.start=a.start||1;return g(a).then(function(b){var m=b[d],c=b.total-a.start+1;0<=e&&c>e&&(c=e);c-=f;if(0>=c)return b;a.num=f;for(var h=[];0<c;)a.start+=f,h.push(g.bind(null,k.mixin({},a))),c-=f;return l(h,!0).then(function(a){a.forEach(function(a){Array.prototype.push.apply(m,
a[d])});return b})})}}});