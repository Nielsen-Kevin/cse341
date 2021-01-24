<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/header.php'; ?>
<main id="items">

	<div class="item-grid">
		<?php foreach($items_list as $item) { ?>
		<div class="card">
			<form action="?act=cart-add" method="post">
				<div id="item-info">
					<h2 class="itemTitle"><?=$item['name'];?></h2>
					<div class="price">$<?=money($item['price']);?></div>
					<div class="description"><?=$item['description'];?></div>

					<?php if(isset($item['attribute'])) { ?>

						<?php if(isset($item['type'])) { ?>

						<div class="field-group options">
						<?php foreach($item['attribute'] as $i => $option) { ?>
							<?php if($item['type'] == 'radio') { ?>
							<label> <input type="radio" name="option[]" value="<?=$option?>"> <?=$option?></label><br>
							<?php } elseif($item['type'] == 'checkbox') { ?>
							<label> <input type="checkbox" name="option[]" value="<?=$option?>"> <?=$option?></label><br>
							<?php } elseif($item['type'] == 'text') { ?>
							<label for="opt_<?=$item['itemid'];?>_<?=$i?>"><?=$option?>:</label><input type="text" name="option[]" id="opt_<?=$item['itemid'];?>_<?=$i?>">
							<?php } ?>
						<?php } ?>
						</div>

						<?php } ?>
					<?php } ?>

					<div class="field-group qty">
						<b>Qty</b>
						<input type="number" name="qty" value="1" maxlength="3">
						<input type="hidden" name="itemid" value="<?=$item['itemid'];?>">
						<input type="submit" value="Add to Cart" class="button">
					</div>
				</div>
			</form>
		</div>
	<?php } ?>
	</div>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/footer.php'; ?>