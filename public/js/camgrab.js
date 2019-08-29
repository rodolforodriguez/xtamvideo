// Display the user defined video controls
var videoControls = document.getElementById("video-controls");
var stop = document.getElementById("stop");
var mute = document.getElementById("mute");
var progress = document.getElementById("progress");
var progressBar = document.getElementById("progress-bar");
//videoControls.setAttribute("data-state", "visible");

//funcionalidad de botones play pause mute
var changeButtonState = function(type) {
    // Play/Pause button
    if (type == "playpause") {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            if (video.paused || video.ended) {
                playpause.setAttribute("data-state", "play");
            } else {
                playpause.setAttribute("data-state", "pause");
            }
            if (type == "mute") {
                mute.setAttribute(
                    "data-state",
                    video.muted ? "unmute" : "mute"
                );
            }
        }
    }
};
