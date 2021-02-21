<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main id="gallery">
	
	<div>
		<h1><?=$album['album_title']?></h1>
		<p class="description"><?=$album['album_description']?></p>

		<?=$album['album_parent']?'<a href="?action=album&id='.$album['album_parent'].'">Back</a>':''?>
	</div>

	<div class="album-grid">
	<?php foreach ($subAlbums as $sub) { ?>

		<div class="card">
			<div class="head">
				<?php if($sub['album_private']) { ?>
						<div class="private">-private-</div><i class="fas fa-lock"></i>
				<?php } ?>
				<a href="?action=album&id=<?=$sub['album_id']?>"><i class="fas fa-images"></i></a>
			</div>
			<div class="body">
				<h2 class="itemTitle"><a href="?action=album&id=<?=$sub['album_id']?>"><?=$sub['album_title']?></a></h2>
			</div>
		</div>

	<?php } ?>
	</div>

	<div class="album-grid">
		<?php if(empty($images)) { ?>
			no images
		<?php } else { ?>
			<?php foreach ($images as $img) { ?>
				<div class="card">
					<div class="head">
					<?php if($img['image_private']) { ?>
						<div class="private">-private-</div><i class="fas fa-lock"></i>
					<?php } ?>
						<img src="images/<?=$img['image_name']?>" alt="<?=$img['image_title'];?>" class="responsive">
					</div>
					<div class="body">
					<a href="?action=image&id=<?=$img['image_id']?>">
						<h2><?=$img['image_title']?></h2>
						<?=$img['image_caption']?>
					</a>
						<?php if(!empty($img['image_share_key'])) {
							echo '<input value="'.$img['image_share_key'].'">';
						} ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>