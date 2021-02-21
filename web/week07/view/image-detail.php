<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/header.php'; ?>
<main id="gallery">

<?php if(isset($isPrivate)) { ?>

	<div class="center">
		<i class="fas fa-lock"></i> <?=$isPrivate?>
	</div>

<?php } else { ?>

	<div>
		<img src="images/<?=$img['image_name']?>" alt="<?=$img['image_title'];?>" class="responsive">
		<h1><?=$img['image_title']?></h1>
		<p class="description"><?=$img['image_caption']?></p>
		<div class="center">
			<?=$img['album_id']?'<a href="?action=album&id='.$img['album_id'].'">Back to Album</a>':''?>
		</div>
	</div>

<?php } ?>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week07/view/footer.php'; ?>