<?php
// Check for local build
if(preg_match("/C:\/xampp\/htdocs/", $_SERVER["DOCUMENT_ROOT"])) {

	// Root adjustment
	$_SERVER['DOCUMENT_ROOT'] .= '/cse341/web/';

} else {
	// No setting at this timeRoot 
}

// Site Time
date_default_timezone_set('America/Los_Angeles');
echo $_SERVER['DOCUMENT_ROOT'];
