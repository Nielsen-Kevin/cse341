<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main id="album-form">

<h1>Access List</h1>
<?=isset($message)?$message:''?>

<p>
	<a href="?action=album-list">Back to Index</a>
</p>
<p>
	<a href="?action=add-access&album_id=<?=$album_id?>">Create New Password</a>
</p>

<table class="list-table">
	<thead>
		<tr>
			<th>Password</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($list as $pass){ ?>
		<tr>
			<td><?=$pass['password']?></td>
			<td class="right" 	>
				<a href="?action=edit-access&access_id=<?=$pass['access_id']?>">Edit</a> |
				<a href="?action=delete-access&access_id=<?=$pass['access_id']?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>