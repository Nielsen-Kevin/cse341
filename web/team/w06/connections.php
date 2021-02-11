<?php
/* --------------------------------------------------
 Postgres and MySQL Connection using PDO class object
--------------------------------------------------- */

function LocalMySQL() {
	try {
		// Set Database Credentials
		$dbHost = 'localhost';
		$dbName = 'project01';
		$dbUser = 'iClient';
		$dbPassword = 'S5T3ZF24J8AYHilz';
		// Tell PDO to give us exception errors for debugging as needed
		$dbOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		// Create the PDO connection for MySQL
		$db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword, $dbOptions);
		return $db;
	}
	catch(PDOException $e) {
		echo 'Error connecting to DB.';
		exit;
	}
}

function HerokuPostgres() {
	try {
		// Default Heroku Postgres configuration URL
		$dbUrl = getenv('DATABASE_URL');
		// Get the various parts of the DB Connection from the URL
		$dbopts = parse_url($dbUrl);
		$dbHost = $dbopts["host"];
		$dbPort = $dbopts["port"];
		$dbUser = $dbopts["user"];
		$dbPassword = $dbopts["pass"];
		$dbName = ltrim($dbopts["path"],'/');
		// Tell PDO to give us exception errors for debugging as needed
		$dbOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		// Create the PDO connection for PGSQL
		$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword, $dbOptions);
		return $db;
	}
	catch (PDOException $e) {
		echo 'Error connecting to DB.';
		exit;
	}
}

// Use this function to connect database
function dbConnect() {
	// Check for xampp folder installations using regex
	if(preg_match("/C:\/xampp\/htdocs/", $_SERVER["DOCUMENT_ROOT"])) {
		return LocalMySQL();
	} else {
		return HerokuPostgres();
	}
}

/*
	// How to use

	$db = dbConnect();

	$statement = $db->prepare('SELECT column FROM table');
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo $row['column'];
	}

*/