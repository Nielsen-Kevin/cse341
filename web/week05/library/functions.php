<?php
# Custom Function Library

/*--------------------
	Login Aids
--------------------*/

function setReturnUrl() {
	// Get return URL
	$returnUrl = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
	$_SESSION['returnUrl'] = $returnUrl;
}

// Login required area
function loginRequired($loction = '/account/') {
	if( !(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) ) {
		//Set Return
		setReturnUrl();
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

// Check if login and has adequate user level
function minAccessRequired($level, $loction = '/account/') {
	if( !(isset($_SESSION['loggedin']) && $_SESSION['userData']['user_level'] >= $level) ) {
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

function accessRequired($level, $loction = '/account/') {
	if( !(isset($_SESSION['loggedin']) && $_SESSION['userData']['user_level'] == $level) ) {
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

function accessPermission($album_id) {
	if( !empty($_SESSION['keys']) && is_array($_SESSION['keys']) ) {
		$activeKeys = $_SESSION['keys'];
		if(in_array($album_id, $activeKeys)) {
			return;
		}
	}
	//Set Return
	setReturnUrl();	
	include 'view/key-form.php';
	exit;
}

function isAlbumOwner($user_id) {
	//Is loginin
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
		//Is owner
		if($_SESSION['userData']['user_id'] == $user_id) {
			return true;
		//Is admin
		} elseif($_SESSION['userData']['user_level'] >= 3) {
			return true;
		}
	}
	return false;
}

/*--------------------
	Debugging
--------------------*/

// Kevin's custom function to printing out data for testing
function print_e() {
	echo '<pre>';
	$numargs = func_num_args();
	$arg_list = func_get_args();
	for ($i = 0; $i < $numargs; $i++) {
		print_r( $arg_list[$i] );
		echo "\n";
	}
	echo '</pre>';
}