
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
			<td>
				<?=$album['album_share_key']?>

				<input type="text" class="share_key" value="<?=HTTP_ROOT?>week07/?action=share&key=<?=$album['album_share_key']?>" id="key_<?=$album['album_id']?>">
				<div class="tooltip">
					<button onclick="copyClipboard(this, 'key_<?=$album['album_id']?>')" onmouseout="outReset(this)">
						<span class="tooltiptext">Copy to clipboard</span>Copy as URL
					</button>
				</div>
		
			</td>
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
<script>
function copyClipboard(el, id) {
	var copyText = document.getElementById(id);
	copyText.select();
	copyText.setSelectionRange(0, 99999);
	document.execCommand('copy');

	var tooltip = el.getElementsByClassName("tooltiptext")[0];
	tooltip.innerHTML = 'Copied';
}

function outReset(el) {
	var tooltip = el.getElementsByClassName("tooltiptext")[0];
	tooltip.innerHTML = 'Copy to clipboard';
}
</script>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>