<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/header.php'; ?>
<main id="image-form">
	<h1><?=$docTitle?></h1>
	<?=isset($message)?$message:''?>
	<p>
		<a href="?action=album-images&album_id=<?=$album_id?>">Back to Album</a>
	</p>

	<form method="POST">
		<div class="field-group">
			<label for="album_id">Album</label>
			<select name="album_id" required>
				<?php if(isset($albumList)) {
					foreach ($albumList as $album) {
						// Check if option is selected
						echo '<option value="' . $album['album_id'] . '"';
						echo (isset($album_id) && $album_id === $album['album_id']) ? ' selected' : '';
						echo '>' . $album['album_title'] . '</option>';
					}
				} ?>
			</select>
			<span class="error"><?=isset($error_album_id)?'*':''?></span>
		</div>
		<div class="field-group">
			<label for="image_title">Title</label>
			<input type='text' name='image_title' id="image_title" required value="<?=isset($image_title)?$image_title:''?>">
			<span class="error"><?=isset($error_image_title)?'*':''?></span>
		</div>
		<div class="field-group">
			<label for="image_caption">Caption</label>
			<input type='text' name='image_caption' id="image_caption" value="<?=isset($image_caption)?$image_caption:''?>">
			<span class="error"><?=isset($error_image_caption)?'*':''?></span>
		</div>

		<div class="field-group">
			<label for="image_name">Image</label>
			<input type='text' name='image_name' id="image_name" required value="<?=isset($image_name)?$image_name:''?>">
			<span class="error"><?=isset($error_image_name)?'*':''?></span>
		</div>
		<?php if(isset($image_name)) { ?>
			<img src="images/<?=$image_name?>" alt="<?=$image_title;?>" class="thumb">
		<?php } ?>

		<div class="field-group">
			<label for="image_private">Private</label>
			<input type='checkbox' name='image_private' id="image_private" value="1" <?=isset($image_private)&&($image_private==1)?'checked':''?>>
		</div>
		<?php if(isset($image_share_key)) { ?>
		<div class="field-group">
			<label for="image_share_key">Share Key</label>
			<input type='text' name='image_share_key' id="image_share_key" value="<?=isset($image_share_key)?$image_share_key:''?>">
		</div>
		<?php } ?>
		<div class="field-group">
			<label for="image_order">Order</label>
			<input type='text' name='image_order' value="<?=isset($image_order)?$image_order:''?>">
		</div>

		<div class="field-group">
			<?php if(isset($image_id)) { ?>
				<input type="hidden" name="image_id" value="<?=$image_id?>">
			<?php } ?>
			<input type="hidden" name="action" value="<?=isset($submitTo)?$submitTo:'add-image'?>">
			<input type='submit' value='Submit' class="button">
		</div>
	</from>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/footer.php'; ?>