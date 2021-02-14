<?php
// Setting for Local and live builds
if(preg_match("/C:\/xampp\/htdocs/", $_SERVER["DOCUMENT_ROOT"])) {
	// Root adjustment
	$_SERVER['DOCUMENT_ROOT'] .= '/cse341/web';
	define( 'HTTP_ROOT', 'http://localhost/cse341/web/' );
} else {
	// heroku Root
	define( 'HTTP_ROOT', 'https://secret-scrubland-75850.herokuapp.com/' );
}

// Site Time
date_default_timezone_set('America/Los_Angeles');
