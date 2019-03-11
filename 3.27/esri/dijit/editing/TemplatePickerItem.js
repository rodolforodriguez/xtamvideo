// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/editing/TemplatePickerItem","dojo/_base/declare dojo/_base/lang dojo/_base/array dojo/has dojo/sniff dojo/dom-style dijit/_Widget dijit/_Templated dojox/gfx ../../symbols/jsonUtils ../../kernel".split(" "),function(c,h,p,l,w,m,q,r,t,u,v){c=c([q,r],{declaredClass:"esri.dijit.editing.TemplatePickerItem",templateString:"\x3cdiv class\x3d'item' style\x3d'text-align: center;'\x3e\x3cdiv class\x3d'itemSymbol' dojoAttachPoint\x3d'_surfaceNode'\x3e\x3c/div\x3e\x3cdiv class\x3d'itemLabel'\x3e${label}\x3c/div\x3e\x3c/div\x3e",
startup:function(){this._started||(this.inherited(arguments),this._surface=this._draw(this._surfaceNode,this.symbol,this.surfaceWidth,this.surfaceHeight,this.template))},_draw:function(b,a,e,c,g){if(a&&"textsymbol"!==a.type){b=t.createSurface(b,e,c);if(9>l("ie")){var f=b.getEventSource();m.set(f,"position","relative");m.set(f.parentNode,"position","relative")}a=!this.legendOverride&&this._getDrawingToolShape(a,g)||u.getShapeDescriptors(a);var k;try{k=b.createShape(a.defaultShape).setFill(a.fill).setStroke(a.stroke)}catch(x){b.clear();
b.destroy();return}var d=k.getBoundingBox();a=d.width;g=d.height;var f=-(d.x+a/2),d=-(d.y+g/2),n=b.getDimensions(),f={dx:f+n.width/2,dy:d+n.height/2};if(a>e||g>c)d=a/e>g/c,e=((d?e:c)-5)/(d?a:g),h.mixin(f,{xx:e,yy:e});k.applyTransform(f);return b}},_getDrawingToolShape:function(b,a){switch(a?a.drawingTool||null:null){case "esriFeatureEditToolArrow":a={type:"path",path:"M 10,1 L 3,8 L 3,5 L -15,5 L -15,-2 L 3,-2 L 3,-5 L 10,1 E"};break;case "esriFeatureEditToolLeftArrow":a={type:"path",path:"M -15,1 L -8,8 L -8,5 L 10,5 L 10,-2 L -8,-2 L -8,-5 L -15,1 E"};
break;case "esriFeatureEditToolRightArrow":a={type:"path",path:"M 10,1 L 3,8 L 3,5 L -15,5 L -15,-2 L 3,-2 L 3,-5 L 10,1 E"};break;case "esriFeatureEditToolUpArrow":a={type:"path",path:"M 1,-10 L 8,-3 L 5,-3 L 5,15 L -2,15 L -2,-3 L -5,-3 L 1,-10 E"};break;case "esriFeatureEditToolDownArrow":a={type:"path",path:"M 1,15 L 8,8 L 5,8 L 5,-10 L -2,-10 L -2,8 L -5,8 L 1,15 E"};break;case "esriFeatureEditToolTriangle":a={type:"path",path:"M -10,14 L 2,-10 L 14,14 L -10,14 E"};break;case "esriFeatureEditToolRectangle":a=
{type:"path",path:"M -10,-10 L 10,-10 L 10,10 L -10,10 L -10,-10 E"};break;case "esriFeatureEditToolCircle":a={type:"circle",cx:0,cy:0,r:10};break;case "esriFeatureEditToolEllipse":a={type:"ellipse",cx:0,cy:0,rx:10,ry:5};break;case "esriFeatureEditToolFreehand":a="simplelinesymbol"===b.type||"cartographiclinesymbol"===b.type?{type:"path",path:"m -11, -7c-1.5,-3.75 7.25,-9.25 12.5,-7c5.25,2.25 6.75,9.75 3.75,12.75c-3,3 -3.25,2.5 -9.75,5.25c-6.5,2.75 -7.25,14.25 2,15.25c9.25,1 11.75,-4 13.25,-6.75c1.5,-2.75 3.5,-11.75 12,-6.5"}:
{type:"path",path:"M 10,-13 c3.1,0.16667 4.42564,2.09743 2.76923,3.69231c-2.61025,2.87179 -5.61025,5.6718 -6.14358,6.20513c-0.66667,0.93333 -0.46667,1.2 -0.53333,1.93333c-0.00001,0.86666 0.6,1.66667 1.13334,2c1.03077,0.38462 2.8,0.93333 3.38974,1.70769c0.47693,0.42564 0.87693,0.75897 1.41026,1.75897c0.13333,1.06667 -0.46667,2.86667 -1.8,3.8c-0.73333,0.73333 -3.86667,2.66666 -4.86667,3.13333c-0.93333,0.8 -7.4,3.2 -7.6,3.06667c-1.06667,0.46667 -4.73333,1.13334 -5.2,1.26667c-1.6,0.33334 -4.6,0.4 -6.25128,0.05128c-1.41539,-0.18462 -2.34872,-2.31796 -1.41539,-4.45129c0.93333,-1.73333 1.86667,-3.13333 2.64615,-3.85641c1.28718,-1.47692 2.57437,-2.68204 3.88718,-3.54359c0.88718,-1.13845 1.8,-1.33333 2.26666,-2.45641c0.33334,-0.74359 0.37949,-1.7641 0.06667,-2.87692c-0.66666,-1.46666 -1.66666,-1.86666 -2.98975,-2.2c-1.27692,-0.26666 -2.12307,-0.64102 -3.27692,-1.46666c-0.66667,-1.00001 -1.01538,-3.01539 0.73333,-4.06667c1.73333,-1.2 3.6,-1.93333 4.93333,-2.2c1.33333,-0.46667 4.84104,-1.09743 5.84103,-1.23076c1.60001,-0.46667 6.02564,-0.50257 7.29231,-0.56924z"};
break;default:return null}return{defaultShape:a,fill:b.getFill(),stroke:b.getStroke()}},_repaint:function(b){b?(b.getStroke&&b.setStroke&&b.setStroke(b.getStroke()),b.getFill&&b.setFill&&b.setFill(b.getFill()),b.children&&h.isArray(b.children)&&p.forEach(b.children,this._repaint,this)):this._surface=this._draw(this._surfaceNode,this.symbol,this.surfaceWidth,this.surfaceHeight,this.template)},destroy:function(){this._surface&&(this._surface.destroy(),delete this._surface);this.inherited(arguments)}});
l("extend-esri")&&h.setObject("dijit.editing.TemplatePickerItem",c,v);return c});