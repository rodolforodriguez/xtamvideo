// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/ReportPlayer/core/conversion/portalToEditorUtils/variables/VariableUtil",[],function(){var c={getType:function(a){return a&&(0===a.indexOf("esriFieldType")?a:"esriFieldType"+a)},fieldTagToVariable:function(a,b){return a.attributes.MapTo&&"AREA_ID"!==a.attributes.Name?{id:a.attributes.MapTo.substr(a.attributes.MapTo.lastIndexOf(".")+1),fullName:a.attributes.MapTo,alias:a.attributes.Alias,fieldName:a.attributes.Name,precision:Number(a.attributes.Decimals)||0,calculatorName:b,
templateName:b+"."+a.attributes.Name,type:c.getType(a.attributes.Type)}:null},scriptTagToVariable:function(a,b){return{id:a.attributes.Name,fullName:b+"."+a.attributes.Name,fieldName:a.attributes.Name,alias:a.attributes.Alias,precision:Number(a.attributes.Decimals)||0,usedFields:a.attributes.usedFields?a.attributes.usedFields.split(","):[],usedMapTos:null,expressionText:a.tags[0].text,calculatorName:b,templateName:b+"."+a.attributes.Name,type:c.getType(a.attributes.Type)}}};return c});