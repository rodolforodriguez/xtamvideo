// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../core/tsSupport/declareExtendsHelper ../../../core/tsSupport/decorateHelper ../../../Graphic ../../../core/Accessor ../../../core/Collection ../../../core/Promise ../../../core/accessorSupport/decorators".split(" "),function(m,n,e,c,f,g,h,k,b){var l=h.ofType(f);return function(d){function a(a){a=d.call(this)||this;a.type="memory";a.updating=!1;return a}e(a,d);c([b.property({readOnly:!0})],a.prototype,"type",void 0);c([b.property({constructOnly:!0})],a.prototype,"layer",
void 0);c([b.property({constructOnly:!0})],a.prototype,"layerView",void 0);c([b.property({type:l,constructOnly:!0})],a.prototype,"graphics",void 0);c([b.property({readOnly:!0})],a.prototype,"updating",void 0);return a=c([b.subclass("esri.layers.graphics.controllers.MemoryController")],a)}(b.declared(g,k))});