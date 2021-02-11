<?php
require $_SERVER['DOCUMENT_ROOT'] . '/web/library/connections.php';
$db;

$topics = $db->query('SELECT id, name FROM team06.topic', PDO::FETCH_ASSOC);


if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
	
	$id = filter_input(INPUT_GET, 'id', FILTER_INT FILTER_SANITIZE_NUMBER_INT);

	$stmt = $db->prepare('SELECT id, book, chapter, verse, content FROM team06.scriptures WHERE id=:id');
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$scriptures = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	$stmt = $db->prepare('SELECT t.name 
	FROM team06.scripture_topic s 
	JOIN team06.topic t 
	IN s.topic_id = t.id WHERE scripture_id=:id');
	
	$scripture_list =[];
	foreach($scriptures as $scripture) {
		$scripture_list = $scripture;
		$stmt->bindValue(':id', $scripture['id'], PDO::PARAM_INT);
		$stmt->execute();
		$scripture_list['topics'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	$stmt->closeCursor();


	print_r($scripture_list);


	echo '<div><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '</div>';

}

?>

<form method="POST">
	<label>Book <input type='text' name='book'></label><br>
	<label>Chapter <input type='text' name='chapter'></label><br>
	<label>Verse <input type='text' name='verse'></label><br>
	<label>Content <textarea name="content"></textarea></label><br>

	Topic <br>
	<?php foreach($topics as $topic) { ?>
		<label> <input type="checkbox" name="topic[]" value="<?=$topic['id']?>"> <?=$topic['name']?></label>
	<?php } ?>
	<input type='submit' value='submit'>
</from>

