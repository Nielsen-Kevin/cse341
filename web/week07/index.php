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

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

// Action that required login
switch ($action) {
	case 'album-list':
	case 'add-album':
	case 'edit-album':
	case 'delete-album':
	case 'album-images':
	case 'add-image':
	case 'edit-image':
	case 'delete-image':
	case 'access-list':
	case 'add-access':
	case 'edit-access':
	case 'delete-access':
		// Login required area
		loginRequired();
	break;
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

	/*--------------------
	Image
	--------------------*/
	// Image list by Album
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
	Album Access
	--------------------*/
	case 'access-list':
		$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);
		
		$album = getAlbum($album_id);
		$list = getAlbumKeys($album_id);

		$message = sessionMessage();
		$docTitle = "Album Access";
		include 'view/access-list.php';
	break;

	// Add Access
	case 'add-access':
		include 'action/access-add.php';
	break;

	// Edit Access
	case 'edit-access':
		$access_id = filter_input(INPUT_GET, 'access_id', FILTER_SANITIZE_NUMBER_INT);
		if ($access_id == NULL) {
			echo '404';
			break;
		}
		include 'action/access-edit.php';
	break;

	// Access Delete and confirmation
	case 'delete-access':
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			$access_id = filter_input(INPUT_POST, 'access_id', FILTER_SANITIZE_NUMBER_INT);
			$album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
			// do the delete
			$deleteResult = deleteAlbumAccess($access_id);
			if ($deleteResult) {
				$_SESSION['message'] = "<p class='success'>Album Acces was successfully deleted.</p>";
			} else {
				$_SESSION['message'] = "<p class='error'>Error: Album Acces was not deleted.</p>";
			}
			header('location: ?action=access-list&album_id=' . $album_id);
			exit;
		}
		// delete confirmation
		$access_id = filter_input(INPUT_GET, 'access_id', FILTER_SANITIZE_NUMBER_INT);
		$album_id = filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT);
		$access = getAccessById($access_id);
		extract($access);
		$docTitle = "Delete Album Access";
		include 'view/access-confirm.php';
	break;

	/*--------------------
	key-in to Album
	--------------------*/
	case 'key-in':
		include 'action/key-in.php';
	break;

	/*-------------------------
	Display Image Detail
	--------------------------*/
	case 'image':
		$image_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
		if ($image_id != NULL) {
			$img = getImage($image_id);
			$docTitle = $img['image_title'];

			if($img['image_private'] && !isAlbumOwner($img['user_id']) ){
				// Check if they have permission on current image
				$docTitle = 'Private';
				$isPrivate = 'This image is set to private and can not be viewed';
			}
			
			include 'view/image-detail.php';
			exit;
		}
	break;

	/*--------------------
	Display Album
	--------------------*/
	case 'album':
		$album_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
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
		if(!isAlbumOwner($album_id) ){
			$images = getImagesByAlbum($album_id, 1);
		} else {
			$images = getImagesByAlbum($album_id);
		}
		$subAlbums = getSubAlbums($album_id);
		include 'view/album.php';
	break;

	/*--------------------
	Display Album
	--------------------*/
	case 'share':
		// Share Key
		$key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
		if ($key != NULL) {
			$album = getAlbumByShareKey($key);

			// Only if pass is required
			if($album['pass_needed']) {
				// Add album_id to the key list
				$_SESSION['keys'][] = $album['album_id'];
			}
			
			header('location: ?action=album&id=' . $album['album_id']);
			exit;
		}
	break;

	/*--------------------
	Display Main Album
	--------------------*/	
	default:
		// Page title
		$docTitle = "Main Galley";
		$album_id = 1;
		$album = getAlbum($album_id);

		// Check if private or if login and is not album owner
		if($album['album_private'] && !isAlbumOwner($album['user_id']) ){
			// Check if they have permission on current album
			accessPermission($album_id);
		}
		if(!isAlbumOwner($album_id) ){
			$images = getImagesByAlbum($album_id, 1);
		} else {
			$images = getImagesByAlbum($album_id);
		}
		$subAlbums = getSubAlbums($album_id);
		include 'view/album.php';
}
