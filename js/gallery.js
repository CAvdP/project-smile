/**
 * Created by Aranity on 18/03/2016.
 */
$(init);


function init () {
    getFlickrPhotos()
        .then(photosToListItems)
        .then(function (data) { printPhotos (data, 4)});

}

function getFlickrPhotos() {
    return $.ajax({
        method: 'GET',
        url: 'php/showPhotos.php',
        dataType: 'json'
    });
}

function photosToListItems (data) {
    return data.photoset.photo.map(function (item) {
        var li = $('<li>');
        var img = $('<img/>', { src: 'https://farm' + item.farm + '.staticflickr.com/' + item.server + '/' +item.id + '_' + item.secret + '.jpg' });
        li.append(img);

        return li;
    });
}

//probeer deze functie generiek te maken.
function printPhotos (data, amount) {
    var first = $('#firstRow');
    var second = $('#secondRow');

    data.forEach(function (item, array, i) {
        if (amount < i) {
            first.append(item);
        }
        else {
            second.append(item);
        }
    });
}
