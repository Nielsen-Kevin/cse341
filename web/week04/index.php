<?php
include '../week05/library/connections.php';

$db = dbConnect();

echo '<pre>';
if(is_object($db)) {
	echo "Database is good to go!\n\n";
}

itemDiscontinued($db);

function itemDiscontinued($db) {
	try {
		$result = $db->query("SHOW TABLES");
		while ($row = $result->fetch(PDO::FETCH_NUM)) {
			echo "Table $row[0] is good to go!\n";
		}
	}
	catch (PDOException $e) {
		echo "Error with tables!\n\n";
	}
}
echo '</pre>';