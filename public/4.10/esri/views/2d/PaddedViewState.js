// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../core/tsSupport/declareExtendsHelper ../../core/tsSupport/decorateHelper ../../core/Accessor ../../core/accessorSupport/decorators ./../../core/libs/gl-matrix-2/gl-matrix ./viewpointUtils ./ViewState".split(" "),function(p,q,k,e,m,b,g,n,l){var h=function(f){function a(){var d=null!==f&&f.apply(this,arguments)||this;d.left=0;d.top=0;d.right=0;d.bottom=0;return d}k(a,f);e([b.property()],a.prototype,"left",void 0);e([b.property()],a.prototype,"top",void 0);e([b.property()],
a.prototype,"right",void 0);e([b.property()],a.prototype,"bottom",void 0);return a=e([b.subclass("esri.views.2d.PaddedViewState.Padding")],a)}(b.declared(m));return function(f){function a(){for(var d=[],a=0;a<arguments.length;a++)d[a]=arguments[a];var c=f.apply(this,d)||this;c.content=new l;c._updateContent=function(){var a=g.vec2f64.create();return function(){var d=c._get("size"),b=c._get("padding");if(d&&b){var e=c.content;g.vec2.set(a,b.left+b.right,b.top+b.bottom);g.vec2.subtract(a,d,a);g.vec2.copy(e.size,
a);if(d=e.viewpoint)c.viewpoint=d}}}();c.watch(["size","padding"],c._updateContent,!0);c.padding=new h;c.size=[0,0];return c}k(a,f);Object.defineProperty(a.prototype,"padding",{set:function(a){this._set("padding",a||new h)},enumerable:!0,configurable:!0});Object.defineProperty(a.prototype,"viewpoint",{set:function(a){if(a){var b=a.clone();this.content.viewpoint=a;n.addPadding(b,a,this._get("size"),this._get("padding"));a=this._viewpoint2D;var c=b.targetGeometry;a.center[0]=c.x;a.center[1]=c.y;a.rotation=
b.rotation;a.scale=b.scale;a.spatialReference=c.spatialReference;this._update()}},enumerable:!0,configurable:!0});e([b.property()],a.prototype,"content",void 0);e([b.property({type:h})],a.prototype,"padding",null);e([b.property()],a.prototype,"viewpoint",null);return a=e([b.subclass("esri.views.2d.PaddedViewState")],a)}(b.declared(l))});