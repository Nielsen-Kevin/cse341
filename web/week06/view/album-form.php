<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/header.php'; ?>
<main id="album-form">

	<h1><?=$docTitle?></h1>
	<?=isset($message)?$message:''?>

	<p>
		<a href="?action=album-list">Back to Index</a>
	</p>

	<form method="POST">
		<div class="field-group">
			<label for="album_parent">Parent</label>
			<select name="album_parent" required>
				<option value="0">-- no parent --</option>
				<?php if(isset($albumsList)) {
					foreach ($albumsList as $album) {
						// remove self
						if(isset($album_id) && $album_id === $album['album_id'])
							continue;
						// Check if option is selected
						echo '<option value="' . $album['album_id'] . '"';
						echo (isset($album_parent) && $album_parent === $album['album_id']) ? ' selected' : '';
						echo '>' . $album['album_title'] . '</option>';
					}
				} ?>
			</select>
			<span class="error"><?=isset($error_album_parent)?'*':''?></span>
		</div>
		<div class="field-group">
			<label for="album_title">Title</label>
			<input type='text' name='album_title' id="album_title" required value="<?=isset($album_title)?$album_title:''?>">
			<span class="error"><?=isset($error_album_title)?'*':''?></span>
		</div>
		<div class="field-group">
			<label for="album_description">Description</label>
			<textarea name='album_description' id="album_description"><?=isset($album_description)?$album_description:''?></textarea>
			<span class="error"><?=isset($error_album_description)?'*':''?></span>
		</div>
		<div class="field-group">
			<label for="album_private">Private</label>
			<input type='checkbox' name='album_private' id="album_private" value="1" <?=isset($album_private)&&($album_private==1)?'checked':''?>>
		</div>
		<?php if(isset($album_share_key)) { ?>
		<div class="field-group">
			<label for="album_share_key">Share Key</label>
			<input type='text' name='album_share_key' id="album_share_key" value="<?=isset($album_share_key)?$album_share_key:''?>">
		</div>
		<?php } ?>
		<div class="field-group">
			<label for="album_order">Order</label>
			<input type='text' name='album_order' value="<?=isset($album_order)?$album_order:''?>">
		</div>

		<div class="field-group">
			<?php if(isset($album_id)) { ?>
				<input type="hidden" name="album_id" value="<?=$album_id?>">
			<?php } ?>
			<?php if(isset($user_id)) { ?>
				<input type="hidden" name="user_id" value="<?=$user_id?>">
			<?php } ?>
			<input type="hidden" name="action" value="<?=isset($submitTo)?$submitTo:'add-album'?>">
			<input type='submit' value='Submit' class="button">
		</div>
	</from>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/footer.php'; ?>