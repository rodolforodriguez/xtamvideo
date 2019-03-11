/*
	Copyright (c) 2004-2016, The JS Foundation All Rights Reserved.
	Available via Academic Free License >= 2.1 OR the modified BSD license.
	see: http://dojotoolkit.org/license for details
*/

//>>built
define("dojo/data/ItemFileWriteStore","../_base/lang ../_base/declare ../_base/array ../_base/json ../_base/kernel ./ItemFileReadStore ../date/stamp".split(" "),function(k,r,m,p,q,t,u){return r("dojo.data.ItemFileWriteStore",t,{constructor:function(a){this._features["dojo.data.api.Write"]=!0;this._features["dojo.data.api.Notification"]=!0;this._pending={_newItems:{},_modifiedItems:{},_deletedItems:{}};this._datatypeMap.Date.serialize||(this._datatypeMap.Date.serialize=function(a){return u.toISOString(a,
{zulu:!0})});a&&!1===a.referenceIntegrity&&(this.referenceIntegrity=!1);this._saveInProgress=!1},referenceIntegrity:!0,_assert:function(a){if(!a)throw Error("assertion failed in ItemFileWriteStore");},_getIdentifierAttribute:function(){return this.getFeatures()["dojo.data.api.Identity"]},newItem:function(a,b){this._assert(!this._saveInProgress);this._loadFinished||this._forceLoad();if("object"!=typeof a&&"undefined"!=typeof a)throw Error("newItem() was passed something other than an object");var c=
null,e=this._getIdentifierAttribute();if(e===Number)c=this._arrayOfAllItems.length;else{c=a[e];if("undefined"===typeof c)throw Error("newItem() was not passed an identity for the new item");if(k.isArray(c))throw Error("newItem() was not passed an single-valued identity");}this._itemsByIdentity&&this._assert("undefined"===typeof this._itemsByIdentity[c]);this._assert("undefined"===typeof this._pending._newItems[c]);this._assert("undefined"===typeof this._pending._deletedItems[c]);var d={};d[this._storeRefPropName]=
this;d[this._itemNumPropName]=this._arrayOfAllItems.length;this._itemsByIdentity&&(this._itemsByIdentity[c]=d,d[e]=[c]);this._arrayOfAllItems.push(d);e=null;if(b&&b.parent&&b.attribute){var e={item:b.parent,attribute:b.attribute,oldValue:void 0},g=this.getValues(b.parent,b.attribute);if(g&&0<g.length){var h=g.slice(0,g.length);e.oldValue=1===g.length?g[0]:g.slice(0,g.length);h.push(d);this._setValueOrValues(b.parent,b.attribute,h,!1);e.newValue=this.getValues(b.parent,b.attribute)}else this._setValueOrValues(b.parent,
b.attribute,d,!1),e.newValue=d}else d[this._rootItemPropName]=!0,this._arrayOfTopLevelItems.push(d);this._pending._newItems[c]=d;for(var f in a){if(f===this._storeRefPropName||f===this._itemNumPropName)throw Error("encountered bug in ItemFileWriteStore.newItem");b=a[f];k.isArray(b)||(b=[b]);d[f]=b;if(this.referenceIntegrity)for(c=0;c<b.length;c++)g=b[c],this.isItem(g)&&this._addReferenceToMap(g,d,f)}this.onNew(d,e);return d},_removeArrayElement:function(a,b){b=m.indexOf(a,b);return-1!=b?(a.splice(b,
1),!0):!1},deleteItem:function(a){this._assert(!this._saveInProgress);this._assertIsItem(a);var b=a[this._itemNumPropName],c=this.getIdentity(a);if(this.referenceIntegrity){var e=this.getAttributes(a);a[this._reverseRefMap]&&(a["backup_"+this._reverseRefMap]=k.clone(a[this._reverseRefMap]));m.forEach(e,function(b){m.forEach(this.getValues(a,b),function(c){this.isItem(c)&&(a["backupRefs_"+this._reverseRefMap]||(a["backupRefs_"+this._reverseRefMap]=[]),a["backupRefs_"+this._reverseRefMap].push({id:this.getIdentity(c),
attr:b}),this._removeReferenceFromMap(c,a,b))},this)},this);if(e=a[this._reverseRefMap])for(var d in e){var g=null;if(g=this._itemsByIdentity?this._itemsByIdentity[d]:this._arrayOfAllItems[d])for(var h in e[d]){var f=this.getValues(g,h)||[],l=m.filter(f,function(a){return!(this.isItem(a)&&this.getIdentity(a)==c)},this);this._removeReferenceFromMap(a,g,h);l.length<f.length&&this._setValueOrValues(g,h,l,!0)}}}this._arrayOfAllItems[b]=null;a[this._storeRefPropName]=null;this._itemsByIdentity&&delete this._itemsByIdentity[c];
this._pending._deletedItems[c]=a;a[this._rootItemPropName]&&this._removeArrayElement(this._arrayOfTopLevelItems,a);this.onDelete(a);return!0},setValue:function(a,b,c){return this._setValueOrValues(a,b,c,!0)},setValues:function(a,b,c){return this._setValueOrValues(a,b,c,!0)},unsetAttribute:function(a,b){return this._setValueOrValues(a,b,[],!0)},_setValueOrValues:function(a,b,c,e){this._assert(!this._saveInProgress);this._assertIsItem(a);this._assert(k.isString(b));this._assert("undefined"!==typeof c);
var d=this._getIdentifierAttribute();if(b==d)throw Error("ItemFileWriteStore does not have support for changing the value of an item's identifier.");var d=this._getValueOrValues(a,b),g=this.getIdentity(a);if(!this._pending._modifiedItems[g]){var h={},f;for(f in a)h[f]=f===this._storeRefPropName||f===this._itemNumPropName||f===this._rootItemPropName?a[f]:f===this._reverseRefMap?k.clone(a[f]):a[f].slice(0,a[f].length);this._pending._modifiedItems[g]=h}g=!1;if(k.isArray(c)&&0===c.length){if(g=delete a[b],
c=void 0,this.referenceIntegrity&&d){f=d;k.isArray(f)||(f=[f]);for(var l=0;l<f.length;l++)h=f[l],this.isItem(h)&&this._removeReferenceFromMap(h,a,b)}}else{g=k.isArray(c)?c.slice(0,c.length):[c];if(this.referenceIntegrity)if(d){f=d;k.isArray(f)||(f=[f]);var n={};m.forEach(f,function(a){this.isItem(a)&&(a=this.getIdentity(a),n[a.toString()]=!0)},this);m.forEach(g,function(c){if(this.isItem(c)){var d=this.getIdentity(c);n[d.toString()]?delete n[d.toString()]:this._addReferenceToMap(c,a,b)}},this);for(l in n)this._removeReferenceFromMap(this._itemsByIdentity?
this._itemsByIdentity[l]:this._arrayOfAllItems[l],a,b)}else for(l=0;l<g.length;l++)h=g[l],this.isItem(h)&&this._addReferenceToMap(h,a,b);a[b]=g;g=!0}if(e)this.onSet(a,b,d,c);return g},_addReferenceToMap:function(a,b,c){b=this.getIdentity(b);var e=a[this._reverseRefMap];e||(e=a[this._reverseRefMap]={});(a=e[b])||(a=e[b]={});a[c]=!0},_removeReferenceFromMap:function(a,b,c){b=this.getIdentity(b);var e=a[this._reverseRefMap],d;if(e){for(d in e)d==b&&(delete e[d][c],this._isEmpty(e[d])&&delete e[d]);this._isEmpty(e)&&
delete a[this._reverseRefMap]}},_dumpReferenceMap:function(){var a;for(a=0;a<this._arrayOfAllItems.length;a++){var b=this._arrayOfAllItems[a];b&&b[this._reverseRefMap]&&console.log("Item: ["+this.getIdentity(b)+"] is referenced by: "+p.toJson(b[this._reverseRefMap]))}},_getValueOrValues:function(a,b){var c=void 0;this.hasAttribute(a,b)&&(a=this.getValues(a,b),c=1==a.length?a[0]:a);return c},_flatten:function(a){if(this.isItem(a))return{_reference:this.getIdentity(a)};if("object"===typeof a)for(var b in this._datatypeMap){var c=
this._datatypeMap[b];if(k.isObject(c)&&!k.isFunction(c)){if(a instanceof c.type){if(!c.serialize)throw Error("ItemFileWriteStore:  No serializer defined for type mapping: ["+b+"]");return{_type:b,_value:c.serialize(a)}}}else if(a instanceof c)return{_type:b,_value:a.toString()}}return a},_getNewFileContentString:function(){var a={},b=this._getIdentifierAttribute();b!==Number&&(a.identifier=b);this._labelAttr&&(a.label=this._labelAttr);a.items=[];for(b=0;b<this._arrayOfAllItems.length;++b){var c=this._arrayOfAllItems[b];
if(null!==c){var e={},d;for(d in c)if(d!==this._storeRefPropName&&d!==this._itemNumPropName&&d!==this._reverseRefMap&&d!==this._rootItemPropName){var g=this.getValues(c,d);if(1==g.length)e[d]=this._flatten(g[0]);else for(var h=[],f=0;f<g.length;++f)h.push(this._flatten(g[f])),e[d]=h}a.items.push(e)}}return p.toJson(a,!0)},_isEmpty:function(a){var b=!0;if(k.isObject(a))for(var c in a){b=!1;break}else k.isArray(a)&&0<a.length&&(b=!1);return b},save:function(a){this._assert(!this._saveInProgress);this._saveInProgress=
!0;var b=this,c=function(){b._pending={_newItems:{},_modifiedItems:{},_deletedItems:{}};b._saveInProgress=!1;a&&a.onComplete&&a.onComplete.call(a.scope||q.global)},e=function(c){b._saveInProgress=!1;a&&a.onError&&a.onError.call(a.scope||q.global,c)};if(this._saveEverything){var d=this._getNewFileContentString();this._saveEverything(c,e,d)}this._saveCustom&&this._saveCustom(c,e);this._saveEverything||this._saveCustom||c()},revert:function(){this._assert(!this._saveInProgress);for(var a in this._pending._modifiedItems){var b=
this._pending._modifiedItems[a],c=null,c=this._itemsByIdentity?this._itemsByIdentity[a]:this._arrayOfAllItems[a];b[this._storeRefPropName]=this;for(var e in c)delete c[e];k.mixin(c,b)}var d;for(a in this._pending._deletedItems)d=this._pending._deletedItems[a],d[this._storeRefPropName]=this,b=d[this._itemNumPropName],d["backup_"+this._reverseRefMap]&&(d[this._reverseRefMap]=d["backup_"+this._reverseRefMap],delete d["backup_"+this._reverseRefMap]),this._arrayOfAllItems[b]=d,this._itemsByIdentity&&(this._itemsByIdentity[a]=
d),d[this._rootItemPropName]&&this._arrayOfTopLevelItems.push(d);for(a in this._pending._deletedItems)d=this._pending._deletedItems[a],d["backupRefs_"+this._reverseRefMap]&&(m.forEach(d["backupRefs_"+this._reverseRefMap],function(a){this._addReferenceToMap(this._itemsByIdentity?this._itemsByIdentity[a.id]:this._arrayOfAllItems[a.id],d,a.attr)},this),delete d["backupRefs_"+this._reverseRefMap]);for(a in this._pending._newItems)b=this._pending._newItems[a],b[this._storeRefPropName]=null,this._arrayOfAllItems[b[this._itemNumPropName]]=
null,b[this._rootItemPropName]&&this._removeArrayElement(this._arrayOfTopLevelItems,b),this._itemsByIdentity&&delete this._itemsByIdentity[a];this._pending={_newItems:{},_modifiedItems:{},_deletedItems:{}};return!0},isDirty:function(a){return a?(a=this.getIdentity(a),(new Boolean(this._pending._newItems[a]||this._pending._modifiedItems[a]||this._pending._deletedItems[a])).valueOf()):!this._isEmpty(this._pending._newItems)||!this._isEmpty(this._pending._modifiedItems)||!this._isEmpty(this._pending._deletedItems)},
onSet:function(a,b,c,e){},onNew:function(a,b){},onDelete:function(a){},close:function(a){if(this.clearOnClose){if(this.isDirty())throw Error("dojo.data.ItemFileWriteStore: There are unsaved changes present in the store.  Please save or revert the changes before invoking close.");this.inherited(arguments)}}})});