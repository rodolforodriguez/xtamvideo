// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define(["../../core/declare","../../core/lang"],function(b,d){b=b(null,{declaredClass:"esri.layers.support.ImageServiceParameters",extent:null,width:null,height:null,imageSpatialReference:null,format:null,interpolation:null,compressionQuality:null,bandIds:null,timeExtent:null,mosaicRule:null,renderingRule:null,noData:null,compressionTolerance:null,adjustAspectRatio:null,toJSON:function(c){var a=this.bbox||this.extent;c=(a=a&&c&&a.clone()._normalize(!0))?a.spatialReference.wkid||JSON.stringify(a.spatialReference.toJSON()):
null;var b=this.imageSpatialReference,a={bbox:a?a.xmin+","+a.ymin+","+a.xmax+","+a.ymax:null,bboxSR:c,size:null!==this.width&&null!==this.height?this.width+","+this.height:null,imageSR:b?b.wkid||JSON.stringify(b.toJSON()):c,format:this.format,interpolation:this.interpolation,compressionQuality:this.compressionQuality,bandIds:this.bandIds?this.bandIds.join(","):null,mosaicRule:this.mosaicRule?JSON.stringify(this.mosaicRule.toJSON()):null,renderingRule:this.renderingRule?JSON.stringify(this.renderingRule.toJSON()):
null,noData:this.noData,noDataInterpretation:this.noDataInterpretation,compressionTolerance:this.compressionTolerance,adjustAspectRatio:this.adjustAspectRatio};c=this.timeExtent;a.time=c?c.toJSON().join(","):null;return d.filter(a,function(a){if(null!==a&&void 0!==a)return!0})}});d.mixin(b,{INTERPOLATION_BILINEAR:"RSP_BilinearInterpolation",INTERPOLATION_CUBICCONVOLUTION:"RSP_CubicConvolution",INTERPOLATION_MAJORITY:"RSP_Majority",INTERPOLATION_NEARESTNEIGHBOR:"RSP_NearestNeighbor",NODATA_MATCH_ALL:"esriNoDataMatchAll",
NODATA_MATCH_ANY:"esriNoDataMatchAny"});return b});