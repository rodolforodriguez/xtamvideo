// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../Camera ../../../geometry ../../../Graphic ../../../Viewpoint ../../../core/compilerUtils ../../../core/Error ../../../core/promiseUtils ../../../core/libs/gl-matrix-2/gl-matrix ../../../geometry/support/aaBoundingBox ../../../geometry/support/aaBoundingRect ../../../geometry/support/webMercatorUtils ../camera/intersectionUtils ./cameraUtils ./geometryUtils ./mathUtils ./projectionUtils".split(" "),function(ga,t,F,u,U,z,V,N,l,h,p,O,q,x,g,W,P,w){function G(a){return 360-
P.cyclicalDeg.normalize(a)}function v(a){return P.cyclicalDeg.normalize(360-a)}function A(a,b){a&&(null==b?a.reject():a.resolve(b));return b}function Q(a,b,c,d){if(!b)return A(d);var e=a.spatialReference||u.SpatialReference.WGS84;if(b.camera){a=b.get("camera.position.spatialReference");if(!q.canProject(a,e))return A(d);b=b.camera.clone();a.equals(e)||(b.position=q.project(b.position,e));return A(d,b)}var f=b.get("targetGeometry.spatialReference");if(f&&!q.canProject(f,e))return A(d);e=g.internalToExternal(a,
a.state.camera);f=g.OrientationMode.ADJUST;null!=b.rotation&&(e.heading=G(b.rotation),f=g.OrientationMode.LOCKED);null!=c&&(e.tilt=c);if("point"===b.targetGeometry.type){c=b.targetGeometry;var m=void 0,h=b.targetGeometry.clone(),m=null!=b.scale?g.scaleToDistance(a,b.scale,c.latitude):a.state.camera.distance;return g.fromCenterDistance(a,h,m,e,f,d)}return g.fromExtent(a,b.targetGeometry.extent,e.heading,e.tilt,f,d)}function H(a,b){var c=b.scale;null==c&&null!=b.zoom&&(c=g.zoomToScale(a,b.zoom));return c}
function I(a,b){var c=!1;null!=b.heading?(a.heading=b.heading,c=!0):null!=b.rotation&&(a.heading=G(b.rotation),c=!0);null!=b.tilt&&(a.tilt=b.tilt,c=!0);null!=b.fov&&(a.fov=b.fov);return c}function B(a,b,c){var d=a.spatialReference||u.SpatialReference.WGS84;b=b||g.externalToInternal(a,c.camera);c.targetGeometry=w.vectorToPoint(b.center,a.renderSpatialReference,d);c.scale=g.computeScale(a,b);c.rotation=v(c.camera.heading);return c}function J(a,b,c){if(b){if(!q.canProject(b.spatialReference,a.spatialReference))throw new N("viewpointutils:incompatible-spatialreference",
"Spatial reference ("+(b.spatialReference?b.spatialReference.wkid:"unknown")+") is incompatible with the view ("+a.spatialReference.wkid+")",{geometry:b});var d=[];if(!b.hasZ&&a.basemapTerrain){var e=void 0;switch(b.type){case "point":e=b;break;case "multipoint":case "polyline":case "mesh":e=b.extent.center;break;case "extent":e=b.center;break;case "polygon":e=b.centroid;break;default:V.neverReached(b)}e&&q.canProject(e,a.basemapTerrain.spatialReference)?k[2]=a.basemapTerrain.getElevation(e)||0:k[2]=
0}(0,X[b.type])(b,function(a){d.push(a[0],a[1],a[2])},k);var f=d.length/3;if(0!==f&&(e=Array(d.length),w.bufferToBuffer(d,b.spatialReference,0,e,a.spatialReference,0,f)))for(b.hasZ&&(c.hasZ=!0),a=0;a<e.length;a+=3)b.hasZ?(k[0]=e[a+0],k[1]=e[a+1],k[2]=e[a+2]):(k[0]=e[a+0],k[1]=e[a+1]),p.expand(c.boundingBox,k)}}function Y(a,b,c,d){return a.whenViewForGraphic(b).then(function(a){if(a&&a.whenGraphicBounds)return a.whenGraphicBounds(b,{minDemResolution:c})}).then(function(a){var b=a.boundingBox;p.expand(d.boundingBox,
b);a.screenSpaceObjects&&a.screenSpaceObjects.forEach(function(a){d.screenSpaceObjects.push(a)});isFinite(b[2])&&(d.hasZ=!0)}).catch(function(){J(a,b.geometry,d)})}function R(a,b,c,d){if(Array.isArray(b)&&2===b.length){var e=b[0],f=b[1];if("number"===typeof e&&"number"===typeof f)return n.x=e,n.y=f,n.z=void 0,n.spatialReference=u.SpatialReference.WGS84,J(a,n,d),l.resolve()}if(b&&"function"===typeof b.map)return l.eachAlways(b.map(function(b){return R(a,b,c,d)}));if(b instanceof u.BaseGeometry)try{J(a,
b,d)}catch(m){return l.reject(m)}else if(b instanceof U)return Y(a,b,c,d);return l.resolve()}function Z(a,b,c,d){if(b.camera)return l.resolve(S(a,c,b.camera,d));d.scale=b.scale;d.rotation=b.rotation;d.targetGeometry=b.targetGeometry?b.targetGeometry.clone():null;d.camera=null;null!=c.heading?d.rotation=v(c.heading):null!=c.rotation&&(d.rotation=c.rotation);b=H(a,c);null!=b&&(d.scale=b);b=l.createResolver();Q(a,d,c.tilt,b);return b.promise.then(function(a){d.camera=a;return d})}function S(a,b,c,d){d.camera=
c.clone();d.camera.fov=a.camera.fov;b=a.spatialReference;c=d.camera.position.spatialReference;if(!q.canProject(c,b))return null;c.equals(b)||(d.camera.position=q.project(d.camera.position,b));return B(a,null,d)}function aa(a,b,c,d,e){var f=a.renderSpatialReference;w.pointToVector(c.position,C,f);w.pointToVector(b,K,f);e.targetGeometry=new u.Point(b);e.camera.position=new u.Point(c.position);h.vec3.subtract(D,K,C);g.directionToHeadingTilt(a,C,D,d.up,e.camera);e.scale=g.distanceToScale(a,h.vec3.distance(C,
K),e.targetGeometry.latitude);e.rotation=v(e.camera.heading);return e}function L(a,b,c,d){if(!c)return l.reject();d.targetGeometry=c.clone();var e=x.cameraOnContentAlongViewDirection(a);if(b.position)return l.resolve(aa(a,d.targetGeometry,b,e,d));if(b.zoomFactor){var f=e.distance/b.zoomFactor,m=h.vec3.scale(k,e.viewForward,-f);h.vec3.add(e.eye,e.center,m);e.markViewDirty();d.scale=g.distanceToScale(a,f,c.latitude)}g.internalToExternal(a,e,d.camera);f=I(d.camera,b)?g.OrientationMode.LOCKED:g.OrientationMode.ADJUST;
return b.zoomFactor?l.resolve(d):(d.scale=H(a,b),null==d.scale&&(w.pointToVector(c,k,a.renderSpatialReference),W.frustum.intersectsPoint(e.frustum,k)?d.scale=g.distanceToScale(a,h.vec3.distance(e.eye,k),c.latitude):d.scale=g.computeScale(a,e)),b=l.createResolver(),g.fromCenterScale(a,d.targetGeometry,d.scale,d.camera,f,b),b.promise.then(function(a){d.camera=a;return d}))}function ba(a,b,c,d){d.targetGeometry=c.clone();var e=x.cameraOnContentAlongViewDirection(a);g.internalToExternal(a,e,d.camera);
b=I(d.camera,b)?g.OrientationMode.LOCKED:g.OrientationMode.ADJUST;e=l.createResolver();g.fromExtent(a,c,d.camera.heading,d.camera.tilt,b,e);return e.promise.then(function(a){d.camera=a;return d})}function ca(a,b,c,d,e){var f=0;c.hasZ?f=c.z:a.basemapTerrain&&(f=a.basemapTerrain.getElevation(c));h.vec3.set(k,c.x,c.y,f);w.computeLinearTransformation(a.spatialReference,k,T,a.renderSpatialReference);h.mat3.fromMat4(E,T);h.mat3.transpose(E,E);p.empty(r);c=[[0,1,2],[3,1,2],[0,4,2],[3,4,2],[0,1,5],[3,1,5],
[0,4,5],[3,4,5]];for(var m=0;m<c.length;m++){var g=c[m],l=d[g[2]];isFinite(l)||(l=f);h.vec3.set(k,d[g[0]],d[g[1]],l);w.vectorToVector(k,a.spatialReference,k,a.renderSpatialReference);p.expand(r,h.vec3.transformMat3(k,k,E))}a=p.width(r);d=p.height(r);f=p.depth(r);c=1/Math.tan(b.fovY/2);return Math.max(.5*Math.sqrt(a*a+f*f)*Math.max(c,1/Math.tan(b.fovX/2))+.5*d,.5*d*c+.5*Math.max(a,f))/e}function da(a,b,c,d,e,f){f.targetGeometry=c.clone();var m=x.cameraOnContentAlongViewDirection(a);c=ca(a,m,c,d,e);
g.internalToExternal(a,m,f.camera);b=I(f.camera,b)?g.OrientationMode.LOCKED:g.OrientationMode.ADJUST;f.scale=g.distanceToScale(a,c,f.targetGeometry.latitude);m=l.createResolver();g.fromCenterScale(a,f.targetGeometry,f.scale,f.camera,b,m);return m.promise.then(function(a){f.camera=a;return f})}function ea(a,b){if(!b||!a.spatialReference)return null;a={target:null};if("declaredClass"in b||Array.isArray(b))a.target=b;else{for(var c in b)a[c]=b[c];b.center&&!a.target&&(a.target=b.center)}return a}function y(a){a&&
(a.rotation=v(a.camera.heading));return a}Object.defineProperty(t,"__esModule",{value:!0});t.DEFAULT_FRAME_COVERAGE=.66;t.rotationToHeading=G;t.headingToRotation=v;t.toCamera=Q;t.fromInternalCamera=function(a,b,c){c||(c=new z({camera:new F}));g.internalToExternal(a,b,c.camera);return B(a,b,c)};t.fromCamera=function(a,b,c){c||(c=new z);c.camera=b.clone();return B(a,null,c)};t.create=function(a,b){var c=ea(a,b);if(!c)return l.reject(new N("viewpointutils-create:no-target","Missing target for creating viewpoint"));
var d=new z({camera:new F({fov:a.camera.fov})}),e=null!=c.scale||null!=c.zoom;if(c.target instanceof z)return Z(a,c.target,c,d).then(function(a){return y(a)});if(c.target instanceof F)return l.resolve(y(S(a,c,c.target,d)));if(c.target instanceof u.Extent)return b=c.target.xmin===c.target.xmax||c.target.ymin===c.target.ymax,e||b?L(a,c,c.target.center,d).then(function(a){return y(a)}):ba(a,c,c.target,d).then(function(a){return y(a)});var f={boundingBox:p.empty(),hasZ:!1,screenSpaceObjects:[]};b=e?g.scaleToResolution(a,
H(a,c)):void 0;return R(a,c.target,b,f).then(function(){if(isFinite(f.boundingBox[0])){p.center(f.boundingBox,k);n.x=k[0];n.y=k[1];n.z=k[2];n.spatialReference=a.spatialReference;var b=void 0;isFinite(n.z)&&f.hasZ?b=p.isPoint(f.boundingBox):(n.z=void 0,b=O.isPoint(p.toRect(f.boundingBox,fa)));if(e||b)return L(a,c,n,d);var b=f.screenSpaceObjects,l=t.DEFAULT_FRAME_COVERAGE;if(b.length){for(var q=Number.NEGATIVE_INFINITY,v=0;v<b.length;v++)var r=b[v].screenSpaceBoundingRect,q=Math.max(q,Math.abs(r[0]),
Math.abs(r[1]),Math.abs(r[2]),Math.abs(r[3]));b=l-q/Math.min(a.width,a.height)*2}else b=l;return da(a,c,n,f.boundingBox,b,d)}if(c.position)return b=x.cameraOnContentAlongViewDirection(a),h.vec3.copy(D,b.viewForward),g.directionToHeadingTilt(a,b.eye,D,b.up,M),d.camera.position=new u.Point(c.position),d.camera.heading=null!=c.heading?c.heading:M.heading,d.camera.tilt=null!=c.tilt?c.tilt:M.tilt,B(a,null,d);b=x.cameraOnContentAlongViewDirection(a);b=w.vectorToPoint(b.center,a.renderSpatialReference,n,
a.spatialReference);return L(a,c,b,d)}).then(function(a){return y(a)})};var k=h.vec3f64.create(),T=h.mat4f64.create(),E=h.mat3f64.create(),r=p.create(),fa=O.create(),D=h.vec3f64.create(),C=h.vec3f64.create(),K=h.vec3f64.create(),M={heading:0,tilt:0},n=new u.Point,X={point:function(a,b,c){c[0]=a.x;c[1]=a.y;a.hasZ&&(c[2]=a.z);b(c)},polygon:function(a,b,c){for(var d=a.hasZ,e=0;e<a.rings.length;e++)for(var f=a.rings[e],g=0;g<f.length;g++)c[0]=f[g][0],c[1]=f[g][1],d&&(c[2]=f[g][2]),b(c)},polyline:function(a,
b,c){for(var d=a.hasZ,e=0;e<a.paths.length;e++)for(var f=a.paths[e],g=0;g<f.length;g++)c[0]=f[g][0],c[1]=f[g][1],d&&(c[2]=f[g][2]),b(c)},multipoint:function(a,b,c){var d=a.points;a=a.hasZ;for(var e=0;e<d.length;e++)c[0]=d[e][0],c[1]=d[e][1],a&&(c[2]=d[e][2]),b(c)},extent:function(a,b,c){a.hasZ?(b(h.vec3.set(c,a.xmin,a.ymin,a.zmin)),b(h.vec3.set(c,a.xmax,a.ymin,a.zmin)),b(h.vec3.set(c,a.xmin,a.ymax,a.zmin)),b(h.vec3.set(c,a.xmax,a.ymax,a.zmin)),b(h.vec3.set(c,a.xmin,a.ymin,a.zmax)),b(h.vec3.set(c,
a.xmax,a.ymin,a.zmax)),b(h.vec3.set(c,a.xmin,a.ymax,a.zmax)),b(h.vec3.set(c,a.xmax,a.ymax,a.zmax))):(b(h.vec3.set(c,a.xmin,a.ymin,c[2])),b(h.vec3.set(c,a.xmax,a.ymin,c[2])),b(h.vec3.set(c,a.xmin,a.ymax,c[2])),b(h.vec3.set(c,a.xmax,a.ymax,c[2])))},mesh:function(a,b,c){if(a=a.vertexAttributes&&a.vertexAttributes.position)for(var d=0;d<a.length;d+=3)b(h.vec3.set(c,a[d+0],a[d+1],a[d+2]))}}});