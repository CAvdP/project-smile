<?php
include_once "database.php";

$sql = "SELECT * FROM fotodata;";
$photos = [];
$result = mysqli_query($db, $sql);
if (isset($result)) {
	while ($photo = mysqli_fetch_assoc($result)) {
		$photos[] = $photo;
	}
}

print_r($photos);
?>