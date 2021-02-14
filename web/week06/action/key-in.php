<?php
do {
	if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
		break;
	}
	// Sanitize data coming in
	$album_id = filter_input(INPUT_GET, 'album', FILTER_SANITIZE_NUMBER_INT);
	$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);

	// Run basic checks, return if errors
	if(empty($album_id) || empty($key)){
		$errors = [];
		if (empty($key)) {
			$errors['errorKey'] = '<span class="error">key is required.</span>';
		}
		if (empty($album_id)) {
			$errors['errorAlbumId'] = '<span class="error">album Id is required.</span>';
		}

		extract($errors);
		break;
	}
	// Get key list for this album
	$activeKeys = getAlbumKeys($album_id);

	$passed = false;
	// check each key
	foreach($activeKeys as $access) {
		if($key == $access['password']) {
			$passed = true;
			break;
		}
	}
	if(!$passed) {
		$message = '<p class="error">Your access key is invalid. Please try again.</p>';
		break;
	}

	// Add album_id to the key list
	$_SESSION['keys'][] = $album_id;

	if(isset($_SESSION['returnUrl'])) {
		$returnUrl = $_SESSION['returnUrl'];
		unset($_SESSION['returnUrl']);
		// Redirect them
		header('Location: ' . $returnUrl);
		exit;
	}
} while (false);

$docTitle = "Key Into Album";
include 'view/key-form.php';