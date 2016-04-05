<?php
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

include "mergeCanvas.php";
