<?php
$png_img = "../uploads/img_0.png";
$png_canvas = "../uploads/canvas_0.png";

$bottom_image = imagecreatefrompng($png_img); // import image to var - IMAGE URL HERE
$top_image = imagecreatefrompng($png_canvas); // import image to var - IMAGE URL HERE
imagealphablending($bottom_image, true); // enable alpha blending
imagesavealpha($bottom_image, true); // save new alpha setting
imagecopy($bottom_image, $top_image, 0, 0, 0, 0, 600, 450); // copy top_image onto bottom_image, vars: bottom_image, top_image, no idea, no idea, no idea, no idea, width of images, height of images
imagepng($bottom_image, '../uploads/merged_image.png'); // save created image as new image


if (!isset($postresult)) {
	$posturl = 'https://api.cloudinary.com/v1_1/dzczkimrn/image/upload/';
	$postdata = array('tags' => 'project_smile_photos', 'file' => 'https://www.bandy.nl/project-smile/uploads/merged_image.png', 'upload_preset' => 'dmcgpjjg');

	// use key 'http' even if you send the request to https://...
	$postoptions = array(
			'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'method' => 'POST',
					'content' => http_build_query($postdata)
			)
	);
	$postcontext = stream_context_create($postoptions);
	$postresult = file_get_contents($posturl, false, $postcontext);
}


//pull from cloudinary
//take last image
//link image to detected emotion
//push to database

if (!isset($imgUrl)) {
	$geturl = 'http://res.cloudinary.com/dzczkimrn/image/list/project_smile_photos.json';
	$getdata = array('tags' => 'project_smile_photos');

// use key 'http' even if you send the request to https://...
	$getoptions = array(
			'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'method' => 'GET',
					'content' => http_build_query($getdata)
			)
	);
	$getcontext = stream_context_create($getoptions);
	$getresult = file_get_contents($geturl, false, $getcontext);

	$imageobject = json_decode($getresult);

	$id = $imageobject->resources[0]->public_id;
	$version = $imageobject->resources[0]->version;

	$imgUrl = "http://res.cloudinary.com/dzczkimrn/image/upload/v" . $version . "/" . $id . ".png";
	$emotion = $_POST['emotion'];

	require_once "database.php";
	$sql = "INSERT INTO fotodata (link, emotion) VALUES ('$imgUrl', '$emotion');";
	echo $sql;
	$runquery = mysqli_query($db, $sql);
	mysqli_close($db);
}