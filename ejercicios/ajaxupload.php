<?php

$valid_exts = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
$max_size = 200 * 1024; // max file size
$path = './imagenes/'; // upload directory

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if( ! empty($_FILES['image']) ) {
		// get uploaded file extension
		$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		// looking for format and size validity
		if (in_array($ext, $valid_exts) AND $_FILES['image']['size'] < $max_size) {
			$path = $path . uniqid(). '.' .$ext;
			// move uploaded file from temp to uploads directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
				echo "<img src='$path' />";
			}
		} else {
			echo 'Invalid file!';
		}
	} else {
		echo 'File not uploaded!';
	}
} else {
	echo 'Bad request!';
}

?>
