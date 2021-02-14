<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/header.php'; ?>
<main id="album-form">

	<h1><?=$docTitle?></h1>
	<p>
		<a href="?action=album-list">Back to Index</a>
	</p>

	<p>Confirm Album Deletion. Deletion is permanent.</p>
	<form method="POST">
		<div class="field-group">
			<label for="album_title">Title</label>
			<input type='text' name='album_title' id="album_title" readonly value="<?=isset($album_title)?$album_title:''?>">
		</div>
		<div class="field-group">
			<label for="album_description">Description</label>
			<textarea name='album_description' id="album_description" readonly><?=isset($album_description)?$album_description:''?></textarea>
		</div>
		<div class="field-group">
			<label for="album_private">Private</label>
			<?=isset($album_private)&&($album_private==1)?'Yes':'No'?>
		</div>

		<div class="field-group">
			<?php if(isset($album_id)) { ?>
				<input type="hidden" name="album_id" value="<?=$album_id?>">
			<?php } ?>
			<input type="hidden" name="action" value="delete-album">
			<input type='submit' value='Delete' class="button red">
		</div>
	</from>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/footer.php'; ?>