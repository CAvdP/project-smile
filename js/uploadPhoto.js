function postPhoto() {
    console.log("function postPhoto called");
    var request = new XMLHttpRequest();
    request.open('POST', 'https://api.cloudinary.com/v1_1/dzczkimrn/image/upload/', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    var data = "tags=project_smile_photos&file=https://www.bandy.nl/project-smile/uploads/merged_image.png&upload_preset=dmcgpjjg"; // IMAGE URL HERE
    request.send(data);
    console.log(data);
}