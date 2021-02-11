<?php
//Get the database connection file
require_once 'connections.php';
echo "<h1>Scripture Resources</h1>";

try {
	$statement = $db->prepare('SELECT id, book, chapter, verse, content FROM team05.scriptures');
	$statement->execute();

	// Go through each result
	while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
		echo '<div><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '</div>';
	}
} catch (PDOException $e) {
	//echo $e;
	echo 'PDO Error hidden';
}