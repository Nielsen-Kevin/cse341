<?php
#----------------------------------------#
#	User Model
#----------------------------------------#

// Get specific User based on id
function getUser($user_id) {
	global $db;
	$sql = 'SELECT user_id, user_name, user_email, user_password, user_level FROM project01.user WHERE user_id = :user_id LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get All User
function getAllUser() {
	global $db;
	$sql = 'SELECT user_id, user_name, user_email, user_password, user_level FROM project01.user';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get User  based on User id
function getUserByUser($user_id) {
	global $db;
	$sql = 'SELECT user_id, user_name, user_email, user_password, user_level FROM project01.user WHERE user_id = :user_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}
