<?php
#----------------------------------------#
#	Image edit
#----------------------------------------#

$image = getImage($image_id);
extract($image);

do {
	if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
		break;
	}
	// Sanitize data coming in
	$image_id = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
	$album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
	$image_title = filter_input(INPUT_POST, 'image_title', FILTER_SANITIZE_STRING);
	$image_caption = filter_input(INPUT_POST, 'image_caption', FILTER_SANITIZE_STRING);
	
	$image_name = filter_input(INPUT_POST, 'image_name', FILTER_SANITIZE_STRING);
	
	$image_private = filter_input(INPUT_POST, 'image_private', FILTER_SANITIZE_NUMBER_INT);
	$image_share_key = filter_input(INPUT_POST, 'image_share_key', FILTER_SANITIZE_STRING);
	$image_order = filter_input(INPUT_POST, 'image_order', FILTER_SANITIZE_NUMBER_INT);

	// Run basic checks, return if errors
	$errors = [];
	if (empty($album_id)) {
		$errors['error_album_id'] = 'album is required.';
	}
	if (empty($image_title)) {
		$errors['error_image_title'] = 'title is required.';
	}

	if(!empty($_FILES['File']['name'])) {
		include_once($_SERVER['DOCUMENT_ROOT'] . '/library/upload.php');

		$upload = new Upload('File', $_SERVER['DOCUMENT_ROOT'] . '/week07/images');

		// Upload the file and set filename
		$filename = $upload->image();
		if ($upload->error) {
			$message = $upload->error;
			break;
		}
	}

	if(!empty($errors)) {
		$message = '<p class="error">Please provide information for all invalid and empty fields.</p>';
		extract($errors);
		break;
	}

	// Package data for insert
	$data = [
		'image_id' => $image_id,
		'album_id' => $album_id,
		'image_title' => $image_title,
		'image_caption' => $image_caption,
		'image_name' => (isset($filename) ? $filename : $image_name),
		'image_private' => ($image_private == 1) ? true : false,
		'image_share_key' => $image_share_key,
		'image_order' => (int)$image_order,
	];

	// Insert the document information to the database, get the result
	$result = updateImage($data, $image_id);

	// Set a message based on the insert result
	if (!empty($result)) {
		$_SESSION['message'] = "<p class='success'>Image: $image_title was successfully updated.</p>";
		header('location: ?action=album-images&album_id=' . $album_id);
	} else {
		$message = '<p class="error">Sorry, the image failed.</p>';
	}
	
} while (false);

$albumList = getAlbumList();
$docTitle = "Edit Image";
$submitTo = 'edit-image';
include 'view/image-form.php';