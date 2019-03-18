// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../core/tsSupport/declareExtendsHelper ../core/tsSupport/decorateHelper dojo/i18n!./AreaMeasurement2D/nls/AreaMeasurement2D ../core/accessorSupport/decorators ./Widget ./AreaMeasurement2D/AreaMeasurement2DViewModel ./support/widget".split(" "),function(t,u,q,b,e,d,r,g,a){return function(h){function c(a){a=h.call(this)||this;a.active=null;a.iconClass="esri-icon-description";a.label=e.title;a.unit=null;a.unitOptions=null;a.view=null;a.viewModel=new g;return a}q(c,h);c.prototype.render=
function(){var c=this,b=this.viewModel.isSupported,d=this.viewModel.active,g="disabled"===this.viewModel.state,m="ready"===this.viewModel.state,n="measuring"===this.viewModel.state,k=this.viewModel.measurementLabel,m=d&&m?a.tsx("section",{key:"hint",class:"esri-area-measurement-3d__hint"},a.tsx("p",{class:"esri-area-measurement-3d__hint-text"},e.hint)):null,h=b?null:a.tsx("section",{key:"unsupported",class:"esri-area-measurement-3d__panel--error"},a.tsx("p",null,e.unsupported)),f=function(b,d,p){return d?
a.tsx("div",{key:p+"-enabled",class:"esri-area-measurement-3d__measurement-item"},a.tsx("span",{class:"esri-area-measurement-3d__measurement-item-title"},b),a.tsx("span",{class:"esri-area-measurement-3d__measurement-item-value"},d)):a.tsx("div",{key:p+"-disabled",class:c.classes("esri-area-measurement-3d__measurement-item","esri-area-measurement-3d__measurement-item--disabled"),"aria-disabled":"true"},a.tsx("span",{class:"esri-area-measurement-3d__measurement-item-title"},b))},k=n?a.tsx("section",
{key:"measurement",class:"esri-area-measurement-3d__measurement"},f(e.area,k.area,"area"),f(e.perimeter,k.perimeter,"perimeter")):null,f=this.id+"__units",f=a.tsx("section",{key:"units",class:"esri-area-measurement-3d__units"},a.tsx("label",{class:"esri-area-measurement-3d__units-label",for:f},e.unit),a.tsx("div",{class:"esri-area-measurement-3d__units-select-wrapper"},a.tsx("select",{class:"esri-area-measurement-3d__units-select esri-select",id:f,onchange:this._changeUnit,bind:this,value:this.viewModel.unit},
this.viewModel.unitOptions.map(function(b){return a.tsx("option",{key:b,value:b},e.units[b])})))),l=this.id+"__modes",l=a.tsx("section",{key:"modes",class:"esri-area-measurement-3d__units"},a.tsx("label",{class:"esri-area-measurement-3d__units-label",for:l},e.mode),a.tsx("div",{class:"esri-area-measurement-3d__units-select-wrapper"},a.tsx("select",{class:"esri-area-measurement-3d__units-select esri-select",id:l,onchange:this._changeMode,bind:this,value:this.viewModel.mode},this.viewModel.modes.map(function(b){return a.tsx("option",
{key:b,value:b},e.modes[b])})))),f=n?a.tsx("div",{key:"settings",class:"esri-area-measurement-3d__settings"},f,l):null,b=!b||d&&!n?null:a.tsx("div",{class:"esri-area-measurement-3d__actions"},a.tsx("button",{disabled:g,class:this.classes("esri-button esri-button--secondary","esri-area-measurement-3d__clear-button",g&&"esri-button--disabled"),bind:this,onclick:this._newMeasurement,title:e.newMeasurement,"aria-label":e.newMeasurement},e.newMeasurement)),b=this.visible?a.tsx("div",{class:"esri-area-measurement-3d__container"},
h,m,f,k,b):null;return a.tsx("div",{class:"esri-area-measurement-3d esri-widget esri-widget--panel"},b)};c.prototype._newMeasurement=function(){this.viewModel.newMeasurement()};c.prototype._changeUnit=function(a){a=a.target;if(a=a.options[a.selectedIndex])this.viewModel.unit=a.value};c.prototype._changeMode=function(a){a=a.target;if(a=a.options[a.selectedIndex])this.viewModel.mode=a.value};b([d.aliasOf("viewModel.active"),a.renderable()],c.prototype,"active",void 0);b([d.property()],c.prototype,"iconClass",
void 0);b([d.property()],c.prototype,"label",void 0);b([d.aliasOf("viewModel.unit")],c.prototype,"unit",void 0);b([d.aliasOf("viewModel.unitOptions")],c.prototype,"unitOptions",void 0);b([d.aliasOf("viewModel.view")],c.prototype,"view",void 0);b([d.property({type:g}),a.renderable(["viewModel.state","viewModel.unitOptions","viewModel.unit","viewModel.measurementLabel"])],c.prototype,"viewModel",void 0);b([d.aliasOf("viewModel.visible"),a.renderable()],c.prototype,"visible",void 0);b([a.accessibleHandler()],
c.prototype,"_newMeasurement",null);b([a.accessibleHandler()],c.prototype,"_changeUnit",null);b([a.accessibleHandler()],c.prototype,"_changeMode",null);return c=b([d.subclass("esri.widgets.AreaMeasurement2D")],c)}(d.declared(r))});