// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.27/esri/copyright.txt for details.
//>>built
define("esri/dijit/geoenrichment/utils/signIn/SignInHelper",["dojo/Deferred","dojo/when","esri/arcgis/OAuthInfo","esri/IdentityManager","esri/kernel"],function(g,h,k,a,d){return{signIn:function(b){var e=new g;b.forceFreshStart&&d.id.destroyCredentials();var f=function(){var a=d.id.credentials[0];h(b.callback&&b.callback(a),function(){e.resolve(a)})},c=new k({portalUrl:b.portalUrl,appId:b.appId,popup:!!b.popup});a.registerOAuthInfos([c]);a.checkSignInStatus(c.portalUrl).then(f).otherwise(function(){a.getCredential(c.portalUrl,
{oAuthPopupConfirmation:!1}).then(f)});return e.promise},registerToken:function(){}}});