<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo (isset($docTitle) ? $docTitle : ''); ?></title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<h1 data-text="Kevin Nielsen">Kevin Nielsen</h1>
		<p>Web Backend Development II - CSE 341</p>
	</header>
	<nav>
		<ul>
			<li><a href="index.php" title="Home">Home</a></li>
			<li><a href="?action=assignments" title="CSE 341 Assignments">Assignments</a></li>
		</ul>
	</nav>