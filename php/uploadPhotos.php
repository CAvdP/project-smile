<?php

require_once('../includes/dbConnect.php');
require_once('../includes/settings.php');

// Create new mysqli connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Use base64_decode to create png file from given string from POST
$img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
var_dump($img);

//// Saving the png file with correct name and location directory
$i = 0;
$fileName = 'img_'.$i++.'.png';
$target_dir = "../uploads/";

// Send png file to target directory
file_put_contents($target_dir . $fileName, $fileData);


// Query for updating count to counter table
//$countUpdate = $mysqli->query("UPDATE `number_counter` SET `$i` WHERE `count` = `$i`");

// Link location as string
$link = '';

// Emotion value from taken photo
$emotion = '';

// Current date at moment of taken photo
$date = '';

// Query for inserting photo data into db
//$photoQuery = $mysqli->query("INSERT INTO `fotodata` (`link`, `emotion`, `date`)
//VALUES ('$link', '$emotion', $date)");

// Close mysqli connection
$mysqli->close();
