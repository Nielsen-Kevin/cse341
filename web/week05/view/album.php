<?php require $_SERVER['DOCUMENT_ROOT'] . '/week05/view/header.php'; ?>
<main id="gallery">
	
	<div>
		<h1><?=$album['albumTitle']?></h1>
		<p class="description"><?=$album['albumDescription']?></p>

		<?=$album['albumParent']?'<a href="?album='.$album['albumParent'].'">Back</a>':''?>

		<?php if(!empty($img['albumShareKey'])) {
			echo '<input value="'.$img['albumShareKey'].'">';
		} ?>
	</div>

	<div class="album-grid">
	<?php foreach ($subAlbums as $sub) { ?>

		<div class="card">
			<div class="head">
				<?php if($sub['albumPrivate']) { ?>
						<div class="private">-private-</div><i class="fas fa-lock"></i>
				<?php } ?>
				<a href="?album=<?=$sub['albumId']?>"><i class="fas fa-images"></i></a>
			</div>
			<div class="body">
				<h2 class="itemTitle"><a href="?album=<?=$sub['albumId']?>"><?=$sub['albumTitle']?></a></h2>
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
					<?php if($img['imagePrivate']) { ?>
						<div class="private">-private-</div><i class="fas fa-lock"></i>
					<?php } ?>
					<img src="images/<?=$img['imageName']?>" alt="<?=$img['imageTitle'];?>" class="responsive">
					<div class="body">
					<a href="?image=<?=$img['imageId']?>">
						<h2><?=$img['imageTitle']?></h2>
						<?=$img['imageCaption']?>
					</a>
						<?php if(!empty($img['imageShareKey'])) {
							echo '<input value="'.$img['imageShareKey'].'">';
						} ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week05/view/footer.php'; ?>