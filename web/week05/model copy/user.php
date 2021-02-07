<?php
/* CREATE TABLE user (
userId int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
userName varchar(60) NOT NULL,
userEmail varchar(60) NOT NULL,
userPassword varchar(255) NOT NULL,
userLevel enum('1','2','3') NOT NULL DEFAULT '1',
UNIQUE KEY uk_userEmail (userEmail)
);
 */

#----------------------------------------#
#	User Model
#----------------------------------------#

// Get specific User based on id
function getUser($userId) {
	global $db;
	$sql = 'SELECT userId, userName, userEmail, userPassword, userLevel FROM user WHERE userId = :userId LIMIT 1';
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
	$sql = 'SELECT userId, userName, userEmail, userPassword, userLevel FROM user';
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
	$sql = 'SELECT userId, userName, userEmail, userPassword, userLevel FROM user WHERE userId = :userId';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Add User
function addUser($data) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'INSERT INTO user (userId, userName, userEmail, userPassword, userLevel)
			VALUES (:userId, :userName, :userEmail, :userPassword, :userLevel)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
	$stmt->bindValue(':userName', $data['userName'], PDO::PARAM_STR);
	$stmt->bindValue(':userEmail', $data['userEmail'], PDO::PARAM_STR);
	$stmt->bindValue(':userPassword', $data['userPassword'], PDO::PARAM_STR);
	$stmt->bindValue(':userLevel', $data['userLevel'], PDO::PARAM_INT);
	// Insert the data
	$stmt->execute();
	// Ask how many rows changed as a result of our insert
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Update User
function updateUser($data, $userId) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE user SET userId = :userId, userName = :userName, userEmail = :userEmail, userPassword = :userPassword, userLevel = :userLevel WHERE userId = :userId';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
	$stmt->bindValue(':userName', $data['userName'], PDO::PARAM_STR);
	$stmt->bindValue(':userEmail', $data['userEmail'], PDO::PARAM_STR);
	$stmt->bindValue(':userPassword', $data['userPassword'], PDO::PARAM_STR);
	$stmt->bindValue(':userLevel', $data['userLevel'], PDO::PARAM_INT);
	// Update the data
	$stmt->execute();
	// Ask how many rows changed as a result of our update
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Delete User
function deleteUser($userId) {
	global $db;
	$sql = 'DELETE FROM user WHERE userId = :userId LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}
