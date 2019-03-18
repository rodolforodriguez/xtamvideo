// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../../core/tsSupport/assignHelper @dojo/framework/shim/Map ../../../../core/has ../../../../core/screenUtils ../../../../core/libs/rbush/rbush ../../../../geometry/support/aaBoundingRect ../../../../geometry/support/contains ../../../../geometry/support/jsonUtils ../../../../geometry/support/normalizeUtils ../../engine/webgl/util/iterator ./GraphicStoreItem ./graphicsUtils ../../../vectorTiles/GeometryUtils".split(" "),function(z,A,B,D,E,F,G,m,H,I,J,K,t,f,L){function y(d,
a,b,c,h){l.minX=a;l.minY=b;l.maxX=c;l.maxY=h;return d.search(l)}Object.defineProperty(A,"__esModule",{value:!0});var l={minX:0,minY:0,maxX:0,maxY:0},v=m.create(),w=m.create();z=function(){function d(a,b,c,h,q){this.renderer=h;this._graphics=q;this._index=G(9,E("csp-restrictions")?function(a){return{minX:a[0],minY:a[1],maxX:a[2],maxY:a[3]}}:[".bounds[0]",".bounds[1]",".bounds[2]",".bounds[3]"]);this._itemByGraphic=new D.default;this._currentLevel=-Infinity;this._tileInfoView=a;this._uidFieldName=c;
if(a=a.getClosestInfoForScale(b))this._currentLevel=a.level,this._resolution=this._tileInfoView.getTileResolution(a.level);this._updateGraphicZorder=this._updateGraphicZorder.bind(this)}d.prototype.hitTest=function(a,b,c,h,q){a=J.normalizeMapX(a,this._tileInfoView.spatialReference);var d=.5*h*c;w[0]=a-d;w[1]=b-d;w[2]=a+d;w[3]=b+d;c=.5*h*(c+50);c=y(this._index,a-c,b-c,a+c,b+c);if(!c||0===c.length)return[];for(var n=m.create(),C=q?function(c,e,h){var g=L.C_DEG_TO_RAD*q,k=Math.cos(g),g=Math.sin(g);e=
((1+e)*c[0]+(1-e)*c[2])/2;h=((1+h)*c[1]+(1-h)*c[3])/2;var f=a-e,l=b-h;e=e+k*f+g*l;k=h-g*f+k*l;n[0]=e-d;n[1]=k-d;n[2]=e+d;n[3]=k+d;return m.intersects(c,n)}:function(a){return m.intersects(a,w)},k=[],e,l=0;l<c.length;l++){var g=c[l];switch(I.getJsonType(g.geometry)){case "esriGeometryPoint":e=this._getSymbol(g.graphic);if(!e)continue;var r=g.geometry,p=void 0,u=void 0;"text"===e.type?(p=f.getXAnchorDirection(e.horizontalAlignment||"center"),u=f.getYAnchorDirection(e.verticalAlignment||"middle"),f.getTextSymbolBounds(v,
r.x,r.y,e,g.size,this._resolution,q)):(u=p=0,f.getMarkerSymbolBounds(v,r.x,r.y,e,this._resolution,q));C(v,p,u)&&k.push(g);break;case "esriGeometryPolyline":e=this._getSymbol(g.graphic);if(!e)continue;e=1.5*h*window.devicePixelRatio*F.pt2px(e.width);f.isPointOnPolyline(g.geometry,a,b,e)&&k.push(g);break;case "esriGeometryEnvelope":e=g.geometry;e=m.fromValues(e.xmin,e.ymin,e.xmax,e.ymax);m.intersects(e,w)&&k.push(g);break;case "esriGeometryPolygon":H.polygonContainsPoint(g.geometry,{x:a,y:b})&&k.push(g);
break;case "esriGeometryMultipoint":if(r=this._getSymbol(g.graphic))for(var p=g.geometry.points,t=u=void 0,x=0;x<p.length;x++)if("text"===r.type?(e=r,u=f.getXAnchorDirection(e.horizontalAlignment||"center"),t=f.getYAnchorDirection(e.verticalAlignment||"middle"),f.getTextSymbolBounds(v,p[x][0],p[x][1],e,g.size,this._resolution,q)):(t=u=0,f.getMarkerSymbolBounds(v,p[x][0],p[x][1],r,this._resolution,q)),C(v,u,t)){k.push(g);break}}}k.sort(function(a,b){var c=f.graphicGeometryToNumber(a.graphic),e=f.graphicGeometryToNumber(b.graphic);
return c===e?b.zorder-a.zorder:c-e});return k.map(function(a){return a.graphic})};d.prototype.getGraphicData=function(a,b){var c=this._itemByGraphic.get(b);if(!c)return null;var h=y(this._index,a.bounds[0],a.bounds[1],a.bounds[2],a.bounds[3]);h.sort(function(a,b){return a.zorder-b.zorder});var d=h.indexOf(c),h=0===d||-1===d?-1:h[d-1].graphic.uid;a={originPosition:"upperLeft",scale:[a.resolution,a.resolution],translate:[a.bounds[0],a.bounds[3]]};var d=c.getGeometryQuantized(a),f=B({},c.graphic.attributes);
f[this._uidFieldName]=b.uid;return{centroid:t.default.getCentroidQuantized(c,a,this.renderer,this._scale),geometry:d,attributes:f,symbol:b.symbol,insertAfter:h}};d.prototype.queryTileData=function(a){var b=m.pad(a.bounds,50*a.resolution,m.create()),b=y(this._index,b[0],b[1],b[2],b[3]),c=[];this._createTileGraphics(c,b,{originPosition:"upperLeft",scale:[a.resolution,a.resolution],translate:[a.bounds[0],a.bounds[3]]});return c};d.prototype.has=function(a){return this._itemByGraphic.has(a)};d.prototype.getBounds=
function(a){return this._itemByGraphic.has(a)?this._itemByGraphic.get(a).bounds:null};d.prototype.add=function(a,b,c){if(a)return b=t.default.acquire(a,c,b,this.renderer,this._resolution,this._scale,this._tileInfoView.spatialReference),this._itemByGraphic.set(a,b),this._itemByGraphic.forEach(this._updateGraphicZorder),c&&this._index.insert(b),b.bounds};d.prototype.remove=function(a){if(this._itemByGraphic.has(a)){var b=this._itemByGraphic.get(a);this._index.remove(b);this._itemByGraphic.delete(a);
this._itemByGraphic.forEach(this._updateGraphicZorder)}};d.prototype.reorder=function(a){this._itemByGraphic.has(a)&&this._itemByGraphic.forEach(this._updateGraphicZorder)};d.prototype.update=function(a,b,c){var d=this._itemByGraphic.get(a),f=m.clone(d.bounds);d.size[0]=d.size[1]=0;this._index.remove(d);d.set(a,c,b,this.renderer,this._resolution,this._scale,this._tileInfoView.spatialReference);c&&this._index.insert(d);return{oldBounds:f,newBounds:d.bounds}};d.prototype.updateLevel=function(a){var b=
this;this._currentLevel!==a&&(this._currentLevel=a,this._resolution=this._tileInfoView.getTileResolution(a),this._scale=this._tileInfoView.getTileScale({level:a,row:0,col:0,world:0}),a=this._itemByGraphic.values(),K.forEachIter(a,function(a){b._index.remove(a);a.updateBounds(b.renderer,b._resolution,b._scale,b._tileInfoView.spatialReference);a.geometry&&b._index.insert(a)}))};d.prototype.clear=function(){this._itemByGraphic.clear();this._index.clear()};d.prototype._createTileGraphics=function(a,b,
c){var d=this._uidFieldName;b.sort(function(a,b){return a.zorder-b.zorder});for(var f,l,n,m,k=0;k<b.length;k++){n=b[k];f=n.graphic;l=n.getGeometryQuantized(c);m=0===k?-1:b[k-1].graphic.uid;var e=B({},n.graphic.attributes);e[d]=f.uid;a.push({centroid:t.default.getCentroidQuantized(n,c,this.renderer,this._scale),geometry:l,attributes:e,symbol:f.symbol,insertAfter:m})}};d.prototype._getSymbol=function(a){return a.symbol?a.symbol:this.renderer?this.renderer.getSymbol(a,{scale:this._scale}):null};d.prototype._updateGraphicZorder=
function(a,b){a.zorder=this._graphics.indexOf(b)};return d}();A.default=z});