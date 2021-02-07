<?php
#----------------------------------------#
#	Image Model
#----------------------------------------#

// Get specific Image based on id
function getImage($imageId) {
	global $db;
	$sql = 'SELECT i.albumId, i.imageTitle, i.imageCaption, i.imageName, i.imagePrivate, i.imageShareKey, a.userId 
	FROM image i LEFT JOIN album a ON i.albumId = a.albumId
	WHERE imageId = :imageId LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get specific Image based on id
function getImageByShareKey($imageShareKey) {
	global $db;
	$sql = 'SELECT albumId, imageTitle, imageCaption, imageName, imagePrivate FROM image WHERE imageShareKey = :imageShareKey LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':imageShareKey', $imageShareKey, PDO::PARAM_STR);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get All Image
function getAllImages() {
	global $db;
	$sql = 'SELECT imageId, albumId, imageTitle, imageCaption, imageName, imagePrivate, imageShareKey, imageOrder FROM image';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get Images based on album id
function getImagesByAlbum($albumId) {
	global $db;
	$sql = 'SELECT imageId, imageTitle, imageCaption, imageName, imagePrivate FROM image WHERE albumId = :albumId ORDER BY imageOrder,imageTitle';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}
