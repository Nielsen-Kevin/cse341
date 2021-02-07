<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo (isset($docTitle) ? $docTitle : ''); ?></title>
	<link rel="stylesheet" href="css/style.css">
	<link href="../css/fontawesome/all.min.css" rel="stylesheet">
</head>
<body>
	<header>
		<h1 data-text="Gallery">Gallery</h1>
		<p>Web Backend Development II - CSE 341</p>
	
		<div id="login-header" class="clickable" onclick="location.href = '?action=login'">
			<i class="fas fa-sign-in-alt"></i> &nbsp
			<?php if(empty($_SESSION['userData'])) { ?>
				Login
			<?php } else { ?>
				Logout
			<?php } ?>
		</div>
	</header>
	<nav>
		<ul>
			<li><a href="../?action=assignments" title="Assignments">CSE 341</a></li>
			<li><a href="?album=1" title="Cart">Main</a></li>
		</ul>
	</nav>

