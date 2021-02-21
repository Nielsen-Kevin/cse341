<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main id="image-form">
	<h1><?=$docTitle?></h1>
	<?=isset($message)?$message:''?>
	<p>
		<a href="?action=access-list&album_id=<?=$album_id?>">Back to Album Access</a>
	</p>

	<form method="POST">
		<div class="field-group">
			<label for="password">Password</label>
			<input type='text' name='password' id="password" required value="<?=isset($password)?$password:''?>">
			<span class="error"><?=isset($error_password)?'*':''?></span>
		</div>
		<div class="field-group">
			<?php if(isset($access_id)) { ?>
				<input type="hidden" name="access_id" value="<?=$access_id?>">
			<?php } ?>
			<input type="hidden" name="album_id" value="<?=$album_id?>">
			<input type="hidden" name="action" value="<?=isset($submitTo)?$submitTo:'add-access'?>">
			<input type='submit' value='Submit' class="button">
		</div>
	</from>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>