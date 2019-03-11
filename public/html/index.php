﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Streamedian HTML5 RTSP player</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        body {
            max-width: 720px;
            margin: 50px auto;
        }

        #test_video {
            width: 720px;
        }

        .controls {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        input.input, .form-inline .input-group>.form-control {
            width: 300px;
        }
        #logs {
	    overflow: auto;
	    width: 720px;
	    height: 150px;
	    padding: 5px;
	    border-top: solid 1px gray;
	    border-bottom: solid 1px gray;
	}
	button {
	    margin: 5px
	}
    </style>
</head>
<body onLoad="set_url(new_url)">
<div>
    <input id="stream_url" size="36">
    <!--<button id="set_new_url" onclick = "set_url(new_url)">Set</button>-->
</div>
<div>
<p style="color:#808080">Enter your rtsp link to the stream, for example: "rtsp://192.168.1.1:554/h264"</p>
</div>
<video id="test_video" controls autoplay>
    
</video>
<script src="free.player.1.8.js"></script> <!-- Path to pleer js-->
<script>
	var new_url = " ";
	function set_url(url)
	{
		//var text = document.getElementById('stream_url').value;
		var text="rtsp://Admin:1234@192.168.1.200:554/h264_2";
	    url = text;
		test_video.src = url;
		Streamedian.player('test_video', {socket:"ws://127.0.0.1:8080/ws/"});
		var player = document.getElementById('test_video');
	}
</script>
<script>
    // define a new console
    var console=(function(oldConsole){
	    return {
		    log: function(){
			let text = '';
			let node = document.createElement("div");
			for (let arg in arguments){
			    text +=' ' + arguments[arg];
			}
			oldConsole.log(text);
			node.appendChild(document.createTextNode(text));
			document.getElementById("logs").appendChild(node);
		    },
		    info: function () {
			let text = '';
			for (let arg in arguments){
			    text +='' + arguments[arg];
			}
			oldConsole.info(text);
		    },
		    warn: function () {
			let text = '';
			for (let arg in arguments){
			    text +=' ' + arguments[arg];
			}
			oldConsole.warn(text);
		    },
		    error: function () {
			let text = '';
			for (let arg in arguments){
			    text +=' ' + arguments[arg];
			}
			oldConsole.error(text);
		    }
	    };
    }(window.console));

    //Then redefine the old console
    window.console = console;
    
    function cleanLog(){
	let  node = document.getElementById("logs");
	while (node.firstChild) {
	    node.removeChild(node.firstChild);
	}
    }
    
    function scrollLog(){
	console.warn("scroll");
	let node = document.getElementById("logs");
	node.scrollTop = node.scrollHeight;
    }
</script>
<p><br>Have any suggestions to improve our player? <br>Feel free to leave comments or ideas email: streamedian.player@gmail.com</p>
<p>View player log</p>
<div id="logs"></div>
<button class="btn btn-success" onclick="cleanLog()">clear</button><button class="btn btn-success" onclick="scrollLog()">scroll to end</button>
</body>
</html>
