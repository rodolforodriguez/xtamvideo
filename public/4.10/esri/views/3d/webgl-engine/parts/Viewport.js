// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../../core/has ../../../../core/libs/gl-matrix-2/gl-matrix ../lib/Camera ../lib/PerformanceTimer ./Visualizer".split(" "),function(k,l,m,e,f,n,g){var c={fbo:null,lightDirection:null,camera:null,pixelRatio:1,disableSlice:!1};return function(){function a(b,a,h,d,c){this._content=new Map;this._stats={renderGeometriesTotal:0,renderGeometriesVisible:0,visualizerRenderTimer:null,viewportRenderTimer:null};this._needsRender=!0;this._rctx=c;this._gl=c.gl;this._visualizer=new g(b,
a,h,d,this._rctx);this._camera=new f(e.vec3f64.fromValues(0,100,-100))}Object.defineProperty(a.prototype,"isLoadingResources",{get:function(){return this._visualizer.isLoadingResources},enumerable:!0,configurable:!0});a.prototype.getCombinedStats=function(){var b={},a=this._visualizer.getCombinedStats(),c;for(c in a)b[c]=a[c];b.renderGeometriesTotal=this._stats.renderGeometriesTotal;b.renderGeometriesVisible=this._stats.renderGeometriesVisible;void 0!==this._gl.getUsedTextureMemory&&(b.textureMemory=
this._gl.getUsedTextureMemory());void 0!==this._gl.getUsedRenderbufferMemory&&(b.renderbufferMemory=this._gl.getUsedRenderbufferMemory());void 0!==this._gl.getUsedVBOMemory&&(b.VBOMemory=this._gl.getUsedVBOMemory());if(void 0!==this._gl.getUsedTextureMemoryStats){var a=this._gl.getUsedTextureMemoryStats(),d;for(d in a)b["texMem type: "+d]=a[d]}return b};a.prototype.dispose=function(){this._visualizer.dispose();this._visualizer=null};a.prototype.setLighting=function(b){this._visualizer.setLighting(b)};
a.prototype.setRenderParams=function(b){this._visualizer.setRenderParams(b)};a.prototype.getRenderParams=function(){return this._visualizer.getRenderParams()};a.prototype.getEdgeView=function(){return this._visualizer.getEdgeView()};a.prototype.modify=function(b,a,c,d){this._visualizer.modify(b,a,c,d);this._content=this._visualizer.getContent()};a.prototype.getContent=function(){return this._content};a.prototype.setCamera=function(a){this._camera.copyFrom(a);this._needsRender=!0};a.prototype.getCamera=
function(){return this._camera};Object.defineProperty(a.prototype,"renderPlugins",{get:function(){return this._visualizer.renderPlugins},enumerable:!0,configurable:!0});a.prototype.getFramebufferTexture=function(a){return this._visualizer.getFramebufferTexture(a)};a.prototype.render=function(a){c.camera=a.camera||this._camera;c.fbo=a.fbo;c.lightDirection=a.lightDirection;c.pixelRatio=a.pixelRatio||1;c.disableSlice=a.disableSlice||!1;this._visualizer.render(c)};a.prototype.resetNeedsRender=function(){this._needsRender=
!1;this._visualizer.resetNeedsRender()};a.prototype.needsRender=function(){return this._needsRender||this._visualizer.needsRender()};return a}()});