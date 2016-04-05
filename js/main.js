/**
 * Created by Aranity on 15/03/2016.
 */

// getUserMedia only works over https in Chrome 47+, so we redirect to https. Also notify user if running from file.
if (window.location.protocol == "file:") {
    alert("You seem to be running this example directly from a file. Note that these examples only work when served from a server or localhost due to canvas cross-domain restrictions.");
} else if (window.location.hostname !== "localhost" && window.location.protocol !== "https:") {
    window.location.protocol = "https";
}

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-32642923-1']);
_gaq.push(['_trackPageview']);

(function () {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();


var vid = document.getElementById('videoel');
var overlay = document.getElementById('overlay');
var overlayCC = overlay.getContext('2d');

/********** check and set up video/webcam **********/

function enableStart() {
    var startButton = document.getElementById('startButton');
    startButton.value = "start";
    startButton.disabled = null;
}
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
window.URL = window.URL || window.webkitURL || window.msURL || window.mozURL;

// check for camerasupport
if (navigator.getUserMedia) {
    // set up stream

    var videoSelector = {video: true};
    if (window.navigator.appVersion.match(/Chrome\/(.*?) /)) {
        var chromeVersion = parseInt(window.navigator.appVersion.match(/Chrome\/(\d+)\./)[1], 10);
        if (chromeVersion < 20) {
            videoSelector = "video";
        }
    }


    navigator.getUserMedia(videoSelector, function (stream) {
        if (vid.mozCaptureStream) {
            vid.mozSrcObject = stream;
        } else {
            vid.src = (window.URL && window.URL.createObjectURL(stream)) || stream;
        }
        vid.play();
    }, function () {
        //insertAltVideo(vid);
        alert("There was some problem trying to fetch video from your webcam. If you have a webcam, please make sure to accept when the browser asks for access to your webcam.");
    });
} else {
    //insertAltVideo(vid);
    alert("This demo depends on getUserMedia, which your browser does not seem to support. :(");
}

vid.addEventListener('canplay', enableStart, false);

/*********** setup of emotion detection *************/

var ctrack = new clm.tracker({useWebGL: true});
ctrack.init(pModel);

function startVideo() {
    // start video
    vid.play();
    // start tracking
    ctrack.start(vid);
    // start loop to draw face
    drawLoop();
}

function drawLoop() {
    requestAnimFrame(drawLoop);
    overlayCC.clearRect(0, 0, 400, 300);
    //psrElement.innerHTML = "score :" + ctrack.getScore().toFixed(4);
    if (ctrack.getCurrentPosition()) {
        ctrack.draw(overlay);
    }
    var cp = ctrack.getCurrentParameters();

    var er = ec.meanPredict(cp);
    if (er) {
        updateData(er);
        for (var i = 0; i < er.length; i++) {
            if (er[i].value > 0.4) {
                document.getElementById('icon' + (i + 1)).style.visibility = 'visible';
            } else {
                document.getElementById('icon' + (i + 1)).style.visibility = 'hidden';
            }
        }
    }
}

var ec = new emotionClassifier();
ec.init(emotionModel);
var emotionData = ec.getBlank();

/************ d3 code for barchart *****************/

var margin = {top: 20, right: 20, bottom: 10, left: 40},
    width = 400 - margin.left - margin.right,
    height = 100 - margin.top - margin.bottom;

var barWidth = 30;

var x = d3.scale.linear()
    .domain([0, ec.getEmotions().length]).range([margin.left, width + margin.left]);

var y = d3.scale.linear()
    .domain([0, 1]).range([0, height]);

var svg = d3.select("#emotion_chart").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom);

svg.selectAll("rect").data(emotionData).enter().append("svg:rect").attr("x", function (datum, index) {
    return x(index);
}).attr("y", function (datum) {
    return height - y(datum.value);
}).attr("height", function (datum) {
    return y(datum.value);
}).attr("width", barWidth).attr("fill", "#2d578b");

svg.selectAll("text.labels").data(emotionData).enter().append("svg:text").attr("x", function (datum, index) {
    return x(index) + barWidth;
}).attr("y", function (datum) {
    return height - y(datum.value);
}).attr("dx", -barWidth / 2).attr("dy", "1.2em").attr("text-anchor", "middle").text(function (datum) {
    return datum.value;
}).attr("fill", "white").attr("class", "labels");

svg.selectAll("text.yAxis").data(emotionData).enter().append("svg:text").attr("x", function (datum, index) {
    return x(index) + barWidth;
}).attr("y", height).attr("dx", -barWidth / 2).attr("text-anchor", "middle").attr("style", "font-size: 12").text(function (datum) {
    return datum.emotion;
}).attr("transform", "translate(0, 18)").attr("class", "yAxis");

///******** stats ********/
//
//stats = new Stats();
//stats.domElement.style.position = 'absolute';
//stats.domElement.style.top = '0px';
//document.getElementById('container').appendChild(stats.domElement);
//
//// update stats on every iteration
//document.addEventListener('clmtrackrIteration', function () {
//    stats.update();
//}, false);

var detectedEmotion;

window.addEventListener("DOMContentLoaded", function () {
    // Grab elements, create settings, etc.
    var canvas = document.getElementById("canvas"),
        context = canvas.getContext("2d"),
        video = document.getElementById("videoel");

    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function () {
        context.drawImage(video, 0, 0, 600, 450);
        detectedEmotion = detectEmotion(emotionData);
        console.log("Detected emotion: " + detectedEmotion);

        // Convert snapshot to base64 string
        var canvas = document.getElementById("canvas");
        var dataURL    = canvas.toDataURL("image/png");
        
        // AJAX Call to send base64 string to upload php file for processing
        $.ajax({
            type: "POST",
            url: "php/uploadPhotos.php",
            data: {
                imgBase64: dataURL
            }
        }).done(function(o) {
            console.log('saved');
        });

    });
}, false);
