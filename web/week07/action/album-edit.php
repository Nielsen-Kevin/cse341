<?php
#----------------------------------------#
#	Album edit
#----------------------------------------#

$albums = getAlbum($album_id);
extract($albums);

do {
	if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
		break;
	}
	// Sanitize data coming in
	$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
	$album_parent = filter_input(INPUT_POST, 'album_parent', FILTER_SANITIZE_NUMBER_INT);
	$album_title = filter_input(INPUT_POST, 'album_title', FILTER_SANITIZE_STRING);
	$album_description = filter_input(INPUT_POST, 'album_description', FILTER_SANITIZE_STRING);
	$album_private = filter_input(INPUT_POST, 'album_private', FILTER_SANITIZE_NUMBER_INT);
	$album_share_key = filter_input(INPUT_POST, 'album_share_key', FILTER_SANITIZE_STRING);
	$album_order = filter_input(INPUT_POST, 'album_order', FILTER_SANITIZE_NUMBER_INT);

	// Run basic checks, return if errors
	$errors = [];
	if (empty($album_title)) {
		$errors['error_album_title'] = 'title is required.';
	}

	if(!empty($errors)) {
		$message = '<p class="error">Please provide information for all invalid and empty fields.</p>';
		extract($errors);
		break;
	}

	// Package data for insert
	$data = [
		'user_id' => $user_id, //$_SESSION['userData']['user_id'],
		'album_parent' => $album_parent,
		'album_title' => $album_title,
		'album_description' => $album_description,
		'album_private' => ($album_private == 1) ? true : false,
		'album_share_key' => $album_share_key,
		'album_order' => (int)$album_order,
	];

	// Insert the document information to the database, get the result
	$result = updateAlbum($data, $album_id);

	// Set a message based on the insert result
	if (!empty($result)) {
		$_SESSION['message'] = "<p class='success'>Album: $album_title was successfully updated.</p>";
		//header('location: '.HTTP_ROOT.'week07/');
		header('location: ?action=album-list');
	} else {
		$message = '<p class="error">Sorry, the album failed.</p>';
	}
	
} while (false);

$albumsList = getAlbumList();
$docTitle = "Edit Album";
$submitTo = 'edit-album';
include 'view/album-form.php';