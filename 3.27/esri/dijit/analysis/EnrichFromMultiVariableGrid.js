// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
require({cache:{"url:esri/dijit/analysis/templates/EnrichFromMultiVariableGrid.html":'\x3cdiv class\x3d"esriAnalysis"\x3e\r\n  \x3cdiv data-dojo-type\x3d"dijit/layout/ContentPane" style\x3d"margin-top:0.5em; margin-bottom: 0.5em;"\x3e\r\n    \x3cdiv data-dojo-attach-point\x3d"_aggregateToolContentTitle" class\x3d"analysisTitle"\x3e\r\n      \x3ctable class\x3d"esriFormTable" \x3e\r\n        \x3ctr\x3e\r\n          \x3ctd class\x3d"esriToolIconTd"\x3e\x3cdiv class\x3d"enrichMVGridIcon"\x3e\x3c/div\x3e\x3c/td\x3e\r\n          \x3ctd class\x3d"esriAlignLeading esriAnalysisTitle" data-dojo-attach-point\x3d"_toolTitle"\x3e\r\n            \x3clabel data-dojo-attach-point\x3d"_titleLbl"\x3e${i18n.enrichMultiVariableGrid}\x3c/label\x3e\r\n            \x3cnav class\x3d"breadcrumbs"  data-dojo-attach-point\x3d"_analysisModeLblNode" style\x3d"display:none;"\x3e\r\n              \x3ca href\x3d"#" class\x3d"crumb breadcrumbs__modelabel" data-dojo-attach-event\x3d"onclick:_handleModeCrumbClick" data-dojo-attach-point\x3d"_analysisModeCrumb"\x3e\x3c/a\x3e\r\n              \x3ca href\x3d"#" class\x3d"crumb is-active" data-dojo-attach-point\x3d"_analysisTitleCrumb" style\x3d"font-size:16px;"\x3e${i18n.enrichMultiVariableGrid}\x3c/a\x3e\r\n            \x3c/nav\x3e\r\n          \x3c/td\x3e\r\n          \x3ctd\x3e\r\n            \x3cdiv class\x3d"esriFloatTrailing" style\x3d"padding:0;"\x3e\r\n              \x3cdiv class\x3d"esriFloatLeading"\x3e\r\n                \x3ca href\x3d"#" class\x3d\'esriFloatLeading helpIcon\' esriHelpTopic\x3d"toolDescription"\x3e\x3c/a\x3e\r\n              \x3c/div\x3e\r\n              \x3cdiv class\x3d"esriFloatTrailing"\x3e\r\n                \x3ca href\x3d"#" data-dojo-attach-point\x3d"_closeBtn" title\x3d"${i18n.close}" class\x3d"esriAnalysisCloseIcon"\x3e\x3c/a\x3e\r\n              \x3c/div\x3e\r\n            \x3c/div\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n      \x3c/table\x3e\r\n    \x3c/div\x3e\r\n    \x3cdiv style\x3d"clear:both; border-bottom: #CCC thin solid; height:1px;width:100%;"\x3e\x3c/div\x3e\r\n  \x3c/div\x3e\r\n  \x3cdiv data-dojo-type\x3d"dijit/form/Form" data-dojo-attach-point\x3d"_form" readOnly\x3d"true"\x3e\r\n     \x3ctable class\x3d"esriFormTable"  data-dojo-attach-point\x3d"_aggregateTable"  style\x3d"border-collapse:collapse;border-spacing:5px;" cellpadding\x3d"5px" cellspacing\x3d"5px"\x3e\r\n       \x3ctbody\x3e\r\n        \x3ctr data-dojo-attach-point\x3d"_analysisLabelRow"\x3e\r\n          \x3ctd colspan\x3d"2"\x3e\r\n            \x3clabel class\x3d"esriFloatLeading  esriTrailingMargin025 esriAnalysisNumberLabel"\x3e${i18n.oneLabel}\x3c/label\x3e\r\n            \x3clabel class\x3d"esriAnalysisStepsLabel"\x3e${i18n.choosePointLyrLabel}\x3c/label\x3e\r\n          \x3c/td\x3e\r\n          \x3ctd class\x3d"shortTextInput"\x3e\r\n            \x3ca href\x3d"#" class\x3d\'esriFloatTrailing helpIcon\' esriHelpTopic\x3d"inputFeatures"\x3e\x3c/a\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr data-dojo-attach-point\x3d"_selectAnalysisRow" style\x3d"display:none;"\x3e\r\n          \x3ctd  colspan\x3d"3" style\x3d"padding-top:0;"\x3e\r\n            \x3cselect class\x3d"esriLeadingMargin1 longInput esriLongLabel"  style\x3d"margin-top:1.0em;" data-dojo-type\x3d"dijit/form/Select" data-dojo-attach-point\x3d"_analysisSelect" data-dojo-props\x3d"required:true" data-dojo-attach-event\x3d"onChange:_handleAnalysisLayerChange"\x3e\x3c/select\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"3" class\x3d"clear"\x3e\x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"2"\x3e\r\n            \x3clabel class\x3d"esriFloatLeading  esriTrailingMargin025 esriAnalysisNumberLabel"\x3e${i18n.twoLabel}\x3c/label\x3e\r\n            \x3clabel class\x3d"esriAnalysisStepsLabel"\x3e${i18n.chooseMVgridLyrLabel}\x3c/label\x3e\r\n          \x3c/td\x3e\r\n          \x3ctd class\x3d"shortTextInput"\x3e\r\n            \x3ca href\x3d"#" class\x3d\'esriFloatTrailing helpIcon\' esriHelpTopic\x3d"gridLayer"\x3e\x3c/a\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"3" style\x3d"padding-top:0;"\x3e\r\n            \x3cselect class\x3d"esriLeadingMargin1 longInput esriLongLabel" data-dojo-type\x3d"dijit/form/Select" data-dojo-attach-point\x3d"_gridLayerSelect" data-dojo-props\x3d"required:true" data-dojo-attach-event\x3d"onChange:_handleGridLayerChange"\x3e\x3c/select\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"2" style\x3d"padding-bottom:0;"\x3e\r\n            \x3clabel class\x3d"esriFloatLeading  esriTrailingMargin025 esriAnalysisNumberLabel"\x3e${i18n.threeLabel}\x3c/label\x3e\r\n            \x3clabel class\x3d"esriAnalysisStepsLabel"\x3e${i18n.chooseVariables}\x3c/label\x3e\r\n         \x3c/td\x3e\r\n         \x3ctd class\x3d"shortTextInput" style\x3d"padding-bottom:0;"\x3e  \r\n            \x3ca href\x3d"#" class\x3d\'esriFloatTrailing helpIcon\' esriHelpTopic\x3d"enrichAttributes"\x3e\x3c/a\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"3" style\x3d"padding-top:0;"\x3e\r\n            \x3cselect multiple\x3d"true"  class\x3d"esriLeadingMargin1" style\x3d"width:100%;margin-top:10px;" data-dojo-props\x3d"required:true" data-dojo-type\x3d"dojox/form/CheckedMultiSelect" data-dojo-attach-point\x3d"_enrichFieldsSelect"\x3e\x3c/select\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e \r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"2"\x3e\r\n            \x3clabel class\x3d"esriFloatLeading esriTrailingMargin025 esriAnalysisNumberLabel" data-dojo-attach-point\x3d"_outputNumberLabel"\x3e${i18n.fourLabel}\x3c/label\x3e\r\n            \x3clabel class\x3d"longTextInput esriAnalysisStepsLabel"\x3e${i18n.outputLayerLabel}\x3c/label\x3e\r\n          \x3c/td\x3e\r\n          \x3ctd class\x3d"shortTextInput"\x3e\r\n            \x3ca href\x3d"#" class\x3d\'esriFloatTrailing helpIcon\' esriHelpTopic\x3d"outputName"\x3e\x3c/a\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"3"\x3e\r\n            \x3cinput type\x3d"text" data-dojo-type\x3d"dijit/form/ValidationTextBox" class\x3d"esriLeadingMargin1 esriOutputText"  data-dojo-props\x3d"trim:true,required:true" data-dojo-attach-point\x3d"_outputLayerInput" value\x3d""\x3e\x3c/input\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n        \x3ctr\x3e\r\n          \x3ctd colspan\x3d"3"\x3e\r\n             \x3cdiv class\x3d"esriLeadingMargin1" data-dojo-attach-point\x3d"_chooseFolderRow"\x3e\r\n               \x3clabel style\x3d"width:9px;font-size:smaller;"\x3e${i18n.saveResultIn}\x3c/label\x3e\r\n               \x3cinput class\x3d"longInput esriFolderSelect" data-dojo-attach-point\x3d"_webMapFolderSelect" data-dojo-type\x3d"dijit/form/FilteringSelect" trim\x3d"true"\x3e\x3c/input\x3e\r\n             \x3c/div\x3e\r\n          \x3c/td\x3e\r\n        \x3c/tr\x3e\r\n      \x3c/tbody\x3e\r\n     \x3c/table\x3e\r\n   \x3c/div\x3e\r\n  \x3cdiv data-dojo-attach-point\x3d"_aggregateToolContentButtons" style\x3d"padding:5px;margin-top:5px;border-top:solid 1px #BBB;"\x3e\r\n    \x3cdiv class\x3d"esriExtentCreditsCtr"\x3e\r\n      \x3ca class\x3d"esriFloatTrailing esriSmallFont"  href\x3d"#" data-dojo-attach-point\x3d"_showCreditsLink"\x3e${i18n.showCredits}\x3c/a\x3e\r\n     \x3clabel data-dojo-attach-point\x3d"_chooseExtentDiv" class\x3d"esriSelectLabel esriExtentLabel"\x3e\r\n       \x3cinput type\x3d"radio" data-dojo-attach-point\x3d"_useExtentCheck" data-dojo-type\x3d"dijit/form/CheckBox" data-dojo-props\x3d"checked:true" name\x3d"extent" value\x3d"true"/\x3e\r\n         ${i18n.useMapExtent}\r\n     \x3c/label\x3e\r\n    \x3c/div\x3e\r\n    \x3cbutton data-dojo-type\x3d"dijit/form/Button" type\x3d"submit" data-dojo-attach-point\x3d"_saveBtn" class\x3d"esriLeadingMargin4 esriAnalysisSubmitButton" data-dojo-attach-event\x3d"onClick:_handleSaveBtnClick"\x3e\r\n        ${i18n.runAnalysis}\r\n    \x3c/button\x3e\r\n  \x3c/div\x3e\r\n  \x3cdiv data-dojo-type\x3d"dijit/Dialog" title\x3d"${i18n.creditTitle}" data-dojo-attach-point\x3d"_usageDialog" style\x3d"width:40em;"\x3e\r\n    \x3cdiv data-dojo-type\x3d"esri/dijit/analysis/CreditEstimator"  data-dojo-attach-point\x3d"_usageForm"\x3e\x3c/div\x3e\r\n  \x3c/div\x3e\r\n\x3c/div\x3e\r\n'}});
define("esri/dijit/analysis/EnrichFromMultiVariableGrid","require dojo/_base/declare dojo/_base/lang dojo/_base/connect dojo/_base/json dojo/has dojo/json dojo/string dojo/dom-style dojo/dom-attr dojo/dom-construct dojo/query dojo/dom-class dojo/number dojo/Deferred dojo/promise/all dijit/_WidgetBase dijit/_TemplatedMixin dijit/_WidgetsInTemplateMixin dijit/_OnDijitClickMixin dijit/_FocusMixin dijit/registry dijit/form/Button dijit/form/CheckBox dijit/form/Form dijit/form/Select dijit/form/TextBox dijit/form/ValidationTextBox dijit/layout/ContentPane dijit/form/FilteringSelect dijit/form/NumberSpinner dijit/form/NumberTextBox ../../kernel ../../lang ./AnalysisBase ./_AnalysisOptions ./AnalysisRegistry ./CreditEstimator ./ItemTypes ./utils dojo/i18n!../../nls/jsapi dojo/i18n!./nls/EnrichFromMultiVariableGrid dojo/text!./templates/EnrichFromMultiVariableGrid.html".split(" "),
function(h,p,b,n,e,q,G,k,g,H,I,J,r,K,t,u,v,w,x,y,z,L,M,N,O,P,Q,R,S,T,U,V,A,l,B,C,f,W,m,d,D,E,F){h=p([v,w,x,y,z,C,B],{declaredClass:"esri.dijit.analysis.EnrichFromMultiVariableGrid",templateString:F,widgetsInTemplate:!0,analysisLayer:null,gridLayer:null,enrichAttributes:null,outputLayerName:null,returnFeatureCollection:!1,i18n:null,toolName:"EnrichFromMultiVariableGrid",helpFileName:"EnrichFromMultiVariableGrid",resultParameter:"output",constructor:function(a){this._pbConnects=[];a.containerNode&&
(this.container=a.containerNode);a.showGeoAnalyticsParams&&a.rerun&&(a.inputLayer=a.inputFeatures)},destroy:function(){this.inherited(arguments);this._pbConnects.forEach(n.disconnect);delete this._pbConnects},postMixInProperties:function(){this.inherited(arguments);b.mixin(this.i18n,D.EnrichFromMultiVariableGridTool);b.mixin(this.i18n,E)},postCreate:function(){this.inherited(arguments);r.add(this._form.domNode,"esriSimpleForm");g.set(this._enrichFieldsSelect.selectNode,"width","80%");this._outputLayerInput.set("validator",
b.hitch(this,this.validateServiceName));this._buildUI()},startup:function(){},_onClose:function(a){a&&(this._save(),this.emit("save",{save:!0}));this.emit("close",{save:a})},_buildJobParams:function(){var a={},c;a.inputFeatures=e.toJson(this.constructAnalysisInputLyrObj(this.inputLayer,this.showGeoAnalyticsParams));a.gridLayer=e.toJson(this.constructAnalysisInputLyrObj(this.gridLayer,this.showGeoAnalyticsParams));a.enrichAttributes=this.get("enrichAttributes");this.returnFeatureCollection||(a.OutputName=
e.toJson({serviceProperties:{name:this._outputLayerInput.get("value")}}));this.showChooseExtent&&this._useExtentCheck.get("checked")&&(a.context=e.toJson({extent:this.map.extent._normalize(!0)}));this.returnFeatureCollection&&(c={outSR:this.map.spatialReference},this.showChooseExtent&&this._useExtentCheck.get("checked")&&(c.extent=this.map.extent._normalize(!0)),a.context=e.toJson(c));return a},_handleShowCreditsClick:function(a){a.preventDefault();this._form.validate()&&this.getCreditsEstimate(this.toolName,
this._buildJobParams()).then(b.hitch(this,function(a){this._usageForm.set("content",a);this._usageDialog.show()}))},_handleSaveBtnClick:function(){if(this._form.validate()){this._saveBtn.set("disabled",!0);var a={};a.itemParams={description:k.substitute(this.i18n.itemDescription,{inputFeatures:this.inputLayer.name,gridLayer:this.gridLayer.name}),tags:k.substitute(this.i18n.itemTags,{inputFeatures:this.inputLayer.name,gridLayer:this.gridLayer.name}),snippet:this.i18n.itemSnippet};a.jobParams=this._buildJobParams();
this.showGeoAnalyticsParams&&(a.isSpatioTemporalDataStore=!0);this.showSelectFolder&&(a.itemParams.folder=this.get("folderId"));this.execute(a)}},_handleAnalysisLayerChange:function(a){this._isAnalysisSelect=!1;"browse"===a?this._createBrowseItems({tags:["point"]},this._analysisSelect):"browselayers"===a?(this.set("showReadyToUseLayers",this._curShowReadyToUseLayers),this.showGeoAnalyticsParams&&(a=this._browseLyrsdlg.browseItems.get("query"),a.types.push('type:"'+m.BIGDATA+'"'),this._browseLyrsdlg.browseItems.set("query",
a)),this._browseLyrsdlg.browseItems.plugIn.geometryTypes=[f.GeometryTypes.Point],this._browseLyrsdlg.show()):(this.inputLayer=this.inputLayers[a],this._updateAnalysisLayerUI(!0))},_handleGridLayerChange:function(a){this._isAnalysisSelect=!1;"browselayers"===a?(this.set("showReadyToUseLayers",!1),this.showGeoAnalyticsParams&&(a=this._browseLyrsdlg.browseItems.get("query"),a.types.push('type:"'+m.BIGDATA+'"'),a.custom=['typekeywords:"'+m.MVGRID+'"'],this._browseLyrsdlg.browseItems.set("query",a)),this._browseLyrsdlg.browseItems.plugIn.geometryTypes=
[f.GeometryTypes.Polygon],this._browseLyrsdlg.show()):(this.gridLayer=this.gridLayers[this._gridLayerSelect.get("value")],this._updateEnrichFields())},_handleBrowseItemsSelect:function(a,c){a&&a.selection&&d.addAnalysisReadyLayer({item:a.selection,layers:this._isAnalysisSelect?this.inputLayers:this.gridLayers,layersSelect:this._isAnalysisSelect?this._analysisSelect:this._gridLayerSelect,browseDialog:a.dialog||this._browsedlg,widget:this},c).always(b.hitch(this,function(a){this._handleAnalysisLayerChange(this._analysisSelect.get("value"))}))},
_save:function(){},_buildUI:function(){g.set(this._showCreditsLink,"display",!0===this.showCredits?"block":"none");this.signInPromise.then(b.hitch(this,d.initHelpLinks,this.domNode,this.showHelp,{analysisGpServer:this.analysisGpServer}));this._loadConnections();this.get("showSelectAnalysisLayer")&&(this.inputLayers&&this.inputLayer&&!d.isLayerInLayers(this.inputLayer,this.inputLayers)&&this.inputLayers.push(this.inputLayer),this.get("inputLayer")||!this.get("inputLayers")||this.rerun||this.set("inputLayer",
this.inputLayers[0]),d.populateAnalysisLayers(this,"inputLayer","inputLayers"));this.outputLayerName&&this._outputLayerInput.set("value",this.outputLayerName);d.addReadyToUseLayerOption(this,[this._analysisSelect]);this._curShowReadyToUseLayers=this.get("showReadyToUseLayers");this.set("showReadyToUseLayers",!1);d.addReadyToUseLayerOption(this,[this._gridLayerSelect]);this.set("showReadyToUseLayers",this._curShowReadyToUseLayers);g.set(this._chooseFolderRow,"display",!0===this.showSelectFolder?"block":
"none");this.showSelectFolder&&this.getFolderStore().then(b.hitch(this,function(a){this.folderStore=a;d.setupFoldersUI({folderStore:this.folderStore,folderId:this.folderId,folderName:this.folderName,folderSelect:this._webMapFolderSelect,username:this.portalUser?this.portalUser.username:""})}));g.set(this._chooseExtentDiv,"display",!0===this.showChooseExtent?"inline-block":"none")},_updateAnalysisLayerUI:function(a){this.inputLayer&&this.gridLayer&&(a||!this.outputLayerName)&&(this.outputLayerName=
k.substitute(this.i18n.outputLayerName,{inputFeatures:this.inputLayer.name,gridLayer:this.gridLayer.name}),this._outputLayerInput.set("value",this.outputLayerName))},_buildGridLayersUI:function(){var a=this.gridLayers.map(b.hitch(this,function(a,b){return{value:b+"",label:a.name,selected:this.gridLayer&&this.gridLayer.url===a.url&&this.gridLayer.name===a.name}}));this.get("showBrowseLayers")&&(a.push({type:"separator",value:""}),a.push({value:"browselayers",label:this.i18n.browseLayers}));this._gridLayerSelect.removeOption(this._gridLayerSelect.getOptions());
this._gridLayerSelect.addOption(a);this.gridLayer||this._gridLayerSelect.set("value","0");this._handleGridLayerChange(this._gridLayerSelect.get("value"));this.inputLayer&&this._updateAnalysisLayerUI(!this.outputLayerName)},_updateGridLayer:function(){this.gridLayer&&(this.gridLayers&&this.gridLayer&&!d.isLayerInLayers(this.gridLayer,this.gridLayers)&&this.gridLayers.push(this.gridLayer),this._buildGridLayersUI())},_updateEnrichFields:function(){if(this._enrichFieldsSelect){this._enrichFieldsSelect.removeOption(this._enrichFieldsSelect.get("options"));
var a=this.gridLayers[this._gridLayerSelect.get("value")].fields,a=a.filter(function(a){return-1===["esriFieldTypeGlobalID","esriFieldTypeOID"].indexOf(a.type)}),a=a.map(b.hitch(this,function(a){return{value:a.name,label:l.isDefined(a.alias)&&""!==a.alias?a.alias:a.name,selected:this.enrichAttributes&&-1!==this.enrichAttributes.indexOf(a.name)}}));this._enrichFieldsSelect.addOption(a);this.enrichAttributes&&(this.enrichAttributes="")}},_loadConnections:function(){this.on("start",b.hitch(this,"_onClose",
!0));this._connect(this._closeBtn,"onclick",b.hitch(this,"_onClose",!1))},_isGridLayer:function(a){var c=new t;a.geometryType!==f.GeometryTypes.Polygon?c.resolve(!1):l.isDefined(a.__supportsMVGEnrich)?c.resolve(a.__supportsMVGEnrich):this.signInPromise.then(b.hitch(this,function(){this._getAdminLayerInfo(a.url).then(b.hitch(this,function(b){a.__supportsMVGEnrich=l.isDefined(b.adminLayerInfo.mvgProperties);c.resolve(a.__supportsMVGEnrich)}),b.hitch(this,function(a){c.resolve(!1)}))}));return c.promise},
_setAnalysisGpServerAttr:function(a){a&&(this.analysisGpServer=a,this.set("toolServiceUrl",this.analysisGpServer+"/"+this.toolName))},_setInputLayerAttr:function(a){this.inputLayer=a&&a.geometryType===f.GeometryTypes.Point?a:null},_getInputLayerAttr:function(){return this.inputLayer},_setInputLayersAttr:function(a){this.inputLayers=a.filter(function(a){return a.geometryType===f.GeometryTypes.Point})},_setGridLayerAttr:function(a){this._isGridLayer(a).then(b.hitch(this,function(b){b&&(this.gridLayer=
a);this._updateGridLayer()}))},_getGridLayerAttr:function(){return this.gridLayer},_setGridLayersAttr:function(a){var c=a.map(b.hitch(this,function(a){return this._isGridLayer(a)}));u(c).then(b.hitch(this,function(c){this.gridLayers=a.filter(b.hitch(this,function(a,b){return!0===c[b]}));this._buildGridLayersUI()}))},_getEnrichAttributesAttr:function(){return this._enrichFieldsSelect?this._enrichFieldsSelect.get("value").toString():""},_setDisableRunAnalysisAttr:function(a){this._saveBtn.set("disabled",
a)},_connect:function(a,b,d){this._pbConnects.push(n.connect(a,b,d))},validateServiceName:function(a){return d.validateServiceName(a,{textInput:this._outputLayerInput})}});q("extend-esri")&&b.setObject("dijit.analysis.EnrichFromMultiVariableGrid",h,A);return h});