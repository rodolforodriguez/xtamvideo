// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/layers/rasterLib/raster/TileRaster","require dojo/_base/declare dojo/_base/lang dojo/_base/Deferred dojo/_base/array dojo/_base/config dojo/_base/json dojo/sniff dojo/DeferredList dojo/when ../../../kernel ../../../Evented ../../../request ../../../geometry/Extent ../../../geometry/Point ../../../SpatialReference ../../../deferredUtils ../../../urlUtils ../../PixelBlock ../../rasterFormats/rasterCodec ../tile/RasterTileInfo ./RasterInfo ./BasicRaster".split(" "),function(h,m,g,k,z,A,
B,n,C,p,q,D,l,r,t,u,E,F,G,H,v,w,x){h=m([x],{declaredClass:"esri.layers.rasterLib.raster.TileRaster",sourceType:"TileCache",_RECORD_SIZE:8,constructor:function(b){},open:function(){var b=new k,a=this.datasetInfo||this._getDatasetInfo(null),c=g.hitch(this,function(a){this.datasetInfo=a;this.rasterInfo=a=this._parseRasterInfo(a);this.tileType="Cache/LERC"===a.format?"Elevation":"Cache/MIXED"===a.format||"Cache/JPEG"===a.format||"Cache/PNG"===a.format?"Map":"Raster";this.tileInfo=a.tileInfo;this.dataType=
["Generic","Elevation","Processed"][["Raster","Elevation","Map"].indexOf(this.tileType)];this._HEADER_SIZE=a.packetSize*a.packetSize*this._RECORD_SIZE+64;this.loaded=!0;this._getRasterIdentifier();b.resolve(this)}),d=g.hitch(this,function(a){this.loaded=!0;this._getRasterIdentifier();b.reject(a)});p(a,c,d);return b.promise},read:function(b){var a=new k,c=b.level,d=b.row,e=b.col,f=this._buildCacheFilePath(this.url,c,d,e),y=this._getIndexRecordFromBundle(c,d,e);l({url:f,content:{},headers:{Range:"bytes\x3d0-"+
(this._HEADER_SIZE-1).toString()},handleAs:"arraybuffer"}).then(g.hitch(this,function(c,d){if(!a.isCanceled()){console.log("time in ms request "+(new Date-e));var e=new Date;c=new Uint8Array(c);c=this._getTileEndAndContentType(c,y);d={width:this.tileInfo.cols,height:this.tileInfo.rows,planes:null,pixelType:null,format:null,decodeFunc:null,isPoint:"elevation"===this.tileType.toLowerCase()?!0:!1};this._requestPixels({url:f+(this.disableClientCaching?"?_ts\x3d "+(new Date).getTime():""),payload:{},headers:{Range:"bytes\x3d"+
c.position.toString()+"-"+(c.position+c.recordSize).toString()},decodeParams:d,tileOptions:b}).then(function(b){a.isCanceled()||a.resolve(b)},function(b){a.isCanceled()||a.reject(b)})}}));return a.promise},identify:function(){return null},setFetchParameters:function(b,a){},toJson:function(){return{url:this.url,tileInfo:this.tileInfo.toJson(),rasterInfo:this.rasterInfo.toJson(),datasetInfo:this.datasetInfo,sourceType:this.sourceType,tileType:this.tileType,_rasterId:this._rasterId}},_getDatasetInfo:function(){return l({url:this.url+
"/conf.json",handleAs:"json",content:{}})},_parseRasterInfo:function(b){var a=new w,c;switch(b.pixelType){case 1:c="U1";break;case 1:c="U2";break;case 2:c="U4";break;case 3:c="U8";break;case 4:c="S8";break;case 5:c="U16";break;case 6:c="S16";break;case 7:c="U32";break;case 8:c="S32";break;case 9:c="F32";break;default:c="F32"}var d,e=[],f=b.LODInfos;for(d=0;d<f.levels.length;d++)e.push({level:f.levels[d],resolution:f.resolutions[d],scale:96/.0254*f.resolutions[d]});d=new u(b.extent.spatialReference||
b.geodataXform.spatialReference);e=new v({rows:b.blockHeight,cols:b.blockWidth,dpi:96,format:b.format,compressionQuality:0,origin:b.origin,spatialReference:d,lods:e});a.pixelType=c;a.bandCount=b.bandCount;a.spatialReference=d;a.extent=new r({xmin:b.extent.xmin,ymin:b.extent.ymin,xmax:b.extent.xmax,ymax:b.extent.ymax,spatialReference:d});a.cellSize=new t({x:b.pixelSizeX,y:b.pixelSizeY,spatialReference:d});a.width=Math.floor((a.extent.xmax-a.extent.xmin)/a.cellSize.x+.5);a.height=Math.floor((a.extent.ymax-
a.extent.ymin)/a.cellSize.y+.5);a.statistics=b.statistics.map(function(a){Object.keys(a).forEach(function(b){isNaN(a[b])&&(a[b]=null)});return a});a.histograms=b.histograms;a.geodataXform=b.geodataXform;a.packetSize=b.packetSize;a.format=b.format;a.compressionQuality=b.compressionQuality;a.tileInfo=e;return a},_getRasterIdentifier:function(){this._rasterId||(this._rasterId=this.url.replace("http:","").replace("https:",""));return this._rasterId},_buildCacheFilePath:function(b,a,c,d){var e=this.rasterInfo.packetSize;
d=Math.floor(d/e)*e;c="R"+this._toHexString4(Math.floor(c/e)*e)+"C"+this._toHexString4(d);e="L";e=10<=a?e+a.toString():e+("0"+a.toString());return 0<b.toLowerCase().indexOf("s3.amazonaws.com")?b+"/_alllayers/"+e+"/"+c+".bundle":b+"/"+e+"_"+c+"/bundle"},_getIndexRecordFromBundle:function(b,a,c){b=this.rasterInfo.packetSize;a=a%b*b+c%b;if(0>a)throw"Invalid level / row / col";return a*this._RECORD_SIZE+64},_getTileEndAndContentType:function(b,a){b=b.subarray(a,a+8);a=0;var c;for(c=0;5>c;c++)a|=(b[c]&
255)<<8*c;var d=a&0xffffffffff;a=0;for(c=5;8>c;c++)a|=(b[c]&255)<<8*(c-5);return{position:d,recordSize:a&0xffffffffff}},_toHexString4:function(b){b=b.toString(16);if(4!=b.length)for(var a=4-b.length;0<a--;)b="0"+b;return b}});n("extend-esri")&&g.setObject("layers.rasterLib.raster.TileRaster",h,q);return h});