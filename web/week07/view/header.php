<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo (isset($docTitle) ? $docTitle : ''); ?></title>
	<link rel="stylesheet" href="<?=HTTP_ROOT?>week07/css/style.css">
	<link href="<?=HTTP_ROOT?>css/fontawesome/all.min.css" rel="stylesheet">
</head>
<body>
	<header>
		<h1 data-text="Gallery">Gallery</h1>
		<p>Web Backend Development II - CSE 341</p>
		<?php $url = (empty($_SESSION['userData'])) ? HTTP_ROOT.'week07/account/?action=login': HTTP_ROOT.'week07/account/?action=logout';?>


		<div id="login-header" class="clickable" onclick="location.href = '<?=$url?>'">
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
			<li><a href="<?=HTTP_ROOT?>?action=assignments" title="Assignments">CSE 341</a></li>
			<li><a href="<?=HTTP_ROOT?>week07/?action=album&id=1" title="Cart">Main</a></li>
			<?php if(!empty($_SESSION['userData'])) { ?>
				<li><a href="<?=HTTP_ROOT?>week07/?action=album-list"title="Admin">Admin</a></li>
			<?php } ?>
		</ul>
	</nav>

