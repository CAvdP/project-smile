/**
 * Created by Aranity on 05/04/2016.
 */
var ctx, color = "#000";

$(document).ready(function () {

    // setup a new canvas for drawing wait for device init
    setTimeout(function(){
        newCanvas();
    }, 1000);

    // reset palette selection (css) and select the clicked color for canvas strokeStyle
    $(".palette").click(function(){
        $(".palette").css("border-color", "#777");
        $(".palette").css("border-style", "solid");
        $(this).css("border-color", "#fff");
        $(this).css("border-style", "dashed");
        color = $(this).css("background-color");
        ctx.beginPath();
        ctx.strokeStyle = color;
    });

    // link the new button with newCanvas() function
    $("#new").click(function() {
        newCanvas();
    });
});

// function to setup a new canvas for drawing
function newCanvas(){
    //define and resize canvas
    //$("#paintContainer").height($(window).height()-90);
    var canvas = '<canvas id="canvas" width="600" height="450"></canvas>';
    $("#paintContainer").html(canvas);

    // setup canvas
    ctx=document.getElementById("canvas").getContext("2d");
    ctx.strokeStyle = color;
    ctx.lineWidth = 10;

    // setup to trigger drawing on mouse or touch
    $("#canvas").drawTouch();
    $("#canvas").drawPointer();
    $("#canvas").drawMouse();
}

// prototype to	start drawing on touch using canvas moveTo and lineTo
$.fn.drawTouch = function() {
    var start = function(e) {
        e = e.originalEvent;
        ctx.beginPath();
        x = e.changedTouches[0].pageX-465;
        y = e.changedTouches[0].pageY-260;
        ctx.moveTo(x,y);
    };
    var move = function(e) {
        e.preventDefault();
        e = e.originalEvent;
        x = e.changedTouches[0].pageX-465;
        y = e.changedTouches[0].pageY-260;
        ctx.lineTo(x,y);
        ctx.stroke();
    };
    $(this).on("touchstart", start);
    $(this).on("touchmove", move);
};

// prototype to	start drawing on pointer(microsoft ie) using canvas moveTo and lineTo
$.fn.drawPointer = function() {
    var start = function(e) {
        e = e.originalEvent;
        ctx.beginPath();
        x = e.pageX+1000;
        y = e.pageY-44;
        ctx.moveTo(x,y);
    };
    var move = function(e) {
        e.preventDefault();
        e = e.originalEvent;
        x = e.pageX;
        y = e.pageY-44;
        ctx.lineTo(x,y);
        ctx.stroke();
    };
    $(this).on("MSPointerDown", start);
    $(this).on("MSPointerMove", move);
};

// prototype to	start drawing on mouse using canvas moveTo and lineTo
$.fn.drawMouse = function() {
    var clicked = 0;
    var start = function(e) {
        clicked = 1;
        ctx.beginPath();
        x = e.pageX-465;
        y = e.page-260;
        ctx.moveTo(x,y);
    };
    var move = function(e) {
        if(clicked){
            x = e.pageX-465;
            y = e.pageY-260;
            ctx.lineTo(x,y);
            ctx.stroke();
        }
    };
    var stop = function(e) {
        clicked = 0;
    };
    $(this).on("mousedown", start);
    $(this).on("mousemove", move);
    $(window).on("mouseup", stop);
};

// Convert snapshot to base64 string
var canvas = document.getElementById("canvas");
var dataURLCanvas = canvas.toDataURL("image/png");

// AJAX Call to send base64 string to upload php file for processing
$.ajax({
    type: "POST",
    url: "php/mergeCanvas.php",
    data: {
        canvasBase64: dataURLCanvas
    }
}).done(function(o) {
    console.log('saved');
});
