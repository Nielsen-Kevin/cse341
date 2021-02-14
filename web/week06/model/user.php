<?php
#----------------------------------------#
#	User Model
#----------------------------------------#

// Get specific User based on id
function getUserByEmail($user_email) {
	global $db;
	$sql = 'SELECT user_id, user_name, user_email, user_level, user_password FROM project01.user WHERE user_email = :user_email LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_email', $user_email, PDO::PARAM_STR);
	$stmt->execute();
	// fetch returns single record
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $row;
}

// Get All User
function getAllUser() {
	global $db;
	$sql = 'SELECT user_id, user_name, user_email, user_level FROM project01.user';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get User based on User id
function getUserById($user_id) {
	global $db;
	$sql = 'SELECT user_id, user_name, user_email, user_level FROM project01.user WHERE user_id = :user_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $rows;
}

// Get client hash based on client id
function getClientHash($user_id){
	$db = phpmotorsConnect();
	$sql = 'SELECT user_password FROM project01.user WHERE user_id = :user_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	// fetch returns single record
	$clientData = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $clientData;
}

// Add User
function addUser($data) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'INSERT INTO project01.user (user_id, user_name, user_email, user_password, user_level)
			VALUES (:user_id, :user_name, :user_email, :user_password, :user_level)';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
	$stmt->bindValue(':user_name', $data['user_name'], PDO::PARAM_STR);
	$stmt->bindValue(':user_email', $data['user_email'], PDO::PARAM_STR);
	$stmt->bindValue(':user_password', $data['user_password'], PDO::PARAM_STR);
	$stmt->bindValue(':user_level', $data['user_level'], PDO::PARAM_INT);
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
function updateUser($data, $user_id) {
	// Create a connection object from connection function
	global $db;
	// The SQL statement
	$sql = 'UPDATE project01.user SET user_id = :user_id, user_name = :user_name, user_email = :user_email, user_password = :user_password, user_level = :user_level WHERE user_id = :user_id';
	// Create the prepared statement using the database connection
	$stmt = $db->prepare($sql);
	// Bind values to SQL statement
	$stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
	$stmt->bindValue(':user_name', $data['user_name'], PDO::PARAM_STR);
	$stmt->bindValue(':user_email', $data['user_email'], PDO::PARAM_STR);
	$stmt->bindValue(':user_password', $data['user_password'], PDO::PARAM_STR);
	$stmt->bindValue(':user_level', $data['user_level'], PDO::PARAM_INT);
	// Update the data
	$stmt->execute();
	// Ask how many rows changed as a result of our update
	$rowsChanged = $stmt->rowCount();
	// Close the database interaction
	$stmt->closeCursor();
	// Return the indication of success (rows changed)
	return $rowsChanged;
}

// Update password
function updatePassword($user_password, $user_id) {
	$db = phpmotorsConnect();
	$sql = 'UPDATE project01.user SET user_password = :user_password WHERE user_id = :user_id';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_password', $user_password, PDO::PARAM_STR);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}

// Delete User
function deleteUser($user_id) {
	global $db;
	$sql = 'DELETE FROM project01.user WHERE user_id = :user_id LIMIT 1';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$rowsChanged = $stmt->rowCount();
	$stmt->closeCursor();
	return $rowsChanged;
}