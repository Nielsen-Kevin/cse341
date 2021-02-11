<?php
require 'connections.php';
$db = dbConnect();

$topics = $db->query('SELECT id, name FROM team06.topic', PDO::FETCH_ASSOC);
$scriptures = $db->query('SELECT id, book, chapter, verse, content FROM team06.scriptures', PDO::FETCH_ASSOC);

$all_topics = $db->query('SELECT s.scripture_id, t.name 
	FROM team06.scripture_topic s 
	INNER JOIN team06.topic t 
	ON s.topic_id = t.id', PDO::FETCH_ASSOC);

foreach($scriptures as $id => $row) {
	echo '<div><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '"<br>';

	foreach($all_topics as $topic_found) {
		echo print_r($topic_found, true);
		echo '<br>';

		if($row['id'] == $topic_found['scripture_id']){
			echo $topic_found['name'] . '<br>';
		}

	}
	echo '</div><br><br><br><br>';
}


if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
	
	//$id = filter_input(INPUT_GET, 'id', FILTER_INT, FILTER_SANITIZE_NUMBER_INT);

	$statement = $db->prepare('INSERT INTO team06.scriptures (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');
	$statement -> execute(['book' => $_POST['book'], 'chapter' => $_POST['chapter'], 'verse' => $_POST['verse'], 'content' => $_POST['content']]);
	$scriptureID = $db->lastInsertId();

	foreach ($_POST['topics'] as $topicID) {
		//echo "Topic: $topicID, Scripture: $scriptureID <br>";
		$statement = $db -> prepare('INSERT INTO team06.scripture_topic (topic_id, scripture_id) VALUES (?, ?)');
		$statement -> execute([$topicID, $scriptureID]);
	}
}
?>

<form method="POST">
	<label>Book <input type='text' name='book'></label><br>
	<label>Chapter <input type='text' name='chapter'></label><br>
	<label>Verse <input type='text' name='verse'></label><br>
	<label>Content <textarea name="content"></textarea></label><br>

	Topic <br>
	<?php foreach($topics as $topic) { ?>
		<label> <input type="checkbox" name="topics[]" value="<?=$topic['id']?>"> <?=$topic['name']?></label>
	<?php } ?>
	<input type='submit' value='submit'>
</from>

