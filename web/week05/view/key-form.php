<?php require $_SERVER['DOCUMENT_ROOT'] . '/week05/view/header.php'; ?>
<main id="gallery">

<?=isset($message)?$message:''?>

<form method="POST">
	<div class="field-group">
		<b>Key</b>
		<input type='text' name='key' value="<?=isset($key)?$key:''?>">
		<input type="hidden" name="action" value="key-in">
		<input type='submit' value='submit' class="button">
	</div>
</from>

<?=isset($errorKey)?$errorKey:''?>
<?=isset($errorAlbumId)?$errorAlbumId:''?>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week05/view/footer.php'; ?>