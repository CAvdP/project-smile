<?php

require_once('../includes/dbConnect.php');
require_once('../includes/settings.php');

$mysqli = new mysqli($host, $user, $pass, $db);

$countResult = $mysqli->query("SELECT * FROM `number_counter`");
for ($num = array (); $row = $countResult->fetch_assoc(); $num[] = $row);
print_r($num);

$img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
var_dump($img);

//saving
//$i = 0;
//$fileName = 'img_' . $i++ . '.png';
//$target_dir = "../uploads/";

//file_put_contents($target_dir . $fileName, $fileData);
$mysqli->close();
/**
 * fetch count > add count to photo name > plus one on count var >
 * upload updated count back to db > upload image link to db
 */

//$target_dir = "uploads/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
//    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//    if($check !== false) {
//        echo "File is an image - " . $check["mime"] . ".";
//        $uploadOk = 1;
//    } else {
//        echo "File is not an image.";
//        $uploadOk = 0;
//    }
//}
//// Check if file already exists
//if (file_exists($target_file)) {
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
//}
//// Check file size
//if ($_FILES["fileToUpload"]["size"] > 500000) {
//    echo "Sorry, your file is too large.";
//    $uploadOk = 0;
//}
//// Allow certain file formats
//if($imageFileType != "png") {
//    echo "Sorry, only PNG files are allowed.";
//    $uploadOk = 0;
//}
//// Check if $uploadOk is set to 0 by an error
//if ($uploadOk == 0) {
//    echo "Sorry, your file was not uploaded.";
//// if everything is ok, try to upload file
//} else {
//    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
//    } else {
//        echo "Sorry, there was an error uploading your file.";
//    }
//}
