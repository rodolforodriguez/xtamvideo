
// Display the user defined video controls
var videoControls = document.getElementById('video-controls');
var stop = document.getElementById('stop');
var mute = document.getElementById('mute');
var progress = document.getElementById('progress');
var progressBar = document.getElementById('progress-bar');

videoControls.setAttribute('data-state', 'visible');

//funcionalidad de botones play pause mute
var changeButtonState = function (type) {
    // Play/Pause button
    if (type == 'playpause') {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = document.getElementById(videos[v].getAttribute("id"));
            if (video.paused || video.ended) {
                playpause.setAttribute('data-state', 'play');
            } else {
                playpause.setAttribute('data-state', 'pause');
            }
            if (type == 'mute') {
                mute.setAttribute('data-state', video.muted ? 'unmute' : 'mute');
            }
        }

    }
    // Mute button

}

stop.addEventListener('click', function (e) {
    var videos = document.querySelectorAll('[data-type="video"]');
    for (var v = 0; v < videos.length; v++) {
        var video = videos[v];
        video.pause();
        video.currentTime = 0;
        progress.value = 0;
        // Update the play/pause button's 'data-state' which allows the correct button image to be set via CSS
        changeButtonState('playpause');
    }
});

mute.addEventListener('click', function (e) {
    var videos = document.querySelectorAll('[data-type="video"]');
    for (var v = 0; v < videos.length; v++) {
        var video = videos[v];
        video.muted = !video.muted;
        changeButtonState('mute');
    }
});

//navegador bloquea los elementos play pause
playpause.addEventListener('click', function (e) {
    var videos = document.querySelectorAll('[data-type="video"]');
    for (var v = 0; v < videos.length; v++) {
        var video = videos[v];
        if (video.paused || video.ended) {
            video.play();
        } else {
            video.pause();
        }


        video.addEventListener('loadedmetadata', function () {
            progress.setAttribute('max', video.duration);
        });

        // As the video is playing, update the progress bar
        video.addEventListener('timeupdate', function () {
            // For mobile browsers, ensure that the progress element's max attribute is set
            if (!progress.getAttribute('max')) progress.setAttribute('max', video.duration);
            progress.value = video.currentTime;
            progressBar.style.width = Math.floor((video.currentTime / video.duration) * 100) + '%';
        });
    }
});

// React to the user clicking within the progress bar
progress.addEventListener('click', function (e) {
    var videos = document.querySelectorAll('[data-type="video"]');
    for (var v = 0; v < videos.length; v++) {
        var video = videos[v];
        var pos = (e.pageX - this.offsetLeft) / this.offsetWidth;
        video.currentTime = pos * video.duration;
    }
});