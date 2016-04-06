<?php
$png_img = "../uploads/img_0.png";
$png_canvas = "../uploads/canvas_0.png";

$bottom_image = imagecreatefrompng($png_img); // import image to var - IMAGE URL HERE
$top_image = imagecreatefrompng($png_canvas); // import image to var - IMAGE URL HERE
imagealphablending($bottom_image, true); // enable alpha blending
imagesavealpha($bottom_image, true); // save new alpha setting
imagecopy($bottom_image, $top_image, 0, 0, 0, 0, 600, 450); // copy top_image onto bottom_image, vars: bottom_image, top_image, no idea, no idea, no idea, no idea, width of images, height of images
imagepng($bottom_image, '../uploads/merged_image.png'); // save created image as new image


if(!isset($result)){
	$url = 'https://api.cloudinary.com/v1_1/dzczkimrn/image/upload/';
	$data = array('tags' => 'project_smile_photos', 'file' => 'https://www.bandy.nl/project-smile/uploads/merged_image.png', 'upload_preset' => 'dmcgpjjg');

	// use key 'http' even if you send the request to https://...
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($data)
	    )
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
}