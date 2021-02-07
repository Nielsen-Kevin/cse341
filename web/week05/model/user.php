<?php
#----------------------------------------#
#	User Model
#----------------------------------------#

// Get specific User based on id
function getUser($userId) {
	global $db;
	$sql = 'SELECT userId, userName, userEmail, userPassword, userLevel FROM project01.user WHERE userId = :userId LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get All User
function getAllUser() {
	global $db;
	$sql = 'SELECT userId, userName, userEmail, userPassword, userLevel FROM project01.user';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get User  based on User id
function getUserByUser($userId) {
	global $db;
	$sql = 'SELECT userId, userName, userEmail, userPassword, userLevel FROM project01.user WHERE userId = :userId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}
