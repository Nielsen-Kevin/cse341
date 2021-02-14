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
