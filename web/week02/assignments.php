<?php require $_SERVER['DOCUMENT_ROOT'] . '/template/header.php'; ?>
<?php
// Assignments List
$assignments = [
	['week'=>'Week 01', 'url'=>'week1/hello.html', 'title'=>'Hello World'],
	['week'=>'Week 02', 'url'=>'/', 'title'=>'Homepage'],
	['week'=>'Week 03', 'url'=>'#', 'title'=>'Shopping Cart'],
	['week'=>'Week 04', 'url'=>'#', 'title'=>'DB Setup'],
	['week'=>'Week 05', 'url'=>'#', 'title'=>'DB Access'],
	['week'=>'Week 06', 'url'=>'#', 'title'=>'DB Update'],
	['week'=>'Week 08', 'url'=>'#', 'title'=>'Hello World'],
	['week'=>'Week 09', 'url'=>'#', 'title'=>'Postal Rate Calculator'],
	['week'=>'Week 10', 'url'=>'#', 'title'=>'Milestone 1'],
	['week'=>'Week 11', 'url'=>'#', 'title'=>'Milestone 2'],
	['week'=>'Week 12', 'url'=>'#', 'title'=>'Milestone 3'],
];

$projects = [
	['week'=>'Week 07', 'url'=>'#', 'title'=>'Project 2'],
	['week'=>'Week 14', 'url'=>'#', 'title'=>'Project 2']
];

?>
<main>
	<h1>CSE 341 Assignments</h1>
	<h3 style="text-align:center;">Assignments</h3>
	<ul class="grid">
		<?php foreach($assignments as $a) {
			echo '<li><a href="'. $a['url'] .'">'. $a['week'] .'</a><div class="sub-title">'. $a['title'] .'</div></li>';
		} ?>
	</ul>
	<h3 style="text-align:center;">Projects</h3>
	<ul class="grid">
		<?php foreach($projects as $p) {
			echo '<li><a href="'. $p['url'] .'">'. $p['week'] .'</a><div class="sub-title">'. $p['title'] .'</div></li>';
		} ?>
	</ul>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/template/footer.php'; ?>