/**
 * Created by Ken Fontijne on 18-3-2016.
 */

//Global variables
var currentEmotion;

//Define emotion
function updateData(data) {

    if (counter == 0) {
        console.log(data);
        counter = 1;
    }

    //for loop to keep track of the detected emotion's data.
    for (var i = 0; i < data.length; i++) {

        //if/else statements to define currentEmotion and start the soundcloud stream() function.
        if ((data[i].emotion == 'angry') && (data[i].value >= 0.8)){
            currentEmotion = 'angry';
            streamAngry();
            //console.log(currentEmotion);
        }

        else if ((data[i].emotion == 'sad') && (data[i].value >= 0.8)){
            currentEmotion = 'sad';
            streamSad();
            //console.log(currentEmotion);
        }

        else if ((data[i].emotion == 'surprised') && (data[i].value >= 0.8)){
            currentEmotion = 'surprised';
            streamSurprised();
            //console.log(currentEmotion);
        }

        else if ((data[i].emotion == 'happy') && (data[i].value >= 0.8)){
            currentEmotion = 'happy';
            streamHappy();
            //console.log(currentEmotion);
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
