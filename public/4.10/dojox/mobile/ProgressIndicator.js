//>>built
define("dojo/_base/config dojo/_base/declare dojo/_base/lang dojo/dom-class dojo/dom-construct dojo/dom-geometry dojo/dom-style dojo/has dijit/_Contained dijit/_WidgetBase ./_css3 dojo/has!dojo-bidi?dojox/mobile/bidi/ProgressIndicator".split(" "),function(r,f,t,g,c,h,k,l,m,n,p,q){var a=f("dojox.mobile.ProgressIndicator",[n,m],{interval:100,size:40,removeOnStop:!0,startSpinning:!1,center:!0,colors:null,baseClass:"mblProgressIndicator",constructor:function(){this.colors=[];this._bars=[]},buildRendering:function(){this.inherited(arguments);
this.center&&g.add(this.domNode,"mblProgressIndicatorCenter");this.containerNode=c.create("div",{className:"mblProgContainer"},this.domNode);this.spinnerNode=c.create("div",null,this.containerNode);for(var b=0;12>b;b++){var a=c.create("div",{className:"mblProg mblProg"+b},this.spinnerNode);this._bars.push(a)}this.scale(this.size);this.startSpinning&&this.start()},scale:function(b){var a=b/40;k.set(this.containerNode,p.add({},{transform:"scale("+a+")",transformOrigin:"0 0"}));h.setMarginBox(this.domNode,
{w:b,h:b});h.setMarginBox(this.containerNode,{w:b/a,h:b/a})},start:function(){if(this.imageNode){var a=this.imageNode;a.style.margin=Math.round((this.containerNode.offsetHeight-a.offsetHeight)/2)+"px "+Math.round((this.containerNode.offsetWidth-a.offsetWidth)/2)+"px"}else{var d=0,c=this;this.timer=setInterval(function(){d--;d=0>d?11:d;for(var a=c.colors,b=0;12>b;b++){var e=(d+b)%12;a[e]?c._bars[b].style.backgroundColor=a[e]:g.replace(c._bars[b],"mblProg"+e+"Color","mblProg"+(11===e?0:e+1)+"Color")}},
this.interval)}},stop:function(){this.timer&&clearInterval(this.timer);this.timer=null;this.removeOnStop&&this.domNode&&this.domNode.parentNode&&this.domNode.parentNode.removeChild(this.domNode)},setImage:function(a){a?(this.imageNode=c.create("img",{src:a},this.containerNode),this.spinnerNode.style.display="none"):(this.imageNode&&(this.containerNode.removeChild(this.imageNode),this.imageNode=null),this.spinnerNode.style.display="")},destroy:function(){this.inherited(arguments);this===a._instance&&
(a._instance=null)}}),a=l("dojo-bidi")?f("dojox.mobile.ProgressIndicator",[a,q]):a;a._instance=null;a.getInstance=function(b){a._instance||(a._instance=new a(b));return a._instance};return a});