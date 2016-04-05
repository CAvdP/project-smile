/**
 * Created by mark molendijk on 01/04/16.
 */
window.addEventListener("load", init);

function init (){
    uploadImg();
}


function uploadImg (){
    $.cloudinary.config({cloud_name: 'dzczkimrn', api_key: '254356915778771'});

    $('#uploadInput').unsigned_cloudinary_upload("dmcgpjjg",
        {cloud_name: 'dzczkimrn', tags: 'project_smile_photos'}
    );

}
