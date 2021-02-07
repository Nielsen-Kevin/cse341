<?php
#----------------------------------------#
#	Album Model
#----------------------------------------#

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
