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

include "mergeCanvas.php";
