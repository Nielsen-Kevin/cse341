<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main id="album-form">
	<h1><?=$docTitle?></h1>
	<p>
		<a href="?action=access-list&album_id=<?=$album_id?>">Back to Album Access</a>
	</p>
	<form method="POST">
		<div class="field-group">
			<label for="password">Password</label>
			<?=isset($password)?$password:''?>
		</div>
		
		<p>Confirm Password Deletion. Deletion is permanent.</p>
		<div class="field-group">
			<input type="hidden" name="access_id" value="<?=$access_id?>">
			<input type="hidden" name="album_id" value="<?=$album_id?>">
			<input type="hidden" name="action" value="delete-access">
			<input type='submit' value='Delete' class="button red">
		</div>
	</from>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>