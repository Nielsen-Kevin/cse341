<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/header.php'; ?>
	<main id="checkout">
		<h1>Checkout</h1>
		<?php if (isset($message)) {
			echo $message;
		} ?>
		<form action="?act=checkout" method="post" id="validate_form">
			<div class="field-group">
				<label for="firstName">First Name</label>
				<input type="text" name="firstName" id="firstName" placeholder="Enter our first name" required <?php if(isset($firstName)){echo "value='$firstName'";} ?>>
			</div>
			<div id="errorFirstName" class="error"><?php if(isset($error['firstName'])){echo $error['firstName'];} ?></div>
			<div class="field-group">
				<label for="lastName">Last Name</label>
				<input type="text" name="lastName" id="lastName" placeholder="Enter our last name" required <?php if(isset($lastName)){echo "value='$lastName'";} ?>>
			</div>
			<div id="errorLastName" class="error"><?php if(isset($error['lastName'])){echo $error['lastName'];} ?></div>
			
			<div class="field-group">
				<label for="email">Email</label>
				<input type="text" name="email" id="email" placeholder="Enter a valid email address" required <?php if(isset($email)){echo "value='$email'";} ?>>
			</div>
			<div id="errorEmail" class="error"><?php if(isset($error['email'])){echo $error['email'];} ?></div>

			<div class="field-group">
				<label for="phone">Phone</label>
				<input type="text" name="phone" id="phone" placeholder="000-000-0000" maxlength="12" required <?php if(isset($phone)){echo "value='$phone'";} ?>>
			</div>
			<div id="errorPhone" class="error"><?php if(isset($error['phone'])){echo $error['phone'];} ?></div>

			<div class="field-group">
				<label for="address">Address</label>
			</div>
			<input type="text" name="address" id="address" placeholder="Street" required <?php if(isset($address)){echo "value='$address'";} ?>>
			<div id="errorAddress" class="error"><?php if(isset($error['address'])){echo $error['address'];} ?></div>
			<div class="field-group items three">
				<input type="text" name="city" id="city" placeholder="City" required <?php if(isset($city)){echo "value='$city'";} ?>>
				<input type="text" name="state" id="state" placeholder="State" maxlength="2" required <?php if(isset($state)){echo "value='$state'";} ?>>
				<input type="text" name="zip" id="zip" placeholder="Zip" required <?php if(isset($zip)){echo "value='$zip'";} ?>>
				<div id="errorCity" class="error"><?php if(isset($error['city'])){echo $error['city'];} ?></div>
				<div id="errorState" class="error"><?php if(isset($error['state'])){echo $error['state'];} ?></div>
				<div id="errorZip" class="error"><?php if(isset($error['zip'])){echo $error['zip'];} ?></div>
			</div>
			<div class="right">
				<input type="hidden" name="action" value="checkout">
				<input type="submit" name="submit" value="Checkout" class="button">
			</div>
		</form>
	</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/footer.php'; ?>