<?php
// If get Post
if ($_POST) {
	$path = $_SERVER['DOCUMENT_ROOT'];
	include_once $path . '/wordnote/wp-config.php';
	include_once $path . '/wordnote/wp-load.php';
	include_once $path . '/wordnote/wp-includes/wp-db.php';
	include_once $path . '/wordnote/wp-includes/pluggable.php';
	
	$text = $_POST['note'];
	add_option("wordnote", $text);
	echo "test";

	die();
}
?>