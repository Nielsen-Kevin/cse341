<?php
#----------------------------------------#
#	Album access Model
#----------------------------------------#

// Get Album keys based on album id
function getAlbumKeys($albumId) {
	global $db;
	$sql = 'SELECT accessId, password FROM project01.access WHERE albumId = :albumId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}
