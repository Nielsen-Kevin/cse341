<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main>
	<section>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<h2>Log In</h2>
			<p><b>Please enter your email and password.</b></p>

			<?=isset($message)?$message:''?>

			<p>
				<label for="userEmail">Email:</label>
				<input name="userEmail" type="text" id="userEmail" <?php echo isset($userEmail) && isset($errorPassword)?'value="'.$userEmail.'"':'';?> required/>
				<span class="error"><?=isset($errorEmail)?'*':''?></span>
			</p>
			<p>
				<label for="userPassword">Password:</label>
				<input name="userPassword" type="password" id="userPassword" required/>
				<span class="error"><?=isset($errorPassword)?'*':''?></span>
			</p>
			<p>
				<input type="hidden" name="action" value="login">
				<input type="submit" value="Log In" class="button" />
			</p>
		</form>
	</section>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>