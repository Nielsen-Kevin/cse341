<?php
#----------------------------------------#
#	Main Controller
#----------------------------------------#
session_start();
require 'config.php';


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

switch ($action) {
	case 'assignments':
		// Assignment List
		$assignments = [
			['week'=>'Week 01', 'url'=>'week1/hello.html', 'title'=>'Hello World'],
			['week'=>'Week 02', 'url'=>'index.php', 'title'=>'Homepage'],
			['week'=>'Week 03', 'url'=>'week03/', 'title'=>'Shopping Cart'],
			['week'=>'Week 04', 'url'=>'#', 'title'=>'DB Setup'],
			['week'=>'Week 05', 'url'=>'#', 'title'=>'DB Access'],
			['week'=>'Week 06', 'url'=>'#', 'title'=>'DB Update'],
			['week'=>'Week 08', 'url'=>'#', 'title'=>'Hello World'],
			['week'=>'Week 09', 'url'=>'#', 'title'=>'Postal Rate Calculator'],
			['week'=>'Week 10', 'url'=>'#', 'title'=>'Milestone 1'],
			['week'=>'Week 11', 'url'=>'#', 'title'=>'Milestone 2'],
			['week'=>'Week 12', 'url'=>'#', 'title'=>'Milestone 3'],
		];
		// Project List
		$projects = [
			['week'=>'Week 07', 'url'=>'#', 'title'=>'Project 1'],
			['week'=>'Week 14', 'url'=>'#', 'title'=>'Project 2']
		];
		// Page title
		$docTitle = "Assignments - CSE 341";
		include 'week02/assignments.php';
	break;

	default:
		// Page title
		$docTitle = "Kevin Nielsen - CSE 341";
		include 'week02/home.php';
}

