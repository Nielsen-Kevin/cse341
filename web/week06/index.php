<?php
#----------------------------------------#
#	Main Controller
#----------------------------------------#
session_start();
// Configuration
require '../config.php';
// Load libraries
include_once '../library/connections.php';
include_once '../library/functions.php';
$db = dbConnect();
// Load models
include_once 'model/album.php';
include_once 'model/access.php';
include_once 'model/image.php';
include_once 'model/user.php';

// Login required area
loginRequired();

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

switch ($action) {
	/*--------------------
	Album
	--------------------*/
	// Album List
	case 'album-list':
		$albumsList = getAllAlbums();
		$docTitle = "Album List";
		$message = sessionMessage();
		include 'view/album-list.php';
	break;

	// Add Album
	case 'add-album':
		include 'action/album-add.php';
	break;

	// Edit Album
	case 'edit-album':
		$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);
		if ($album_id == NULL) {
			echo '404';
			break;
		}
		include 'action/album-edit.php';
	break;

	// Album Delete and confirmation
	case 'delete-album':
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
			// do the delete
			$deleteResult = deleteAlbum($album_id);
			if ($deleteResult) {
				$_SESSION['message'] = "<p class='success'>Album was successfully deleted.</p>";
			} else {
				$_SESSION['message'] = "<p class='error'>Error: album was not deleted.</p>";
			}
			header('location: ?action=album-list');
			exit;
		}
		// delete confirmation
		$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);
		$album = getAlbum($album_id);
		extract($album);
		$docTitle = "Delete Album";
		include 'view/album-confirm.php';
	break;

	//	Album images
	case 'album-images':
		$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);
		
		$albumList = getAlbumList();
		$subAlbums = getSubAlbums($album_id);
		$album = getAlbum($album_id);
		$images = getImagesByAlbum($album_id);

		$message = sessionMessage();
		$docTitle = "Album Contents";
		include 'view/album-contents.php';
	break;

	/*--------------------
	Image
	--------------------*/
	// Add Image
	case 'add-image':
		include 'action/image-add.php';
	break;

	// Edit Image
	case 'edit-image':
		$image_id = filter_input(INPUT_GET, 'image_id', FILTER_SANITIZE_NUMBER_INT);
		if ($image_id == NULL) {
			echo '404';
			break;
		}
		include 'action/image-edit.php';
	break;

	// Image Delete and confirmation
	case 'delete-image':
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$image_id = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
			$album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
			// do the delete
			$deleteResult = deleteImage($image_id);
			if ($deleteResult) {
				$_SESSION['message'] = "<p class='success'>Image was successfully deleted.</p>";
			} else {
				$_SESSION['message'] = "<p class='error'>Error: image was not deleted.</p>";
			}

			
			header('location: ?action=album-images&album_id=' . $album_id);
			exit;
		}
		// delete confirmation
		$image_id = filter_input(INPUT_GET, 'image_id', FILTER_SANITIZE_NUMBER_INT);
		$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);
		$image = getImage($image_id);
		extract($image);
		$docTitle = "Delete Image";
		include 'view/image-confirm.php';
	break;



	/*--------------------
	key-in to Album
	--------------------*/
	case 'key-in':
		include 'action/key-in.php';
	break;

	default:
		/*-------------------------
		Display Image Detail
		--------------------------*/
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

		// Check if private or if login and is not album owner
		if($album['album_private'] && !isAlbumOwner($album['user_id']) ){
			// Check if they have permission on current album
			accessPermission($album_id);
		}
		$docTitle = $album['album_title'];
		$images = getImagesByAlbum($album_id);
		$subAlbums = getSubAlbums($album_id);
		include 'view/album.php';
}
