<?php
#----------------------------------------#
#	Add access
#----------------------------------------#
$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);

do {
	if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
		break;
	}
	// Sanitize data coming in
	$album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

	// Run basic checks, return if errors
	$errors = [];
	if (empty($album_id)) {
		$errors['error_album_id'] = 'album is required.';
	}
	if (empty($password)) {
		$errors['error_password'] = 'password is required.';
	}

	if(!empty($errors)) {
		$message = '<p class="error">Please provide information for all invalid and empty fields.</p>';
		extract($errors);
		break;
	}

	// Package data for insert
	$data = [
		'album_id' => $album_id,
		'password' => $password,
	];

	// Insert the document information to the database, get the result
	$result = addAlbumAccess($data);

	// Set a message based on the insert result
	if (!empty($result)) {
		$_SESSION['message'] = "<p class='success'>Access password was successfully added.</p>";
		header('location: ?action=access-list&album_id=' . $album_id);
	} else {
		$message = '<p class="error">Sorry, the access failed.</p>';
	}
	
} while (false);

$docTitle = "Add Access";
$submitTo = 'add-access';
include 'view/access-form.php';