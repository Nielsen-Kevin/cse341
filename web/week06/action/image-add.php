<?php
#----------------------------------------#
#	Add Image
#----------------------------------------#
$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);

do {
	if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
		break;
	}
	// Sanitize data coming in
	$album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
	$image_title = filter_input(INPUT_POST, 'image_title', FILTER_SANITIZE_STRING);
	$image_caption = filter_input(INPUT_POST, 'image_caption', FILTER_SANITIZE_STRING);
	$image_name = filter_input(INPUT_POST, 'image_name', FILTER_SANITIZE_STRING);
	$image_private = filter_input(INPUT_POST, 'image_private', FILTER_SANITIZE_NUMBER_INT);
	$image_order = filter_input(INPUT_POST, 'image_order', FILTER_SANITIZE_NUMBER_INT);

	// Run basic checks, return if errors
	$errors = [];
	if (empty($album_id)) {
		$errors['error_album_id'] = 'album is required.';
	}
	if (empty($image_title)) {
		$errors['error_image_title'] = 'title is required.';
	}

	if(!empty($errors)) {
		$message = '<p class="error">Please provide information for all invalid and empty fields.</p>';
		extract($errors);
		exit;
	}

	// Package data for insert
	$data = [
		'album_id' => $album_id,
		'image_title' => $image_title,
		'image_caption' => $image_caption,
		'image_name' => $image_name,
		'image_private' => ($image_private == 1) ? true : false,
		'image_share_key' => create_guid(),
		'image_order' => $image_order,
	];

	// Insert the document information to the database, get the result
	$result = addImage($data);

	// Set a message based on the insert result
	if (!empty($result)) {
		$_SESSION['message'] = "<p class='success'>Image: $image_title was successfully added.</p>";
		header('location: ?action=album-images&album_id=' . $album_id);
	} else {
		$message = '<p class="error">Sorry, the image failed.</p>';
	}
	
} while (false);

$albumList = getAlbumList();
$docTitle = "Add Image";
$submitTo = 'add-image';
include 'view/image-form.php';