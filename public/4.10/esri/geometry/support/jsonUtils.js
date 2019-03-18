// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../Extent ../Mesh ../Multipoint ../Point ../Polygon ../Polyline".split(" "),function(v,b,h,r,k,l,m,n){function c(a){return void 0!==a.xmin&&void 0!==a.ymin&&void 0!==a.xmax&&void 0!==a.ymax}function d(a){return void 0!==a.points}function e(a){return void 0!==a.x&&void 0!==a.y}function f(a){return void 0!==a.paths}function g(a){return void 0!==a.rings}function p(a){return void 0!==a.vertexAttributes}function q(a){if(a){if(e(a))return l.fromJSON(a);if(f(a))return n.fromJSON(a);
if(g(a))return m.fromJSON(a);if(d(a))return k.fromJSON(a);if(c(a))return h.fromJSON(a);if(p(a))return r.fromJSON(a)}return null}Object.defineProperty(b,"__esModule",{value:!0});b.fromJson=function(a){try{throw Error("fromJson is deprecated, use fromJSON instead");}catch(t){console.warn(t.stack)}return q(a)};b.isExtent=c;b.isMultipoint=d;b.isPoint=e;b.isPolyline=f;b.isPolygon=g;b.isMesh=p;b.fromJSON=q;b.getJsonType=function(a){if(a){if(e(a))return"esriGeometryPoint";if(f(a))return"esriGeometryPolyline";
if(g(a))return"esriGeometryPolygon";if(c(a))return"esriGeometryEnvelope";if(d(a))return"esriGeometryMultipoint"}return null};var u={esriGeometryPoint:l,esriGeometryPolyline:n,esriGeometryPolygon:m,esriGeometryEnvelope:h,esriGeometryMultipoint:k};b.getGeometryType=function(a){return a&&u[a]||null}});