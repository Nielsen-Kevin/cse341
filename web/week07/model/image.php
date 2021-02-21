<?php
#----------------------------------------#
#	Image Model
#----------------------------------------#

// Get specific Image based on id
function getImage($image_id) {
	global $db;
	$sql = 'SELECT i.album_id, i.image_title, i.image_caption, i.image_name, i.image_private, i.image_share_key, a.user_id 
	FROM project01.image i LEFT JOIN project01.album a ON i.album_id = a.album_id 
	WHERE i.image_id = :image_id LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get specific Image based on id
function getImageByShareKey($image_share_key) {
	global $db;
	$sql = 'SELECT album_id, image_title, image_caption, image_name, image_private FROM project01.image WHERE image_share_key = :image_share_key LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':image_share_key', $image_share_key, PDO::PARAM_STR);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get All Image
function getAllImages() {
	global $db;
	$sql = 'SELECT image_id, album_id, image_title, image_caption, image_name, image_private, image_share_key, image_order FROM project01.image';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get Images based on album id
function getImagesByAlbum($album_id) {
	global $db;
	$sql = 'SELECT image_id, image_title, image_caption, image_name, image_private FROM project01.image WHERE album_id = :album_id ORDER BY image_order,image_title';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':album_id', $album_id, PDO::PARAM_INT);
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
	$sql = 'INSERT INTO project01.image (album_id, image_title, image_caption, image_name, image_private, image_share_key, image_order)
			VALUES (:album_id, :image_title, :image_caption, :image_name, :image_private, :image_share_key, :image_order)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':album_id', $data['album_id'], PDO::PARAM_INT);
	$stmt->bindValue(':image_title', $data['image_title'], PDO::PARAM_STR);
	$stmt->bindValue(':image_caption', $data['image_caption'], PDO::PARAM_STR);
	$stmt->bindValue(':image_name', $data['image_name'], PDO::PARAM_STR);
	$stmt->bindValue(':image_private', $data['image_private'], PDO::PARAM_INT);
	$stmt->bindValue(':image_share_key', $data['image_share_key'], PDO::PARAM_STR);
	$stmt->bindValue(':image_order', $data['image_order'], PDO::PARAM_INT);
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
function updateImage($data, $image_id) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE project01.image SET album_id = :album_id, image_title = :image_title, image_caption = :image_caption, image_name = :image_name, image_private = :image_private, image_share_key = :image_share_key, image_order = :image_order WHERE image_id = :image_id';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':image_id', $data['image_id'], PDO::PARAM_INT);
	$stmt->bindValue(':album_id', $data['album_id'], PDO::PARAM_INT);
	$stmt->bindValue(':image_title', $data['image_title'], PDO::PARAM_STR);
	$stmt->bindValue(':image_caption', $data['image_caption'], PDO::PARAM_STR);
	$stmt->bindValue(':image_name', $data['image_name'], PDO::PARAM_STR);
	$stmt->bindValue(':image_private', $data['image_private'], PDO::PARAM_INT);
	$stmt->bindValue(':image_share_key', $data['image_share_key'], PDO::PARAM_STR);
	$stmt->bindValue(':image_order', $data['image_order'], PDO::PARAM_INT);
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
function deleteImage($image_id) {
	global $db;
	$sql = 'DELETE FROM project01.image WHERE image_id = :image_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}
