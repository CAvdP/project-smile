<?php

//require_once('includes/dbConnect.php');
require_once('includes/settings.php');
require_once("includes/classes/Flickr.php");


// Init flickr connection
$flickr = new Flickr(FLICKR_KEY, FLICKR_SECRET);

// Fetch and encode returned data
$data = $flickr->getPhotos();
echo json_encode($data);

//
////Foreach() loop for building image url
//
//foreach ($data['photoset']['photo'] as $img) {
//    $images[] = 'https://farm' . $img['farm'] . '.staticflickr.com/' . $img['server'] . '/' . $img['id'] . '_' . $img['secret'] . '.jpg';
//}
//print_r($images);


