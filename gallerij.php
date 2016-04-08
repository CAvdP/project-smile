<?php
include_once "php/database.php";

$sql = "SELECT * FROM fotodata;";
$photos = [];
$result = mysqli_query($db, $sql);
if (isset($result)) {
	while ($photo = mysqli_fetch_assoc($result)) {
		$photos[] = $photo;
	}
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>Face tracker</title>
	<meta charset="utf-8">
	<link href="css/style-gallery.css" rel="stylesheet">
</head>

<body>

<div id="photoContainer">
	<?php

	foreach ($photos as $photo) {
		echo '<img class="gallery-item" src=' . $photo['link'] . '>';
	}

	?>
</div>
</div>
</body>
</html>