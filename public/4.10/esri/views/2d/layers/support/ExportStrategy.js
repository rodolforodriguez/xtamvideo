// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../../core/tsSupport/assignHelper ../../../../core/promiseUtils ../../../../geometry/Extent ../../../../geometry/support/aaBoundingRect ../../../../geometry/support/spatialReferenceUtils ../../../../layers/support/TileInfo ../../viewStateUtils ../../engine/Bitmap ../../tiling/TileInfoView ../../tiling/TileKey".split(" "),function(y,z,n,l,p,r,t,u,m,v,w,x){var e=r.create(),h=[0,0],q=new x(0,0,0,0),k={container:null,fetchSource:null,requestUpdate:null,imageMaxWidth:2048,
imageMaxHeight:2048,imageRotationSupported:!1,imageNormalizationSupported:!1,hidpi:!1};return function(){function d(a){this._imagePromise=null;this.hidpi=k.hidpi;this.imageMaxWidth=k.imageMaxWidth;this.imageMaxHeight=k.imageMaxHeight;this.imageRotationSupported=k.imageRotationSupported;this.imageNormalizationSupported=k.imageNormalizationSupported;a=n({},k,a);this.container=a.container;this.disposeSource=a.disposeSource;this.fetchSource=a.fetchSource;this.requestUpdate=a.requestUpdate;this.imageMaxWidth=
a.imageMaxWidth;this.imageMaxHeight=a.imageMaxHeight;this.imageRotationSupported=a.imageRotationSupported;this.imageNormalizationSupported=a.imageNormalizationSupported;this.hidpi=a.hidpi;this.requestUpdate()}d.prototype.destroy=function(){};Object.defineProperty(d.prototype,"updating",{get:function(){return null!==this._imagePromise},enumerable:!0,configurable:!0});d.prototype.update=function(a){var c=this,b=a.state,f=t.getInfo(b.spatialReference),g=this.hidpi?a.pixelRatio:1;this._imagePromise&&
(this._imagePromise.cancel(),this._imagePromise=null);if(a.stationary){this.imageRotationSupported?(h[0]=b.size[0],h[1]=b.size[1]):m.getOuterSize(h,b);a=f&&(b.extent.xmin<f.valid[0]||b.extent.xmax>f.valid[1]);a=!this.imageNormalizationSupported&&a;f=this.imageRotationSupported?b.rotation:0;if(Math.floor(h[0]*g)>this.imageMaxWidth||Math.floor(h[1]*g)>this.imageMaxHeight||a){var e=Math.min(this.imageMaxWidth,this.imageMaxHeight);a&&(e=Math.min(b.worldScreenWidth,e));this._imagePromise=this._tiledExport(b,
e,f,g)}else this._imagePromise=this._singleExport(b,h,f,g);this._imagePromise.then(function(a){c._imagePromise=null;var b=c.container.children.slice();c.container.removeAllChildren();a.forEach(c.container.addChild,c.container);c.disposeSource&&b.forEach(function(a){c.disposeSource(a.source)},c)}).catch(function(a){c._imagePromise=null;if("cancel"!==a.dojoType)throw a;})}};d.prototype.updateExports=function(a,c){for(var b=0,f=this.container.children;b<f.length;b++){var g=f[b];if(!g.visible||!g.attached)break;
a(g,c)?console.error("ExportStrategy.updateExports doesn't support promise yet"):g.requestRender()}};d.prototype._export=function(a,c,b,f,g){var e=this;return l.resolve().then(function(){return e.fetchSource(a,Math.floor(c*g),Math.floor(b*g),{rotation:f,pixelRatio:g})}).then(function(b){b=new v.Bitmap(b);b.x=a.xmin;b.y=a.ymax;b.resolution=a.width/c;b.rotation=f;b.pixelRatio=g;return b})};d.prototype._singleExport=function(a,c,b,f){m.getBBox(e,a.center,a.resolution,c);a=new p(e[0],e[1],e[2],e[3],a.spatialReference);
return this._export(a,c[0],c[1],b,f).then(function(a){return[a]})};d.prototype._tiledExport=function(a,c,b,f){var g=this,d=u.create({size:c,spatialReference:a.spatialReference,scales:[a.scale]}),h=new w(d),d=h.getTileCoverage(a);if(!d)return null;var k=[];d.forEach(function(d,l,m,n){q.set(d,l,m,n);h.getTileBounds(e,q);d=new p(e[0],e[1],e[2],e[3],a.spatialReference);k.push(g._export(d,c,c,b,f))});return l.all(k)};return d}()});