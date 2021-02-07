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

			// Check if user is found
			if(empty($userData)) {
				$message = '<p class="error">No access key for this album.</p>';
				break;
			}

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
	break;

	default:
		/*--------------------
			Display image detail
		--------------------*/
		$image_id = filter_input(INPUT_GET, 'image', FILTER_SANITIZE_NUMBER_INT);
		if ($image_id != NULL) {
			$img = getImage($image_id);
			$docTitle = $img['image_title'];

			if($img['image_private'] || isAlbumOwner($img['user_id']) ){
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
		$album_id = filter_input(INPUT_GET, 'album', FILTER_SANITIZE_NUMBER_INT);
		if ($album_id == NULL) {
			$album_id = 1;
		}
		$album = getAlbum($album_id);

#TODO $album['user_id'] == $_SESSION['userData']['user_id']
		if($album['album_private'] || isAlbumOwner($album['user_id']) ){
			// Check if they have permission on current album
			accessPermission($album_id);
		}
		$docTitle = $album['album_title'];
		$images = getImagesByAlbum($album_id);
		$subAlbums = getSubAlbums($album_id);
		include 'view/album.php';
}


exit;


	$statement = $db->prepare('SELECT column FROM table');
	$statement->execute();

	// Go through each result
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		echo $row['column'];
	}
