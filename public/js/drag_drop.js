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

var supportsProgress = document.createElement("progress").max !== undefined;
if (!supportsProgress) {
    progress.setAttribute("data-state", "fake");
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("Data");
    var son = document.getElementById(data);
    var route = son.getAttribute("value");
    var x = document.createElement("VIDEO");
    var ftp= son.getAttribute("data_route");
    x.setAttribute("id", son.id);
    x.setAttribute("data-type", "video");
    x.setAttribute("controls", "");
    x.setAttribute("ondragover", "noAllowDrop(event)");
    x.setAttribute("class", "video-js vjs-default-skin col-md-3");
    x.setAttribute("name", son.name);
    x.setAttribute("prop",ftp);
    x.setAttribute("value", route);

    x.addEventListener(
        "play",
        function() {
            changeButtonState("playpause");
        },
        false
    );
    x.addEventListener(
        "pause",
        function() {
            changeButtonState("playpause");
        },
        false
    );

    if (route != null) {
        if (Hls.isSupported()) {
            var y = new Hls();
            y.loadSource(route);
            y.attachMedia(x);
            document.getElementById("Controls").style.display = "";
            y.on(Hls.Events.MANIFEST_PARSED, function() {
                //x.play();
            });
        } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
            document.getElementById("Controls").style.display = "";
            video.addEventListener("canplay", function() {});
        }

        ev.target.append(x);
        son.parentNode.removeChild(son);
    }

    var divs = document.getElementsByTagName("VIDEO").length;
    if (divs <= 1) {
        x.setAttribute("style", "width: 80%");
    } else if (divs > 1) {
        var videos = document.querySelectorAll("video");
        for (var v = 0; v < videos.length; v++) {
            console.log(v);
            document
                .getElementsByTagName("video")[0]
                .setAttribute("style", "width: 43%");
            x.setAttribute("style", "width: 43%");
        }
    }
}
