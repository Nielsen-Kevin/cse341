<?php
#----------------------------------------#
#	Main Controller
#----------------------------------------#
session_start();
// Configuration
require '../config.php';
// Load libraries
include_once 'library/connections.php';
include_once 'library/functions.php';
$db = dbConnect();
// Load models
include_once 'model/album.php';
include_once 'model/access.php';
include_once 'model/image.php';
include_once 'model/user.php';



$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

switch ($action) {
	# TODO: Album - Add Edit Delete
	# TODO: image - Add Edit Delete

	/*--------------------
		Display Image
	--------------------*/

	/*--------------------
		key-in to Album
	--------------------*/
	case 'key-in':
		do {
			if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
				break;
			}
			// Sanitize data coming in
			$albumId = filter_input(INPUT_GET, 'album', FILTER_SANITIZE_NUMBER_INT);
			$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);

			// Run basic checks, return if errors
			if(empty($albumId) || empty($key)){
				$errors = [];
				if (empty($key)) {
					$errors['errorKey'] = '<span class="error">key is required.</span>';
				}
				if (empty($albumId)) {
					$errors['errorAlbumId'] = '<span class="error">album Id is required.</span>';
				}

				extract($errors);
				break;
			}
			// Get key list for this album
			$activeKeys = getAlbumKeys($albumId);

			// Check if user is found
			if(empty($userData)) {
				$message = '<p class="error">No access key for this album.</p>';
				break;
			}

			$passed = false;
			// check each key
			foreach($activeKeys as $access) {
				if(!($key == $access['password'])) {
					$passed = true;
					break;
				}
			}
			if(!$passed) {
				$message = '<p class="error">Your access key is invalid. Please try again.</p>';
				break;
			}

			// Add albumId to the key list
			$_SESSION['keys'][] = $albumId;

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
	break;

	default:
		/*--------------------
			Display image detail
		--------------------*/
		$imageId = filter_input(INPUT_GET, 'image', FILTER_SANITIZE_NUMBER_INT);
		if ($imageId != NULL) {
			$img = getImage($imageId);
			$docTitle = $img['imageTitle'];

			if($img['imagePrivate'] || isAlbumOwner($img['userId']) ){
				// Check if they have permission on current image
				$docTitle = 'Private';
				$isPrivate = 'This image is set to private and can not be viewed';
			}
			
			include 'view/image-detail.php';
			exit;
		}

		// Page title
		$docTitle = "Main Galley";


		/*--------------------
			Display Album
		--------------------*/
		$albumId = filter_input(INPUT_GET, 'album', FILTER_SANITIZE_NUMBER_INT);
		if ($albumId == NULL) {
			$albumId = 1;
		}
		$album = getAlbum($albumId);

#TODO $album['userId'] == $_SESSION['userData']['userId']
		if($album['albumPrivate'] || isAlbumOwner($album['userId']) ){
			// Check if they have permission on current album
			accessPermission($albumId);
		}
		$docTitle = $album['albumTitle'];
		$images = getImagesByAlbum($albumId);
		$subAlbums = getSubAlbums($albumId);
		include 'view/album.php';
}


exit;


	$statement = $db->prepare('SELECT column FROM table');
	$statement->execute();

	// Go through each result
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		echo $row['column'];
	}
