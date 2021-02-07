<?php
#----------------------------------------#
#	Image Model
#----------------------------------------#

// Get specific Image based on id
function getImage($image_id) {
	global $db;
	$sql = 'SELECT i.album_id, i.image_title, i.image_caption, i.image_name, i.image_private, i.image_share_key, a.user_id 
	FROM project01.image i LEFT JOIN album a ON i.album_id = a.album_id
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
