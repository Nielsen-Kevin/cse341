<?php require $_SERVER['DOCUMENT_ROOT'] . '/week05/view/header.php'; ?>
<main id="gallery">

<?php if(isset($isPrivate)) { ?>

	<div class="center">
		<i class="fas fa-lock"></i> <?=$isPrivate?>
	</div>

<?php } else { ?>

	<div>
		<img src="images/<?=$img['imageName']?>" alt="<?=$img['imageTitle'];?>" class="responsive">
		<h1><?=$img['imageTitle']?></h1>
		<p class="description"><?=$img['imageCaption']?></p>
		<div class="center">
			<?=$img['albumId']?'<a href="?album='.$img['albumId'].'">Back to Album</a>':''?>	
		</div>
	</div>
	<?php if(!empty($img['imageShareKey'])) {
		echo '<input value="'.$img['imageShareKey'].'">';
	} ?>
<?php } ?>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week05/view/footer.php'; ?>