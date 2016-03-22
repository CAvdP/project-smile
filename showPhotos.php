<?php

require_once('includes/dbConnect.php');
require_once('includes/settings.php');
require_once("includes/classes/Flickr.php");

// Init flickr connection
$flickr = new Flickr(FLICKR_KEY, FLICKR_SECRET);

// Fetch and encode returned data
$data = $flickr->getPhotos();
echo json_encode($data);
