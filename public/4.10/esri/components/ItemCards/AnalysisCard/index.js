// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See https://js.arcgis.com/4.10/esri/copyright.txt for details.
//>>built
define("../../Component dojo/i18n!../../ItemCards/nls/resources dojo/date/locale ../../Dropdowns/Ago2018Dropdown ../../Badges/Authoritative ../../Badges/Deprecated ../../Badges/LivingAtlas ../../Badges/Marketplace ../../Badges/OpenData ../../Badges/Premium ../../Badges/Subscriber".split(" "),function(p,q,r,t,u,v,w,x,y,z,A){return function(c){function d(g){if(b[g])return b[g].exports;var f=b[g]={i:g,l:!1,exports:{}};return c[g].call(f.exports,f,f.exports,d),f.l=!0,f.exports}var b={};return d.m=c,d.c=
b,d.d=function(b,c,h){d.o(b,c)||Object.defineProperty(b,c,{enumerable:!0,get:h})},d.r=function(b){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(b,Symbol.toStringTag,{value:"Module"});Object.defineProperty(b,"__esModule",{value:!0})},d.t=function(b,c){if((1&c&&(b=d(b)),8&c)||4&c&&"object"==typeof b&&b&&b.__esModule)return b;var f=Object.create(null);if(d.r(f),Object.defineProperty(f,"default",{enumerable:!0,value:b}),2&c&&"string"!=typeof b)for(var e in b)d.d(f,e,function(e){return b[e]}.bind(null,
e));return f},d.n=function(b){var c=b&&b.__esModule?function(){return b.default}:function(){return b};return d.d(c,"a",c),c},d.o=function(b,c){return Object.prototype.hasOwnProperty.call(b,c)},d.p="",d(d.s=290)}({0:function(c,d,b){function g(b,c){function a(){this.constructor=b}f(b,c);b.prototype=null===c?Object.create(c):(a.prototype=c.prototype,new a)}b.d(d,"b",function(){return g});b.d(d,"a",function(){return h});var f=function(b,c){return(f=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&
function(a,b){a.__proto__=b}||function(a,b){for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c])})(b,c)},h=function(){return(h=Object.assign||function(b){for(var c,a=1,e=arguments.length;a<e;a++)for(var d in c=arguments[a])Object.prototype.hasOwnProperty.call(c,d)&&(b[d]=c[d]);return b}).apply(this,arguments)}},14:function(c,d,b){function g(){for(var b=[],c=0;c<arguments.length;c++)b[c]=arguments[c];return function(c){return b.reduceRight(function(b,a){return a(b)},c)}}b.d(d,"a",function(){return g})},
16:function(c,d){c.exports=q},20:function(c,d){c.exports=r},24:function(c,d,b){function g(a){return 0===Object.keys(a).length&&a.constructor===Object}function f(b,c){return a.apply(null,arguments)}function h(a,b){return l.apply(null,arguments)}b.d(d,"a",function(){return g});b.d(d,"d",function(){return k});b.d(d,"b",function(){return f});b.d(d,"c",function(){return h});var e=b(0);c=b(7);var k=Object(c.a)(function(a,b){b=e.a({},b);return delete b[a],b}),a=Object(c.a)(function(a,b){return Object.keys(b).reduce(function(c,
e){return c[e]=a(b[e],e,b),c},{})}),l=Object(c.a)(function(a,b){return Object.keys(b).reduce(function(c,e){return a(b[e],e,b)&&(c[e]=b[e]),c},{})})},27:function(c,d,b){b.d(d,"a",function(){return l});b.d(d,"b",function(){return m});var g=b(14);c=b(24);var f=b(44),h=b(43),e=b(42),k=b(41),a=b(40),l=function(b,c,d){return Object(g.a)(Object(a.a)(b),Object(k.a)(b),Object(e.a)(c),h.a,f.a)(d)},m=Object(g.a)(Object(c.d)("patchedDescription"),Object(c.d)("thumbURI"),Object(c.d)("iconURI"),Object(c.d)("displayName"),
Object(c.d)("badges"))},290:function(c,d,b){b.r(d);var g=b(0),f=b(16);c=b(5);var h=b(20),e=b(78),k=b.n(e),e=b(79),a=b.n(e),e=b(80),l=b.n(e),e=b(81),m=b.n(e),e=b(82),B=b.n(e),e=b(83),C=b.n(e),e=b(84),D=b.n(e),e=b(73),E=b.n(e),n=b(27);b=function(b){function c(a){a=b.call(this,a)||this;return a.state={customActionsOpen:!1},a.handleActionDropdownToggle=a.handleActionDropdownToggle.bind(a),a.handleCustomActionClick=a.handleCustomActionClick.bind(a),a.handleMainActionClick=a.handleMainActionClick.bind(a),
a}return g.b(c,b),c.prototype.render=function(a){var b,c=this,e=this.props,d=e.item,e=e.sortField;return b="numviews"===e?f.viewCount+": "+d.numViews:"avgrating"===e?f.rating+": "+d.avgRating.toFixed(2):"created"===e?f.created+": "+h.format(new Date(d.created),{selector:"date",formatLength:"short"}):f.updated+": "+h.format(new Date(d.modified),{selector:"date",formatLength:"short"}),a("div",{class:"card-ac__container",key:this.props.key},a("div",{class:"card-ac__details-container"},a("div",{class:"card-ac__thumb-container"},
a("img",{src:"data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",alt:"",class:"card-ac__thumbnail",style:"\n                                background-image: url("+d.thumbURI+");\n                            "})),a("div",{class:"card-ac__details"},a("h3",{class:"card-ac__title"},d.title),a("div",{class:"card-ac__info-row"},a("div",{class:"card-ac__icon-title-container"},a("img",{src:d.iconURI,class:"content-search-item-icon",title:d.displayName}),a("span",{class:"card-ac__author-text"},
d.displayName+" "+f.by,a("a",{class:"content-search-selectable card-mc__author-link",title:this.props.organization?f.viewOrg:f.viewProfile,href:this.props.organization?this.props.organization.orgUrl:this.props.portal.baseUrl+"/home/user.html?user\x3d"+d.owner,target:"_blank"}," "+(this.props.organization?this.props.organization.name:d.owner)))),a("span",{class:"card-ac__info-bullet"},"\u2022"),a("span",{class:"card-ac__info-string"},b)),a("p",{class:"card-ac__snippet"},a("span",{class:"card-ac__snippet-text"},
d.snippet," "),a("a",{class:"card-ac__side-action card-ac__no-wrap",href:this.props.portal.baseUrl+"/home/item.html?id\x3d"+d.id,target:"_blank"},f.viewItem,a("svg",{version:"1.1",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 16 16"},a("path",{d:"M10 1v1h3.293l-6.646 6.646 0.707 0.707 6.646-6.646v3.293h1v-5z"}),a("path",{d:"M14 8v6h-12v-12h6v-1h-7v14h14v-7z"})))))),a("div",{class:"card-ac__sub-container"},a("div",{class:"card-ac__badge-container card-ac__badge-container--regular card-ac__sub-group"},
this.renderBadges(a)),a("div",{class:"card-ac__badge-container card-ac__badge-container--small card-ac__sub-group"},this.renderBadges(a,!0)),a("div",{class:"card-ac__action-container card-ac__sub-group"},a("div",{class:"card-ac__no-wrap"},a("button",{class:"card-ac__primary-btn card-ac__btn",onclick:this.handleMainActionClick},this.props.mainActionTitle),this.props.customActions&&0<this.props.customActions.length?a(E.a,{key:d.id+"-action-dropdown",active:this.state.customActionsOpen,onToggle:this.handleActionDropdownToggle},
a("span",{class:"card-ac__custom-actions card-ac__btn",title:f.actions},a("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 32 32"},a("path",{d:"M28 9v5L16 26 4 14V9l12 12L28 9z"}))),a("div",null,this.props.customActions.map(function(b,d){return a("button",{key:b.name,class:"card-ac__custom-action-btn card-ac__btn",value:d,onclick:c.handleCustomActionClick},b.name)}))):null))))},c.prototype.renderBadges=function(b,c){var d=this,e=c?"small":"regular";return this.props.item.badges.map(function(c){switch(c){case "authoritative":return b(k.a,
{size:e,altOrg:d.props.organization?d.props.organization.name:void 0});case "deprecated":return b(a.a,{size:e});case "livingAtlas":return b(l.a,{size:e});case "marketplace":return b(m.a,{size:e});case "openData":return b(B.a,{size:e});case "premium":return b(C.a,{size:e,user:d.props.portal.user});case "subscriber":return b(D.a,{size:e,user:d.props.portal.user})}return null})},c.prototype.handleActionDropdownToggle=function(){this.setState({customActionsOpen:!this.state.customActionsOpen})},c.prototype.handleMainActionClick=
function(a){this.props.mainAction([Object(n.b)(this.props.item)])},c.prototype.handleCustomActionClick=function(a){this.setState({customActionsOpen:!this.state.customActionsOpen});this.props.customActions&&this.props.customActions[a.target.value]&&this.props.customActions[a.target.value].onAction(Object(n.b)(this.props.item))},c}(c.Component);d.default=b},40:function(c,d,b){b.d(d,"a",function(){return f});var g=b(0);c=b(7);var f=Object(c.a)(function(b,c){return g.a({},c,{thumbURI:function(b,a){var c=
b.baseUrl+"/home/js/arcgisonline/css/images/default_thumb.png";return a.thumbnail&&(c=b.restUrl+"/content/items/"+a.id+"/info/"+a.thumbnail+(b.credential?"?token\x3d"+b.credential.token:"")),c}(b,c)})})},41:function(c,d,b){b.d(d,"a",function(){return f});var g=b(0);c=b(7);var f=Object(c.a)(function(b,c){return g.a({},c,{patchedDescription:function(b,a){return a.description?a.description.replace(/src=('|")js\/jsapi\/esri\//g,function(a){return"src\x3d"+('"'===a[4]?'"':"'")+b.baseUrl+"/home/js/jsapi/esri/"}):
void 0}(b,c)})})},42:function(c,d,b){b.d(d,"a",function(){return f});var g=b(0);c=b(7);var f=Object(c.a)(function(b,c){return g.a({},c,{iconURI:function(b,a,c){var d;a=a&&a.toLowerCase();var e=!1,f=!1,k=!1,g=!1;if(0<a.indexOf("service")||"feature collection"===a||"kml"===a||"wms"===a||"wmts"===a||"wfs"===a){var h=-1<c.indexOf("Hosted Service");"feature service"===a||"feature collection"===a||"kml"===a||"wfs"===a?(g=-1<c.indexOf("Table"),e=-1<c.indexOf("Route Layer"),f=-1<c.indexOf("Markup"),d=(k=
-1!==c.indexOf("Spatiotemporal"))&&g?"spatiotemporaltable":g?"table":e?"routelayer":f?"markup":k?"spatiotemporal":h?"featureshosted":"features"):d="map service"===a||"wms"===a||"wmts"===a?h||-1<c.indexOf("Tiled")||"wmts"===a?"maptiles":"mapimages":"scene service"===a?-1<c.indexOf("Line")?"sceneweblayerline":-1<c.indexOf("3DObject")?"sceneweblayermultipatch":-1<c.indexOf("Point")?"sceneweblayerpoint":-1<c.indexOf("IntegratedMesh")?"sceneweblayermesh":-1<c.indexOf("PointCloud")?"sceneweblayerpointcloud":
-1<c.indexOf("Polygon")?"sceneweblayerpolygon":"sceneweblayer":"image service"===a?-1<c.indexOf("Elevation 3D Layer")?"elevationlayer":"imagery":"stream service"===a?"streamlayer":"vector tile service"===a?"vectortile":"datastore catalog service"===a?"datastorecollection":"geocoding service"===a?"geocodeservice":"geoprocessing service"===a&&-1<c.indexOf("Web Tool")?"tool":"layers"}else d="web map"===a||"cityengine web scene"===a?"maps":"web scene"===a?-1<c.indexOf("ViewingMode-Local")?"webscenelocal":
"websceneglobal":"web mapping application"===a||"mobile application"===a||"application"===a||"operation view"===a||"desktop application"===a?"apps":"map document"===a||"map package"===a||"published map"===a||"scene document"===a||"globe document"===a||"basemap package"===a||"mobile basemap package"===a||"mobile map package"===a||"project package"===a||"project template"===a||"pro map"===a||"layout"===a||"layer"===a&&-1<c.indexOf("ArcGIS Pro")||"explorer map"===a&&-1<c.indexOf("Explorer Document")?
"mapsgray":"service definition"===a||"csv"===a||"shapefile"===a||"cad drawing"===a||"geojson"===a||"360 vr experience"===a||"netcdf"===a?"datafiles":"explorer add in"===a||"desktop add in"===a||"windows viewer add in"===a||"windows viewer configuration"===a?"appsgray":"arcgis pro add in"===a||"arcgis pro configuration"===a?"addindesktop":"rule package"===a||"file geodatabase"===a||"csv collection"===a||"kml collection"===a||"windows mobile package"===a||"map template"===a||"desktop application template"===
a||"arcpad package"===a||"code sample"===a||"form"===a||"document link"===a||"vector tile package"===a||"operations dashboard add in"===a||"rules package"===a||"image"===a||"workflow manager package"===a||"explorer map"===a&&-1<c.indexOf("Explorer Mapping Application")||-1<c.indexOf("Document")?"datafilesgray":"network analysis service"===a||"geoprocessing service"===a||"geodata service"===a||"geometry service"===a||"geoprocessing package"===a||"locator package"===a||"geoprocessing sample"===a||"workflow manager service"===
a||"raster function template"===a?"toolsgray":"layer"===a||"layer package"===a||"explorer layer"===a?"layersgray":"scene package"===a?"scenepackage":"tile package"===a?"tilepackage":"task file"===a?"taskfile":"report template"===a?"report-template":"statistical data collection"===a?"statisticaldatacollection":"insights workbook"===a?"workbook":"insights model"===a?"insightsmodel":"insights page"===a?"insightspage":"hub initiative"===a?"hubinitiative":"hub page"===a?"hubpage":"hub site application"===
a?"hubsite":"relational database connection"===a?"relationaldatabaseconnection":"big data file share"===a?"datastorecollection":"image collection"===a?"imagecollection":"desktop style"===a?"desktopstyle":"style"===a?"style":"dashboard"===a?"dashboard":"maps";return b+"/"+d+"16.png"}(b,c.type,c.typeKeywords?c.typeKeywords:[])})})},43:function(c,d,b){b.d(d,"a",function(){return f});var g=b(0),f=function(b){return g.a({},b,{displayName:function(b){var c=b.type;b=b.typeKeywords||[];var a=c;return"Feature Service"===
c||"Feature Collection"===c?a=-1<b.indexOf("Table")?"Table":-1<b.indexOf("Route Layer")?"Route Layer":-1<b.indexOf("Markup")?"Markup":"Feature Layer":"Image Service"===c?a=-1<b.indexOf("Elevation 3D Layer")?"Elevation Layer":"Imagery Layer":"Scene Service"===c?a="Scene Layer":"Scene Package"===c?a="Scene Layer Package":"Stream Service"===c?a="Feature Layer":"Geocoding Service"===c?a="Locator":"Microsoft Powerpoint"===c?a="Microsoft PowerPoint":"GeoJson"===c?a="GeoJSON":"Globe Service"===c?a="Globe Layer":
"Vector Tile Service"===c?a="Tile Layer":"netCDF"===c?a="NetCDF":"Map Service"===c?a=-1===b.indexOf("Spatiotemporal")&&(-1<b.indexOf("Hosted Service")||-1<b.indexOf("Tiled"))?"Tile Layer":"Map Image Layer":c&&-1<c.toLowerCase().indexOf("add in")?a=c.replace(/(add in)/gi,"Add-In"):"datastore catalog service"===c&&(a="Big Data File Share"),a}(b)})}},44:function(c,d,b){b.d(d,"a",function(){return f});var g=b(0),f=function(b){return g.a({},b,{badges:function(b){var c=[],a=b.typeKeywords?b.typeKeywords:
[];return b.contentStatus&&("org_authoritative"===b.contentStatus||"public_authoritative"===b.contentStatus?c.push("authoritative"):"deprecated"===b.contentStatus&&c.push("deprecated")),b.groupDesignations&&-1<b.groupDesignations.indexOf("livingatlas")&&c.push("livingAtlas"),-1<a.indexOf("Requires Credits")?c.push("premium"):-1<a.indexOf("Requires Subscription")&&c.push("subscriber"),c}(b)})}},5:function(c,d){c.exports=p},7:function(c,d,b){function g(b){return function e(){for(var c=this,a=[],d=0;d<
arguments.length;d++)a[d]=arguments[d];return a.length>=b.length?b.call.apply(b,[this].concat(a)):function(){for(var b=[],d=0;d<arguments.length;d++)b[d]=arguments[d];return e.call.apply(e,[c].concat(a,b))}}}b.d(d,"a",function(){return g})},73:function(c,d){c.exports=t},78:function(c,d){c.exports=u},79:function(c,d){c.exports=v},80:function(c,d){c.exports=w},81:function(c,d){c.exports=x},82:function(c,d){c.exports=y},83:function(c,d){c.exports=z},84:function(c,d){c.exports=A}})});