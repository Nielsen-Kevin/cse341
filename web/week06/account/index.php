<?php
# Accounts Controller 

session_start();
// Configuration
require '../../config.php';
// Load libraries
include_once '../../library/connections.php';
include_once '../../library/functions.php';
$db = dbConnect();
// Load models
include_once '../model/user.php';

// Get the value from the action name - value pair
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

switch ($action) {
	/*--------------------
		Login
	--------------------*/
	case 'login':
		do {
			if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
				break;
			}

			// Sanitize data coming in
			$userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
			$userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
			
			// Validation fields
			$checkEmail = checkEmail($userEmail);

			print_e($_POST,$checkEmail);

			// Run basic checks, return if errors
			if(empty($checkEmail) || empty($userPassword)){
				$errors = [];
				if (empty($checkEmail)) {
					$errors['errorEmail'] = 'Email is required.';
				}
				if (empty($userPassword)) {
					$errors['errorPassword'] = 'Password is required.';
				}

				$message = '<p class="error">Please provide a valid email address and password.</p>';
				extract($errors);
				break;
			}
			// A valid password exists, proceed with the login process
			// Query the client data based on the email address
			$userData = getUserByEmail($userEmail);

			$failedMessage = '<p class="error">Your login attempt was not successful. Please try again.</p>';

			// Check if user is found
			if(empty($userData)) {
				$message = $failedMessage ." NO USER";
				break;
			}

			// Compare the password  just submitted against hash
			$hashCheck = password_verify($userPassword, $userData['user_password']);
			// If the hashes don't match create an error and return to the login view
			if(!$hashCheck) {
				$message = $failedMessage;
				break;
			}

			// A valid user exists, log them in
			$_SESSION['loggedin'] = TRUE;
			// Remove the password from the array by using array_pop
			array_pop($userData);
			// Store the array into the session
			$_SESSION['userData'] = $userData;

			if(isset($_SESSION['returnUrl'])) {
				$returnUrl = $_SESSION['returnUrl'];
				unset($_SESSION['returnUrl']);
				// Redirect them
				header('Location: ' . $returnUrl);
				exit;
			}
			header('Location: ../');
			exit;
		} while (false);

		include '../view/login.php';
	break;

	/*--------------------
		Logout
	--------------------*/
	case 'logout':
		// End the current session
		session_destroy();
		// Rederect page
		header('Location: ../account/');
		exit;
	break;

	/*--------------------
		Login Account
	--------------------*/
	default:
		// Handle message from session
		if (isset($_SESSION['message'])) {
			$message = $_SESSION['message'];
			// Clear message after used
			unset($_SESSION['message']);
		}

		//default for now
		include '../view/login.php';

}