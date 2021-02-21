<?php
# Custom Function Library

/*--------------------
	Field Validation
--------------------*/
// Check for valid email address
// Returns empty if invalided
function checkEmail($email) {
	$valEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
	return $valEmail;
}


/*--------------------
	Login Aids
--------------------*/

function setReturnUrl() {
	// Get return URL
	$returnUrl = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
	$_SESSION['returnUrl'] = $returnUrl;
}

// Login required area
function loginRequired($loction = './account/') {
	if( !(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) ) {
		//Set Return
		setReturnUrl();
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

// Check if login and has adequate user level
function minAccessRequired($level, $loction = './account/') {
	if( !(isset($_SESSION['loggedin']) && $_SESSION['userData']['user_level'] >= $level) ) {
		// force them away
		header('Location: '. $loction);
		exit;
	}
}

function accessRequired($level, $loction = './account/') {
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
	Other
--------------------*/
function sessionMessage() {
	// Handle message from session
	if (isset($_SESSION['message'])) {
		$message = $_SESSION['message'];
		// Clear message after used
		unset($_SESSION['message']);
		return $message;
	}
	return '';
}


function create_guid() { // Create GUID (Globally Unique Identifier)
	$guid = '';
	$namespace = rand(11111, 99999);
	$uid = uniqid('', true);
	$data = $namespace;
	$data .= $_SERVER['REQUEST_TIME'];
	$data .= $_SERVER['HTTP_USER_AGENT'];
	$data .= $_SERVER['REMOTE_ADDR'];
	$data .= $_SERVER['REMOTE_PORT'];
	//$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
	$hash = hash('ripemd128', $uid . $guid . md5($data));
	$guid = substr($hash,  0,  8) . '-' .
			substr($hash,  8,  4) . '-' .
			substr($hash, 12,  4) . '-' .
			substr($hash, 16,  4) . '-' .
			substr($hash, 20, 12);
	return $guid;
}

/*--------------------
	String Handling
--------------------*/
if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');

	function utf8_strlen($string) {
		return mb_strlen($string);
	}

	function utf8_strpos($string, $needle, $offset = 0) {
		return mb_strpos($string, $needle, $offset);
	}

	function utf8_strrpos($string, $needle, $offset = 0) {
		return mb_strrpos($string, $needle, $offset);
	}

	function utf8_substr($string, $offset, $length = null) {
		if ($length === null) {
			return mb_substr($string, $offset, utf8_strlen($string));
		} else {
			return mb_substr($string, $offset, $length);
		}
	}

	function utf8_strtoupper($string) {
		return mb_strtoupper($string);
	}

	function utf8_strtolower($string) {
		return mb_strtolower($string);
	}	
} else {
	function utf8_strlen($string) {
		return iconv_strlen($string, 'UTF-8');
	}

	function utf8_strpos($string, $needle, $offset = 0) {
		return iconv_strpos($string, $needle, $offset, 'UTF-8');
	}

	function utf8_strrpos($string, $needle) {
		return iconv_strrpos($string, $needle, 'UTF-8');
	}

	function utf8_substr($string, $offset, $length = '') {
		if ($length === '') {
			return iconv_substr($string, $offset, utf8_strlen($string), 'UTF-8');
		} else {
			return iconv_substr($string, $offset, $length, 'UTF-8');
		}
	}

	function utf8_strtolower($string) {
		return strtolower($string);
	}

	function utf8_strtoupper($string) {
		return strtoupper($string);
	}

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