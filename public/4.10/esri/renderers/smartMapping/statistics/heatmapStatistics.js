// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("require exports ../../../core/tsSupport/assignHelper ../../../core/promiseUtils ../../../layers/support/fieldUtils ./support/utils ../support/utils".split(" "),function(n,p,h,d,k,e,g){function l(a){if(!(a&&a.layer&&a.view))return d.reject(e.createError("heatmap-statistics:missing-parameters","'layer' and 'view' parameters are required"));var b=h({},a);b.blurRadius=null==b.blurRadius?10:b.blurRadius;a=[0,1];var c=g.createLayerAdapter(b.layer,a);return(b.layer=c)?c.load().then(function(){var a=
b.field,f=a?c.getField(a):null,a=g.getFieldsList({field:a});return(a=e.verifyBasicFieldValidity(c,a,"heatmap-statistics:invalid-parameters"))?d.reject(a):f&&(f=e.verifyFieldType(c,f,"heatmap-statistics:invalid-parameters",m))?d.reject(f):b}):d.reject(e.createError("heatmap-statistics:invalid-parameters","'layer' must be one of these types: "+g.getLayerTypeLabels(a).join(", ")))}var m=k.numericTypes;return function(a){return l(a).then(function(a){return a.layer.heatmapStatistics({field:a.field,fieldOffset:a.fieldOffset,
blurRadius:a.blurRadius,features:a.features,view:a.view})})}});