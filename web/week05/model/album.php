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
