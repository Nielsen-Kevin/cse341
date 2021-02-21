
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main id="album-form">

<h1>Index</h1>
<?=isset($message)?$message:''?>

<p>
	<a href="?action=add-album">Create New Album</a>
</p>

<table class="list-table">
	<thead>
		<tr>
			<th>User</th>
			<th>Parent</th>
			<th>Title</th>
			<th>Private</th>
			<th>Share Key</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($albumsList as $album){ ?>
		<tr>
			<td><?=$album['user_id']?></td>
			<td><?=$album['album_parent']?></td>
			<td><?=$album['album_title']?></td>
			<td><?=($album['album_private'])?'yes':'no'?></td>
			<td><?=$album['album_share_key']?></td>
			<td class="right">
				<a href="?action=edit-album&album_id=<?=$album['album_id']?>">Edit</a> |
				<a href="?action=album-images&album_id=<?=$album['album_id']?>">Images</a> |
				<a href="?action=access-list&album_id=<?=$album['album_id']?>">Access</a> |
				<a href="?action=delete-album&album_id=<?=$album['album_id']?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>