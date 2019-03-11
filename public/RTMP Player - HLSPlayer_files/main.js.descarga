function initShareButtons(){var init=function(selector,width,height,url){var left=(screen.width- width)/ 2;
var top=(screen.height- height)/ 2;
var params='top='+ top+', left='+ left+', width='+ width
+', height='+ height;$(selector).click(function(){window.open(url,'_blank',params);});}
var url=encodeURIComponent(location.href);var text=encodeURIComponent($(document).find("title").text());init('.hp-social-fb',550,420,'https://www.facebook.com/sharer.php?u='
+ url);init('.hp-social-tw',550,420,'https://twitter.com/share?url='+ url
+'&text='+ text);init('.hp-social-gp',550,500,'https://plus.google.com/share?url='+ url);}
function isMobile(){return(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));}
var videojsInitialized=false;var videojsPlayer=null;function playM3U8(src){$('#player-tip').hide();if(isMobile()){var html='<video id="player" controls autoplay>';html+='<source src="'+ src+'" type="application/x-mpegurl">'
html+='<source src="'+ src+'" type="video/mp4">'
html+='</video>';$('#player').replaceWith(html);return;}
if(videojsPlayer){videojsPlayer.dispose();videojsPlayer=null;$('#player-container').append('<div id="player"></div>');}
if($('#player-proxy').prop('checked')){playM3U8byGrindPlayer(src.replace(/https?:\/\//i,'https://proxy.hlsplayer.net/fetch.php/'));}else{playM3U8byGrindPlayer(src);}}
function playM3U8byGrindPlayer(src){if(src.indexOf(".3mu8")==-1){src=src+"#.m3u8";}
var flashvars={autoPlay:'true',src:escape(src),scaleMode:'letterbox',plugin_hls:'/player/grindplayer/flashlsOSMF.swf',hls_debug:false,hls_debug2:false,hls_minbufferlength:-1,hls_lowbufferlength:2,hls_maxbufferlength:60,hls_startfromlowestlevel:false,hls_seekfromlowestlevel:false,hls_live_flushurlcache:false,hls_seekmode:'ACCURATE',hls_capleveltostage:false,hls_maxlevelcappingmode:'downscale'};var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};var attributes={id:'player'};swfobject.embedSWF('/player/grindplayer/GrindPlayer.swf','player','640','480','10.2',null,flashvars,params,attributes);}
function playM3U8byVideoJS(src){if(!videojsInitialized){videojsInitialized=true;var link=document.createElement('link');link.href='/player/videojs/video-js.css';link.rel='stylesheet';document.body.appendChild(link);var script=document.createElement('script');script.src='/player/videojs/videojs-hls-bundle.js';script.onload=function(){playM3U8byVideoJSCallback(src);};document.body.appendChild(script);}else{playM3U8byVideoJSCallback(src);}}
function playM3U8byVideoJSCallback(src){var attributes={'id':'player','class':'video-js vjs-default-skin','width':'auto','height':'auto','controls':' ','autoplay':'','preload':'auto','data-setup':'{}'}
var element=$('<video><source type="application/x-mpegURL" src="'+ src
+'"></source></video>').attr(attributes)
$("#player").replaceWith(element);videojsPlayer=videojs("#player",{},function(){});}
function playRTMP(src){$('#player-tip').hide();if(isMobile()){$('#player-tip').html("RTMP protocol is not supported on your device.");return;}
var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};var attributes={id:'player'};swfobject.embedSWF('/player/grindplayer/GrindPlayer.swf','player','640','480','10.2',null,flashvars,params,attributes);}
function playMP4(src){$('#player-tip').hide();var html='<video id="player" controls autoplay>';html+='<source src="'+ src+'" type="video/mp4">'
html+='</video>';$('#player').replaceWith(html);}
$(document).ready(function(){initShareButtons();});