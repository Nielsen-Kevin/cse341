<?php
#----------------------------------------#
#	Image Model
#----------------------------------------#

// Get specific Image based on id
function getImage($imageId) {
	global $db;
	$sql = 'SELECT albumId, imageTitle, imageCaption, imageName, imagePrivate, imageShareKey, imageOrder FROM image WHERE imageId = :imageId LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
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

// Get Image  based on album id
function getImageByAlbum($albumId) {
	global $db;
	$sql = 'SELECT imageId, imageTitle, imageCaption, imageName, imagePrivate, imageShareKey FROM image WHERE albumId = :albumId ORDER BY imageOrder,imageTitle';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Add Image
function addImage($data) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'INSERT INTO image (albumId, imageTitle, imageCaption, imageName, imagePrivate, imageShareKey, imageOrder)
			VALUES (:albumId, :imageTitle, :imageCaption, :imageName, :imagePrivate, :imageShareKey, :imageOrder)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':albumId', $data['albumId'], PDO::PARAM_INT);
	$stmt->bindValue(':imageTitle', $data['imageTitle'], PDO::PARAM_STR);
	$stmt->bindValue(':imageCaption', $data['imageCaption'], PDO::PARAM_STR);
	$stmt->bindValue(':imageName', $data['imageName'], PDO::PARAM_STR);
	$stmt->bindValue(':imagePrivate', $data['imagePrivate'], PDO::PARAM_INT);
	$stmt->bindValue(':imageShareKey', $data['imageShareKey'], PDO::PARAM_STR);
	$stmt->bindValue(':imageOrder', $data['imageOrder'], PDO::PARAM_INT);
	// Insert the data
	$stmt->execute();
	// Ask how many rows changed as a result of our insert
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Update Image
function updateImage($data, $imageId) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE image SET albumId = :albumId, imageTitle = :imageTitle, imageCaption = :imageCaption, imageName = :imageName, imagePrivate = :imagePrivate, imageShareKey = :imageShareKey, imageOrder = :imageOrder WHERE imageId = :imageId';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':imageId', $data['imageId'], PDO::PARAM_INT);
	$stmt->bindValue(':albumId', $data['albumId'], PDO::PARAM_INT);
	$stmt->bindValue(':imageTitle', $data['imageTitle'], PDO::PARAM_STR);
	$stmt->bindValue(':imageCaption', $data['imageCaption'], PDO::PARAM_STR);
	$stmt->bindValue(':imageName', $data['imageName'], PDO::PARAM_STR);
	$stmt->bindValue(':imagePrivate', $data['imagePrivate'], PDO::PARAM_INT);
	$stmt->bindValue(':imageShareKey', $data['imageShareKey'], PDO::PARAM_STR);
	$stmt->bindValue(':imageOrder', $data['imageOrder'], PDO::PARAM_INT);
	// Update the data
	$stmt->execute();
	// Ask how many rows changed as a result of our update
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Delete Image
function deleteImage($imageId) {
	global $db;
	$sql = 'DELETE FROM image WHERE imageId = :imageId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}
