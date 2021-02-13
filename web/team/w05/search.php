<?php
require_once 'connections.php';

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
	
	$book = filter_input(INPUT_POST, 'book', FILTER_SANITIZE_STRING);
	try {
		$sql = 'SELECT * FROM team05.scriptures WHERE book LIKE :book';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':book', "%$book%", PDO::PARAM_STR);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		foreach ($rows as $row) {
			echo '<div><a href="scripturesDetails.php?id=' . $row["id"] . '"><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b></a></div>';
		}
	} catch (PDOException $e) {
		//echo $e;
		echo 'PDO Error hidden';
	}
}
?>

<html>
	<form method="POST">
		<input type='text' name='book' value="<?=$book?>">
		<input type='submit' value='submit'>
	</from>
</html>