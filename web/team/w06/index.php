<?php
require '../../library/connections.php';
require 'model.php';
$db = dbConnect();

if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
	$delete_id = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_NUMBER_INT);

	if($delete_id != null) {
		deleteScriptures($delete_id);
		header('Location: .');
	}
}

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
	$data['book'] = filter_input(INPUT_POST, 'book', FILTER_SANITIZE_STRING);
	$data['chapter'] = filter_input(INPUT_POST, 'chapter', FILTER_SANITIZE_NUMBER_INT);
	$data['verse'] = filter_input(INPUT_POST, 'verse', FILTER_SANITIZE_NUMBER_INT);
	$data['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
	$data['topics'] = filter_input(INPUT_POST, 'topics', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);

	$add_new = filter_input(INPUT_POST, 'add_new', FILTER_SANITIZE_STRING);
	$topic_name = filter_input(INPUT_POST, 'topic_name', FILTER_SANITIZE_STRING);

	if($add_new != null && !empty($topic_name)) {
		// add new new_topic
		$statement = $db->prepare('INSERT INTO team06.topic (name) VALUES (:name)');
		$statement->execute(['name' => $topic_name]);
		//add to topics
		$data['topics'][] = $db->lastInsertId();
	}
	//send to model to save
	addScripture($data);

	$using = filter_input(INPUT_POST, 'using', FILTER_SANITIZE_STRING);
	// Dont need to continue if using ajax
	if(!empty($using) && $using == 'ajax') {
		exit;
	}
}

// Get our lists
$topics = getTopics();
$scriptures = getScriptures();


foreach($scriptures as $row) {
	echo '<div><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '"<br>';
	echo implode(', ' , $row['topics']) . '<br>';
	echo '<a href="?delete=' . $row['id'] . '">remove</a>';
	echo '</div><br>';
}
?>

<hr>

<form method="POST">
	<label>Book <input type='text' name='book'></label><br>
	<label>Chapter <input type='text' name='chapter'></label><br>
	<label>Verse <input type='text' name='verse'></label><br>
	<label>Content <textarea name="content"></textarea></label><br>

	Topic <br>
	<?php foreach($topics as $topic) { ?>
		<label> <input type="checkbox" name="topics[]" value="<?=$topic['id']?>"> <?=$topic['name']?></label>
	<?php } ?><br>

	<label>New Topic
			<input type="checkbox" name="add_new" value="1">
			<input type='text' name='topic_name'>
	</label><br>
	<input type='submit' value='Normal Submit'><br>
	<input type='button' value='AJAX Submit' id="ajax">
</from>

<script>
// Note: we didn't do any js form validation oops :)
document.getElementById('ajax').addEventListener('click', (e) => {
	// prevent default
	e.preventDefault();

	// construct FormData object and load it with the form data
	var formData = new FormData(document.querySelector('form'));
	// value used in php
	formData.append('using', 'ajax');

	// sent data to the POST request
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	request.send(formData);
});
</script>