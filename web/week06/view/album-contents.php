
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/header.php'; ?>
<main id="gallery">

<h1>Index</h1>
<?=isset($message)?$message:''?>

<p>
	<a href="?action=album-list">Back to Index</a>
</p>
<p>
	<a href="?action=add-image&album_id=<?=$album_id?>">Create New Images</a>
</p>

<div class="album-grid">
		<?php if(empty($images)) { ?>
			no images
		<?php } else { ?>
			<?php foreach ($images as $img) { ?>
				<div class="card">
					<?php if($img['image_private']) { ?>
						<div class="private">-private-</div><i class="fas fa-lock"></i>
					<?php } ?>
					<img src="images/<?=$img['image_name']?>" alt="<?=$img['image_title'];?>" class="responsive">
					<div class="body">
						<h2><?=$img['image_title']?></h2>
						<?=$img['image_caption']?>
						<?php if(!empty($img['image_share_key'])) {
							echo '<input value="'.$img['image_share_key'].'">';
						} ?>
						<div>
							<a href="?action=edit-image&image_id=<?=$img['image_id']?>">Edit</a> |
							<a href="?action=delete-image&image_id=<?=$img['image_id']?>">Delete</a>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>


</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week06/view/footer.php'; ?>