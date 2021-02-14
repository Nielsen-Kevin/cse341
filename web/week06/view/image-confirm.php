<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/header.php'; ?>
<main id="album-form">
	<h1><?=$docTitle?></h1>
	<p>
		<a href="?action=album-images&album_id=<?=$album_id?>">Back to Album</a>
	</p>
	<form method="POST">
		<img src="images/<?=$image_name?>" alt="<?=$image_title;?>">
		<div class="field-group">
			<label for="image_title">Title</label>
			<?=isset($image_title)?$image_title:''?>
		</div>
		<div class="field-group">
			<label for="image_caption">Caption</label>
			<?=isset($image_caption)?$image_caption:''?>
		</div>
		<div class="field-group">
			<label for="image_private">Private</label>
			<?=isset($image_private)&&($image_private==1)?'Yes':'No'?>
		</div>
		
		<p>Confirm Image Deletion. Deletion is permanent.</p>
		<div class="field-group">
			<input type="hidden" name="image_id" value="<?=$image_id?>">
			<input type="hidden" name="album_id" value="<?=$album_id?>">
			<input type="hidden" name="action" value="delete-image">
			<input type='submit' value='Delete' class="button red">
		</div>
	</from>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/footer.php'; ?>