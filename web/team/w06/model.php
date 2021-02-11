<?php

function deleteScriptures($id) {
	global $db;
	// remove connected topics first
	$statement = $db->prepare('DELETE FROM team06.scripture_topic WHERE scripture_id = :id');
	$statement->execute(['id' => $id]);
	// now remove scripture
	$statement = $db->prepare('DELETE FROM team06.scriptures WHERE id = :id');
	$statement->execute(['id' => $id]);
	return $rowsChanged;
}

function getTopics() {
	global $db;
	$topics = $db->query('SELECT id, name FROM team06.topic', PDO::FETCH_ASSOC);
	return $topics;
}

function getScriptures() {
	global $db;
	//$scriptures = $db->query('SELECT id, book, chapter, verse, content FROM team06.scriptures', PDO::FETCH_ASSOC);
	$stmt = $db->prepare('SELECT id, book, chapter, verse, content FROM team06.scriptures');
	$stmt->execute();
	$scriptures = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	// Get topics add it to each scripture
	foreach($scriptures as $index => $row) {
		$scriptures[$index]['topics'] = getTopicsByScripture($row['id']);
	}

	return $scriptures;
}

function getTopicsByScripture($scripture_id) {
	global $db;
	$stmt = $db->prepare('SELECT t.name 
		FROM team06.scripture_topic s 
		INNER JOIN team06.topic t 
		ON s.topic_id = t.id 
		WHERE s.scripture_id = :scripture_id'
	);

	$stmt->bindValue(':scripture_id', $scripture_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	$topics = [];
	// clean up nested and return only names
	foreach($rows as $row) {
		$topics[] = $row['name'];
	}
	return $topics;
}

function addScripture($data) {
	global $db;
	// save scripture
	$statement = $db->prepare('INSERT INTO team06.scriptures 
		(book, chapter, verse, content) 
		VALUES 
		(:book, :chapter, :verse, :content)'
	);
	$statement->execute([
		'book' => $data['book'], 
		'chapter' => $data['chapter'], 
		'verse' => $data['verse'], 
		'content' => $data['content']
	]);
	$scriptureID = $db->lastInsertId();

	// Make sure topics are there
	if(!empty($data['topics'])) {
		// Save topics
		foreach ($data['topics'] as $topicID) {
			$statement = $db->prepare('INSERT INTO team06.scripture_topic 
				(topic_id, scripture_id) 
				VALUES 
				(?, ?)'
			);
			$statement->execute([$topicID, $scriptureID]);
		}
	}
}