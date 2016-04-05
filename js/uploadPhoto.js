function postPhoto() {
    console.log();
    var request = new XMLHttpRequest();
    request.open('POST', 'https://api.smileplayground.com/v1_1/dzczkimrn/image/upload', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    var data = "upload_preset=dmcgpjjg&tags=project_smile_photos&file=www.florisschippers.nl/project-smile/uploads/merged_image.png"; // IMAGE URL HERE
    request.send(data);
}