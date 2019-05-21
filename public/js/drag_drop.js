//drag and drop

        function allowDrop(ev) {
            ev.preventDefault();
        }
    
    function noAllowDrop(ev) {
            ev.stopPropagation();
        }
    
    function drag(ev) {
            ev.dataTransfer.setData("Data", ev.target.id);
        }
    
        var supportsProgress = (document.createElement('progress').max !== undefined);
    if (!supportsProgress) {
            progress.setAttribute('data-state', 'fake');
        }
    
    /*progress.addEventListener('click', function(e) {
        var pos = (e.pageX - (this.offsetLeft + this.offsetParent.offsetLeft)) / this.offsetWidth;
        x.currentTime = pos * video.duration;
    });*/

    function drop(ev) {
            ev.preventDefault();
        var data = ev.dataTransfer.getData("Data");
        var son = document.getElementById(data);
        var route = son.getAttribute("data-route");
        var x = document.createElement("VIDEO");
        x.setAttribute("id", "cam_" + son.id);
        x.setAttribute("data-type", "video");
        x.setAttribute("ondragover", "noAllowDrop(event)");
        x.setAttribute("class", "video-js vjs-default-skin col-md-3");
        x.setAttribute("src", "../format/input/index.m3u8')}}");
        //{{asset('format/input/index.m3u8')}}
        x.addEventListener('click', function() {

            //Remplazando espacios en el nombre
            var videoname = son.id;
        var replaced = videoname.split(' ').join('');
        alert(replaced);

            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
            xmlhttp.open("GET", "../format/code/download.blade.php?video=" + replaced);
        xmlhttp.send();

        /*var video = document.createElement("a");
        video.setAttribute("href", "http://localhost/xtamvideo/resources/views/grabaciones/m3u8/index.m3u8");
        video.setAttribute("download", son.id + ".mp4");
        video.click();*/
    }, false);

        x.addEventListener('play', function() {
            changeButtonState('playpause');
        }, false);

        x.addEventListener('pause', function() {
            changeButtonState('playpause');
        }, false);

        if (!route) {

            if (Hls.isSupported()) {
                var y = new Hls();
                y.loadSource("../format/input/index.m3u8");
                y.attachMedia(x);
                y.on(Hls.Events.MANIFEST_PARSED, function() {

        });

            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = "../format/input/index.m3u8";
        video.addEventListener('canplay', function() {

        });
    }

    /*    var duration = "";
                x.addEventListener('loadedmetadata', function() {
            progress.setAttribute('max', x.duration);

        // obtener duracion para input time
        var vidseg = x.duration;
        x.setAttribute("videoduration", x.duration);
        var minutos = Math.floor(vidseg / 60);
        var seconds = vidseg - minutos * 60;
        var hour = 0;
                    if (10 > hour) {
            hour = '0' + hour;
        }
                    if (10 > minutos) {
            minutos = '0' + minutos;
        }
                    if (10 > seconds) {
            seconds = '0' + seconds;
        }

        var res = hour + ":" + minutos + ":" + seconds;
        var videotime = res.substring(0, 8);

        document.getElementById("timeend").value = videotime;
        document.getElementById("timeinitial").value = "00:00:00";
        document.getElementById("timeinitial").max = videotime;

                    x.addEventListener('volumechange', function() {
            checkVolume();
        }, false);
    });*/
document.getElementById("Controls").style.display = "";
        } else {
            x.setAttribute("src", route);
        document.getElementById("Controls").style.display = "";
    }

    // x.setAttribute("width", 500);
    // x.setAttribute("height", 500);
    ev.target.append(x);

    son.parentNode.removeChild(son);

}

    function droplink(ev) {
            ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        var son = document.getElementById(data);
        var x = document.createElement("a");
        var route = son.getAttribute("data-route");
        ev.target.target(obj);
    }
