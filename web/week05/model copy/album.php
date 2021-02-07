<?php
#----------------------------------------#
#	Album Model
#----------------------------------------#

/*
SELECT p.packageName, p.packageImg, p.packagePrice, m.service 
FROM hmphoto.packages p 
LEFT JOIN hmphoto.media m ON p.mediaID = m.mediaID', PDO::FETCH_ASSOC);
*/


// Get specific Album based on id
function getAlbum($albumId) {
	global $db;
	$sql = 'SELECT userId, albumParent, albumTitle, albumDescription, albumPrivate, albumShareKey, albumOrder FROM album WHERE albumId = :albumId LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get Sub Albums
function getSubAlbums($albumParent) {
	global $db;
	$sql = 'SELECT albumId, userId, albumTitle, albumPrivate FROM album WHERE albumParent = :albumParent ORDER BY albumOrder,albumTitle';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumParent', $albumParent, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get Album  based on User id
function getAlbumByUser($userId) {
	global $db;
	$sql = 'SELECT albumId, userId, albumParent, albumTitle, albumDescription, albumPrivate, albumShareKey, albumOrder FROM album WHERE userId = :userId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get All Albums
function getAllAlbums() {
	global $db;
	$sql = 'SELECT albumId, userId, albumParent, albumTitle, albumDescription, albumPrivate, albumShareKey, albumOrder FROM album';
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
	$sql = 'INSERT INTO album (albumId, userId, albumParent, albumTitle, albumDescription, albumPrivate, albumShareKey, albumOrder)
			VALUES (:albumId, :userId, :albumParent, :albumTitle, :albumDescription, :albumPrivate, :albumShareKey, :albumOrder)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':albumId', $data['albumId'], PDO::PARAM_INT);
	$stmt->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
	$stmt->bindValue(':albumParent', $data['albumParent'], PDO::PARAM_INT);
	$stmt->bindValue(':albumTitle', $data['albumTitle'], PDO::PARAM_STR);
	$stmt->bindValue(':albumDescription', $data['albumDescription'], PDO::PARAM_STR);
	$stmt->bindValue(':albumPrivate', $data['albumPrivate'], PDO::PARAM_INT);
	$stmt->bindValue(':albumShareKey', $data['albumShareKey'], PDO::PARAM_STR);
	$stmt->bindValue(':albumOrder', $data['albumOrder'], PDO::PARAM_INT);
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
function updateAlbum($data, $albumId) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE album SET albumId = :albumId, userId = :userId, albumParent = :albumParent, albumTitle = :albumTitle, albumDescription = :albumDescription, albumPrivate = :albumPrivate, albumShareKey = :albumShareKey, albumOrder = :albumOrder WHERE albumId = :albumId';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':albumId', $data['albumId'], PDO::PARAM_INT);
	$stmt->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
	$stmt->bindValue(':albumParent', $data['albumParent'], PDO::PARAM_INT);
	$stmt->bindValue(':albumTitle', $data['albumTitle'], PDO::PARAM_STR);
	$stmt->bindValue(':albumDescription', $data['albumDescription'], PDO::PARAM_STR);
	$stmt->bindValue(':albumPrivate', $data['albumPrivate'], PDO::PARAM_INT);
	$stmt->bindValue(':albumShareKey', $data['albumShareKey'], PDO::PARAM_STR);
	$stmt->bindValue(':albumOrder', $data['albumOrder'], PDO::PARAM_INT);
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
function deleteAlbum($albumId) {
	// Use userId to lock access to user only album - base on user level
	if($_SESSION['userData']['userLevel'] == 3) {
		return deleteAlbumByAdmin($albumId);
	} else {
		return deleteAlbumByUser($albumId, $_SESSION['userData']['userId']);
	}
}
// Delete a specific Album
function deleteAlbumByUser($albumId, $userId) {
	global $db;
	// Add to prepare statment to include userId
	$sql = 'DELETE FROM album WHERE albumId = :albumId AND userId = :userId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}
// Delete Album No Limit
function deleteAlbumByAdmin($albumId) {
	global $db;
	$sql = 'DELETE FROM album WHERE albumId = :albumId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}