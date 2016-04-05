<?php

// Use base64_decode to create png file from given string from POST
$img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);

// Saving the png file with correct name and location directory
$i = 0;
$fileName = 'img_'.$i++.'.png';
$target_dir = "../uploads/";

// Send png file to target directory
$png_img = file_put_contents($target_dir . $fileName, $fileData);

// Canvas png
$imgCanvas = $_POST['canvasBase64'];
$imgCanvas = str_replace('data:image/png;base64,', '', $imgCanvas);
$imgCanvas = str_replace(' ', '+', $imgCanvas);
$fileDataCanvas = base64_decode($imgCanvas);

// Saving the png file with correct name and location directory
$x = 0;
$canvasName = 'canvas_'.$x++.'.png';
$target_dir = "../uploads/";

// Send png canvas file to target directory
$png_canvas = file_put_contents($target_dir . $canvasName, $fileDataCanvas);

$bottom_image = imagecreatefrompng($png_img); // import image to var - IMAGE URL HERE
$top_image = imagecreatefrompng($png_canvas); // import image to var - IMAGE URL HERE
imagealphablending($bottom_image, true); // enable alpha blending
imagesavealpha($bottom_image, true); // save new alpha setting
imagecopy($bottom_image, $top_image, 0, 0, 0, 0, 600, 450); // copy top_image onto bottom_image, vars: bottom_image, top_image, no idea, no idea, no idea, no idea, width of images, height of images
imagepng($bottom_image, '../upload/merged_image.png'); // save created image as new image
