<?php
require_once 'connections.php';

if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
	
	$id = filter_input(INPUT_GET, 'id', FILTER_INT FILTER_SANITIZE_NUMBER_INT);

	try {
		$stmt = $db->prepare('SELECT * FROM team05.scriptures WHERE id=:id');
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		echo '<div><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '</div>';
	} catch (PDOException $e) {
		//echo $e;
		echo 'PDO Error hidden';
	}
}