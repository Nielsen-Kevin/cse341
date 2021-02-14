<?php
#----------------------------------------#
#	Album Model
#----------------------------------------#

// Get specific Album based on id
function getAlbum($album_id) {
	global $db;
	$sql = 'SELECT user_id, album_parent, album_title, album_description, album_private, album_share_key, album_order FROM project01.album WHERE album_id = :album_id LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':album_id', $album_id, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get Sub Albums
function getSubAlbums($album_parent) {
	global $db;
	$sql = 'SELECT album_id, user_id, album_title, album_private FROM project01.album WHERE album_parent = :album_parent ORDER BY album_order,album_title';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':album_parent', $album_parent, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get Album  based on User id
function getAlbumByUser($user_id) {
	global $db;
	$sql = 'SELECT album_id, user_id, album_parent, album_title, album_description, album_private, album_share_key, album_order FROM project01.album WHERE user_id = :user_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get All Albums
function getAllAlbums() {
	global $db;
	$sql = 'SELECT album_id, user_id, album_parent, album_title, album_description, album_private, album_share_key, album_order FROM project01.album';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get Albums List
function getAlbumList() {
	global $db;
	$sql = 'SELECT album_id, album_title FROM project01.album';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Add Album
function addAlbum($data) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'INSERT INTO album (user_id, album_parent, album_title, album_description, album_private, album_share_key, album_order)
			VALUES (:user_id, :album_parent, :album_title, :album_description, :album_private, :album_share_key, :album_order)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
	$stmt->bindValue(':album_parent', $data['album_parent'], PDO::PARAM_INT);
	$stmt->bindValue(':album_title', $data['album_title'], PDO::PARAM_STR);
	$stmt->bindValue(':album_description', $data['album_description'], PDO::PARAM_STR);
	$stmt->bindValue(':album_private', $data['album_private'], PDO::PARAM_INT);
	$stmt->bindValue(':album_share_key', $data['album_share_key'], PDO::PARAM_STR);
	$stmt->bindValue(':album_order', $data['album_order'], PDO::PARAM_INT);
	// Insert the data
	$stmt->execute();
	// Ask how many rows changed as a result of our insert
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Update Album
function updateAlbum($data, $album_id) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE album SET album_id = :album_id, user_id = :user_id, album_parent = :album_parent, album_title = :album_title, album_description = :album_description, album_private = :album_private, album_share_key = :album_share_key, album_order = :album_order WHERE album_id = :album_id';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':album_id', $album_id, PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
	$stmt->bindValue(':album_parent', $data['album_parent'], PDO::PARAM_INT);
	$stmt->bindValue(':album_title', $data['album_title'], PDO::PARAM_STR);
	$stmt->bindValue(':album_description', $data['album_description'], PDO::PARAM_STR);
	$stmt->bindValue(':album_private', $data['album_private'], PDO::PARAM_INT);
	$stmt->bindValue(':album_share_key', $data['album_share_key'], PDO::PARAM_STR);
	$stmt->bindValue(':album_order', $data['album_order'], PDO::PARAM_INT);
	// Update the data
	$stmt->execute();
	// Ask how many rows changed as a result of our update
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Delete Album
function deleteAlbum($album_id) {
	// Use user_id to lock access to user only album - base on user level
	if($_SESSION['userData']['user_level'] == 3) {
		return deleteAlbumByAdmin($album_id);
	} else {
		return deleteAlbumByUser($album_id, $_SESSION['userData']['user_id']);
	}
}
// Delete a specific Album
function deleteAlbumByUser($album_id, $user_id) {
	global $db;
	// Add to prepare statment to include user_id
	$sql = 'DELETE FROM project01.album WHERE album_id = :album_id AND user_id = :user_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':album_id', $album_id, PDO::PARAM_INT);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}
// Delete Album No Limit
function deleteAlbumByAdmin($album_id) {
	global $db;
	$sql = 'DELETE FROM project01.album WHERE album_id = :album_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':album_id', $album_id, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}