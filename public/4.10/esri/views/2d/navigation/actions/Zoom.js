// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../../core/tsSupport/declareExtendsHelper ../../../../core/tsSupport/decorateHelper ../../../../core/Accessor ../../../../core/accessorSupport/decorators".split(" "),function(l,m,h,e,k,c){return function(g){function a(a){a=g.call(this)||this;a._canZoom=!0;return a}h(a,g);a.prototype.scroll=function(a,d){var c=this;if(this._canZoom){var b=d.data;d=b.x;var f=b.y,b=b.deltaY;if(0===b)this.navigation.end();else{this.navigation.begin();var e=Math.pow(.6,1/60*b);a.constraints.snapToZoom?
(this._canZoom=!1,0>b?this.navigation.zoomIn([d,f]).then(function(){c._canZoom=!0}):this.navigation.zoomOut([d,f]).then(function(){c._canZoom=!0})):this.navigation.setViewpoint([d,f],e,0,[0,0])}}};e([c.property()],a.prototype,"navigation",void 0);return a=e([c.subclass("esri.views.2d.navigation.actions.Zoom")],a)}(c.declared(k))});