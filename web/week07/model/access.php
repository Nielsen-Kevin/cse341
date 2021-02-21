<?php
#----------------------------------------#
#	Album access Model
#----------------------------------------#

// Get Album keys based on album id
function getAlbumKeys($album_id) {
	global $db;
	$sql = 'SELECT access_id, password FROM project01.access WHERE album_id = :album_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':album_id', $album_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get single access
function getAccessById($access_id) {
	global $db;
	$sql = 'SELECT access_id, album_id, password FROM project01.access WHERE access_id = :access_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':access_id', $access_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Add AlbumAccess
function addAlbumAccess($data) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'INSERT INTO project01.access (album_id, password) VALUES (:album_id, :password)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':album_id', $data['album_id'], PDO::PARAM_INT);
	$stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
	// Insert the data
	$stmt->execute();
	// Ask how many rows changed as a result of our insert
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Update AlbumAccess
function updateAlbumAccess($data, $access_id) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE project01.access SET album_id = :album_id, password = :password WHERE access_id = :access_id';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':access_id', $access_id, PDO::PARAM_INT);
	$stmt->bindValue(':album_id', $data['album_id'], PDO::PARAM_INT);
	$stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
	// Update the data
	$stmt->execute();
	// Ask how many rows changed as a result of our update
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Delete AlbumAccess
function deleteAlbumAccess($access_id) {
	global $db;
	$sql = 'DELETE FROM project01.access WHERE access_id = :access_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':access_id', $access_id, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}