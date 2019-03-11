// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/metadata/types/arcgis/form/MinNumberElement","dojo/_base/declare dojo/_base/lang dojo/has ../../../../../kernel ../../../base/etc/docUtil ../../../form/OpenElement dojo/i18n!../../../nls/i18nArcGIS".split(" "),function(e,f,l,m,n,p,q){e=e([p],{conditionalMessage:null,postCreate:function(){this.inherited(arguments)},afterValidateValue:function(e,g,d){var b=this.target,c=null;"minVal"===b?c="maxVal":"rdommin"===b?c="rdommax":"vertMinVal"===b&&(c="vertMaxVal");if(null!==c){null===this.conditionalMessage&&
(this.conditionalMessage=q.conditionals.minLessThanMax);null!==a&&(d=f.trim(d));var h=null===d||0===d.length;if(g.isValid||h){var b=!1,k=n.findInputWidget(this.parentElement.gxePath+"/"+c,this.domNode.parentNode),a=k.getInputValue();null!==a&&(a=f.trim(a));if(null===a||0===a.length)h||(b=!0);else if(h)b=!0;else if(c={inputWidget:k,label:c,isValid:!0},e._checkNumber(c,a),c.isValid)try{d=Number(d),a=Number(a),d>=a&&(b=!0)}catch(r){console.error(r)}else b=!0;b&&(g.isValid=!1,g.message=this.conditionalMessage)}}}});
l("extend-esri")&&f.setObject("dijit.metadata.types.arcgis.form.MinNumberElement",e,m);return e});