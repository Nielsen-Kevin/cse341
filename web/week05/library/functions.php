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
	if( !(isset($_SESSION['loggedin']) && $_SESSION['userData']['userLevel'] >= $level) ) {
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

function accessRequired($level, $loction = '/account/') {
	if( !(isset($_SESSION['loggedin']) && $_SESSION['userData']['userLevel'] == $level) ) {
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

function accessPermission($albumId) {
	if( !empty($_SESSION['keys']) && is_array($_SESSION['keys']) ) {
		$activeKeys = $_SESSION['keys'];
		if(in_array($albumId, $activeKeys)) {
			return;
		}
	}
	//Set Return
	setReturnUrl();	
	include 'view/key-form.php';
	exit;
}

function isAlbumOwner($userId) {
	//Is loginin
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
		//Is owner
		if($_SESSION['userData']['userId'] == $userId) {
			return true;
		//Is admin
		} elseif($_SESSION['userData']['userLevel'] >= 3) {
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