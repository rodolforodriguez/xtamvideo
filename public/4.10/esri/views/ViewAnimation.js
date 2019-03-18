// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../core/tsSupport/declareExtendsHelper ../core/tsSupport/decorateHelper ../core/Accessor ../core/Error ../core/Promise ../core/promiseUtils ../core/promiseUtils ../core/scheduling ../core/accessorSupport/decorators".split(" "),function(b,n,f,d,g,h,k,l,m,e,c){b=function(b){function a(a){a=b.call(this)||this;a.state="running";a.target=null;return a}f(a,b);a.prototype.initialize=function(){var a=this;this.addResolvingPromise(l.create(function(b,c){a._dfd={resolve:b,reject:c}}))};
Object.defineProperty(a.prototype,"done",{get:function(){return"finished"===this.state||"stopped"===this.state},enumerable:!0,configurable:!0});a.prototype.stop=function(){"stopped"!==this.state&&"finished"!==this.state&&(this._set("state","stopped"),e.schedule(this._dfd.reject.bind(this._dfd,new h("ViewAnimation stopped"))))};a.prototype.finish=function(){"stopped"!==this.state&&"finished"!==this.state&&(this._set("state","finished"),e.schedule(this._dfd.resolve))};a.prototype.update=function(a,
b){b||(b=m.isThenable(a)?"waiting-for-target":"running");this._set("target",a);this._set("state",b)};d([c.property({readOnly:!0,dependsOn:["state"]})],a.prototype,"done",null);d([c.property({readOnly:!0,type:String})],a.prototype,"state",void 0);d([c.property()],a.prototype,"target",void 0);return a=d([c.subclass("esri.views.ViewAnimation")],a)}(c.declared(g,k));(b||(b={})).State={RUNNING:"running",STOPPED:"stopped",FINISHED:"finished",WAITING_FOR_TARGET:"waiting-for-target"};return b});