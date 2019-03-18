// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define(["require","exports","../../layers/graphics/OptimizedFeature","../../layers/graphics/OptimizedFeatureSet","../../layers/graphics/OptimizedGeometry"],function(c,d,f,g,e){Object.defineProperty(d,"__esModule",{value:!0});c=function(){function a(a){this.geometryTypes=["esriGeometryPoint","esriGeometryMultipoint","esriGeometryPolyline","esriGeometryPolygon"]}a.prototype.createFeatureResult=function(){return new g.default};a.prototype.prepareFeatures=function(){};a.prototype.finishFeatureResult=
function(){};a.prototype.addFeature=function(a,b){a.features.push(b)};a.prototype.createFeature=function(){return new f.default};a.prototype.createSpatialReference=function(){return{wkid:0}};a.prototype.createGeometry=function(){return new e.default};a.prototype.addField=function(a,b){a.fields.push(b)};a.prototype.addCoordinate=function(a,b){a.coords.push(b)};a.prototype.addCoordinatePoint=function(a,b){a.coords.push(b)};a.prototype.addLength=function(a,b){a.lengths.push(b)};a.prototype.createPointGeometry=
function(){return new e.default};return a}();d.Context=c});