//Global variables
var emotionData = [{emotion: "angry", value: 0}, {emotion: "sad", value: 0}, {
    emotion: "surprised",
    value: 0
}, {emotion: "happy", value: 0}];
var currentEmotion;

var update = true;
function stopUpdateData() {
    update = false;
}

//Define emotion
function updateData(data) {

    if (update == true) {

        //Takes data from default data object and puts it into accessible emotionData array of objects
        emotionData[0].value = data[0].value;
        emotionData[1].value = data[1].value;
        emotionData[2].value = data[2].value;
        emotionData[3].value = data[3].value;

        //for loop to keep track of the detected emotion's data.
        for (var i = 0; i < data.length; i++) {

            //if/else statements to define currentEmotion and start the soundcloud stream() function.
            if ((data[i].emotion == 'angry') && (data[i].value >= 0.8)) {
                streamAngry();
                currentEmotion = 'angry';
                console.log(currentEmotion);
            }

            else if ((data[i].emotion == 'sad') && (data[i].value >= 0.8)) {
                streamSad();
                currentEmotion = 'sad';
                console.log(currentEmotion);
            }

            else if ((data[i].emotion == 'surprised') && (data[i].value >= 0.8)) {
                streamSurprised();
                currentEmotion = 'surprised';
                console.log(currentEmotion);
            }

            else if ((data[i].emotion == 'happy') && (data[i].value >= 0.8)) {
                streamHappy();
                currentEmotion = 'happy';
                console.log(currentEmotion);
            }
        }

        // update
        var rects = svg.selectAll("rect")
            .data(data)
            .attr("y", function (datum) {
                return height - y(datum.value);
            })
            .attr("height", function (datum) {
                return y(datum.value);
            });
        var texts = svg.selectAll("text.labels")
            .data(data)
            .attr("y", function (datum) {
                return height - y(datum.value);
            })
            .text(function (datum) {
                return datum.value.toFixed(1);
            });

        // enter
        rects.enter().append("svg:rect");
        texts.enter().append("svg:text");

        // exit
        rects.exit().remove();
        texts.exit().remove();
    }
}

function detectEmotion(data) {
    var highestValue = 0;
    var highestEmotion;
    for (var i = 0; i < data.length; i++) {
        if (data[i].value > highestValue) {
            highestValue = data[i].value;
            highestEmotion = data[i].emotion;
        }
    }
    return highestEmotion;
}
