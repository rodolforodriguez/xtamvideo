// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../../../core/tsSupport/extendsHelper ../../../../../core/libs/gl-matrix-2/gl-matrix ../../../camera/constraintUtils ../../../input/util ../InteractiveController ../momentum/PanPlanarMomentumController ../momentum/PanSphericalMomentumController ../momentum/RotationMomentumController ../momentum/ZoomPlanarMomentumController ../momentum/ZoomSphericalMomentumController ../../utils/navigationUtils ../../utils/navigationUtils ../../../support/geometryUtils ../../../support/geometryUtils ../../../support/mathUtils ../../../webgl-engine/lib/Camera ../../../../navigation/PanPlanarMomentumEstimator ../../../../navigation/PanSphericalMomentumEstimator ../../../../navigation/RotationMomentumEstimator ../../../../navigation/ZoomMomentumEstimator".split(" "),
function(k,n,r,d,g,p,t,u,v,w,x,y,e,l,h,m,q,z,A,B,C,D){Object.defineProperty(n,"__esModule",{value:!0});k=function(k){function f(a,c){var b=k.call(this)||this;b.view=a;b.intersectionHelper=c;b.smoothRotation=new p.ExponentialFalloff(.05);b.rotationAxis=d.vec3f64.create();b.panningPlane=m.plane.create();b.smoothScaling=new p.ExponentialFalloff(.05);b.zoomCenterScreen=d.vec2f64.create();b.zoomMomentumEstimator=new D.ZoomMomentumEstimator;b.rotationMomentumEstimator=new C.RotationMomentumEstimator;b.panSphericalMomentumEstimator=
new B.PanSphericalMomentumEstimator;b.panPlanarMomentumEstimator=new A.PanPlanarMomentumEstimator;b.adjustedSphere=h.sphere.create();b.tmp2d=d.vec2f64.create();b.tmp3d=d.vec3f64.create();b.tmpMat=d.mat4f64.create();b.tmpAxisAngle=h.axisAngle.create();b.beginScreenPoint=d.vec2f64.create();b.beginScenePoint=d.vec3f64.create();b.screenPickPoint=d.vec2f64.create();b.panMode=l.PanMode.Horizontal;b.tmpInteractionDirection=d.vec3f64.create();b.constraintOptions={selection:15,interactionType:0,interactionFactor:0,
interactionStartCamera:new z,interactionDirection:null,tiltMode:0};return b}r(f,k);f.prototype.begin=function(a){if(this.active){this.beginHeading=-q.cyclicalPI.normalize(q.deg2rad(this.view.camera.heading));this.beginRadius=a.radius;this.pointerCount=a.pointers.size;this.beginAngle=a.angle;this.smoothRotation.reset();e.navPointToScreenPoint(this.currentCamera,a.center,this.screenPickPoint);d.vec2.copy(this.beginScreenPoint,this.screenPickPoint);var c=e.pickPointAndInitSphere(this.intersectionHelper,
this.beginCamera,this.screenPickPoint,!0);this.scenePickPoint=c.scenePickPoint;this.sphere=c.sphere;d.vec3.copy(this.beginScenePoint,this.scenePickPoint);this.panMode=e.decidePanMode(this.beginCamera,this.sphere,this.scenePickPoint);this.panMode===l.PanMode.Vertical&&(this.beginCamera.aboveGround?this.preparePlanarPanModeOverground(a):this.preparePlanarPanMode(a));this.constraintOptions.interactionStartCamera.copyFrom(this.beginCamera)}};f.prototype.preparePlanarPanModeOverground=function(a){var c=
d.vec3.negate(this.tmp3d,this.beginCamera.viewForward);m.plane.fromPositionAndNormal(this.scenePickPoint,c,this.panningPlane);c=d.vec3f64.create();d.vec3.set(c,this.screenPickPoint[0],this.currentCamera.fullHeight,0);var b=d.vec3f64.create(),f=d.vec3.length(this.beginCamera.eye);this.adjustedSphere.radius=f<this.sphere.radius?f-100:this.sphere.radius;e.sphereOrPlanePointFromScreenPoint(this.adjustedSphere,this.beginCamera,c,b);this.beginCamera.projectPoint(b,c);this.screenPickPoint[1]=Math.min(this.screenPickPoint[1],
.9*c[1]);this.intersectionHelper.intersectScreen(this.screenPickPoint,this.scenePickPoint)&&m.plane.fromPositionAndNormal(this.scenePickPoint,this.panningPlane,this.panningPlane);e.navPointToScreenPoint(this.currentCamera,a.center,this.tmp2d);e.intersectPlaneFromScreenPoint(this.panningPlane,this.beginCamera,this.tmp2d,this.beginScenePoint)};f.prototype.preparePlanarPanMode=function(a){var c=d.vec3.negate(this.tmp3d,this.beginCamera.viewForward);m.plane.fromPositionAndNormal(this.scenePickPoint,c,
this.panningPlane);var b=h.sphere.angleToSilhouette(this.sphere,this.currentCamera.eye),c=h.axisAngle.fromPoints(this.currentCamera.eye,this.scenePickPoint,this.tmpAxisAngle),b=-c[3]-(this.currentCamera.aboveGround?.25:.025)*b;if(0<b){var f=d.mat4.identity(this.tmpMat);d.mat4.rotate(f,f,-b,c);d.vec3.subtract(this.scenePickPoint,this.scenePickPoint,this.sphere.center);d.vec3.transformMat4(this.scenePickPoint,this.scenePickPoint,f);d.vec3.add(this.scenePickPoint,this.scenePickPoint,this.sphere.center);
m.plane.setOffsetFromPoint(this.panningPlane,this.scenePickPoint,this.panningPlane);e.navPointToScreenPoint(this.currentCamera,a.center,this.tmp2d);e.intersectPlaneFromScreenPoint(this.panningPlane,this.beginCamera,this.tmp2d,this.beginScenePoint)}};f.prototype.update=function(a){if(this.active){this.currentCamera.copyFrom(this.beginCamera);var c=1<a.pointers.size;this.panMode===l.PanMode.Horizontal?(c&&this.zoomSpherical(a),this.panningSpherical(a),c&&this.rotateSpherical(a)):(c&&this.zoomPlanar(a),
this.panningPlanar(a),c&&this.rotatePlanar(a));this.currentCamera.markViewDirty()}};f.prototype.end=function(a){a.pointers.size===this.pointerCount&&this.update(a);this.finishController();if(a=this.zoomMomentumEstimator.evaluateMomentum())return this.panMode===l.PanMode.Horizontal?new y.ZoomSphericalMomentumController(this.view,a,this.zoomCenterScreen,this.beginScenePoint,this.sphere.radius):new x.ZoomPlanarMomentumController(this.view,a,this.beginScenePoint);if(a=this.rotationMomentumEstimator.evaluateMomentum())return new w.RotationMomentumController(this.view,
a,this.sphere.center,this.rotationAxis);if(this.panMode===l.PanMode.Horizontal){if(a=this.panSphericalMomentumEstimator.evaluateMomentum())return new v.PanSphericalMomentumController(this.view,a)}else if(a=this.panPlanarMomentumEstimator.evaluateMomentum())return new u.PanPlanarMomentumController(this.view,a);return null};f.prototype.zoomSpherical=function(a){var c=this.beginRadius/a.radius;this.smoothScaling.gain=.001875*Math.min(Math.max(a.radius,40),120);this.smoothScaling.update(c);e.applyZoomOnSphere(this.sphere,
this.currentCamera,this.smoothScaling.value);e.navPointToScreenPoint(this.currentCamera,a.center,this.zoomCenterScreen);this.zoomMomentumEstimator.add(this.smoothScaling.value,.001*a.timestamp);this.constraintOptions.interactionType=1;this.constraintOptions.interactionFactor=g.pixelDistanceToInteractionFactor(a.radius-this.beginRadius);g.applyAll(this.view,this.currentCamera,this.constraintOptions)};f.prototype.panningSpherical=function(a){e.navPointToScreenPoint(this.currentCamera,a.center,this.tmp2d);
e.sphereOrPlanePointFromScreenPoint(this.sphere,this.currentCamera,this.tmp2d,this.tmp3d);e.preserveHeadingThreshold(this.beginScenePoint,d.vec3.dot(this.currentCamera.up,this.beginScenePoint),this.sphere.radius,.95,Math.PI/10,this.beginHeading,this.view.camera.tilt,this.beginCamera)?(e.applyPanSphericalPreserveHeading(this.sphere,this.currentCamera,this.beginScenePoint,this.tmp3d,this.beginHeading,this.view.camera.tilt,!1),this.panSphericalMomentumEstimator.addMomentumPreserveHeading(this.tmp2d,
this.tmp3d,.001*a.timestamp,this.beginCamera,this.sphere,this.beginHeading,this.view.camera.tilt)):(e.applyPanSphericalDirectRotation(this.sphere,this.currentCamera,this.beginScenePoint,this.tmp3d,this.view.camera.tilt,!1),this.panSphericalMomentumEstimator.addMomentumDirectRotation(this.tmp2d,this.tmp3d,.001*a.timestamp,this.beginCamera,this.sphere.radius,this.view.camera.tilt));this.constraintOptions.interactionType=4;this.constraintOptions.interactionFactor=g.pixelDistanceToInteractionFactor(this.screenPickPoint,
this.tmp2d);g.applyAll(this.view,this.currentCamera,this.constraintOptions)};f.prototype.rotateSpherical=function(a){d.vec3.normalize(this.rotationAxis,this.scenePickPoint);var c=this.smoothRotation.value,b=e.normalizeRotationDelta(a.angle-c),c=c+b;this.smoothRotation.gain=.00125*Math.min(Math.max(a.radius,40),120);this.smoothRotation.update(c);b=this.smoothRotation.value-this.beginAngle;this.rotationMomentumEstimator.add(b,.001*a.timestamp);e.applyRotation(this.currentCamera,this.sphere.center,h.axisAngle.wrapAxisAngle(this.rotationAxis,
b));this.constraintOptions.interactionType=2;this.constraintOptions.interactionFactor=g.pixelDistanceToInteractionFactor(a.radius*c);g.applyAll(this.view,this.currentCamera,this.constraintOptions)};f.prototype.panningPlanar=function(a){e.navPointToScreenPoint(this.currentCamera,a.center,this.tmp2d);e.intersectPlaneFromScreenPoint(this.panningPlane,this.currentCamera,this.tmp2d,this.tmp3d)&&(e.applyPanPlanar(this.currentCamera,this.beginScenePoint,this.tmp3d),this.panPlanarMomentumEstimator.add(this.tmp2d,
this.tmp3d,.001*a.timestamp),this.constraintOptions.interactionType=4,this.constraintOptions.interactionFactor=g.pixelDistanceToInteractionFactor(this.beginScreenPoint,this.tmp2d),this.constraintOptions.interactionDirection=this.view.renderCoordsHelper.worldUpAtPosition(this.currentCamera.eye,this.tmpInteractionDirection),g.applyAll(this.view,this.currentCamera,this.constraintOptions),this.constraintOptions.interactionDirection=null)};f.prototype.zoomPlanar=function(a){var c=this.beginRadius/a.radius;
this.smoothScaling.gain=.001875*Math.min(Math.max(a.radius,40),120);this.smoothScaling.update(c);this.zoomMomentumEstimator.add(this.smoothScaling.value,.001*a.timestamp);e.applyZoomToPoint(this.currentCamera,this.beginScenePoint,this.smoothScaling.value,this.view.state.constraints.minimumPoiDistance);this.constraintOptions.interactionType=1;this.constraintOptions.interactionFactor=g.pixelDistanceToInteractionFactor(a.radius-this.beginRadius);g.applyAll(this.view,this.currentCamera,this.constraintOptions)};
f.prototype.rotatePlanar=function(a){d.vec3.copy(this.rotationAxis,this.beginScenePoint);var c=this.smoothRotation.value,b=a.angle-c,b=e.normalizeRotationDelta(b);this.smoothRotation.gain=.00125*Math.min(Math.max(a.radius,40),120);this.smoothRotation.update(c+b);c=this.smoothRotation.value-this.beginAngle;this.rotationMomentumEstimator.add(c,.001*a.timestamp);e.applyRotation(this.currentCamera,this.sphere.center,h.axisAngle.wrapAxisAngle(this.rotationAxis,c));this.constraintOptions.interactionType=
2;this.constraintOptions.interactionFactor=g.pixelDistanceToInteractionFactor(a.radius*c);g.applyAll(this.view,this.currentCamera,this.constraintOptions)};return f}(t.InteractiveController);n.PinchAndPanController=k});