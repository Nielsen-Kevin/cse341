<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/header.php'; ?>
<main id="cart">
	<h1 class="pagetitle">Your Cart</h1>
	<?php if($items) { ?>
	<div class="cart-grid">
		<div class="cart-row border-under">
			<div class="heading left">SKU</div>
			<div class="heading left">Product</div>
			<div class="heading left">Quantity</div>
			<div class="heading center">Unit Price</div>
			<div class="heading right">Total</div>
		</div>

		<?php foreach($items as $item) { ?>
		<div class="cart-row" id="id_<?=$item['id']; ?>">
			<div class="left"><?=$item['itemid']; ?></div>
			<div class="left"><?=$item['name']; ?>
				<?php if(isset($item['options'])) { ?>
				<ul class='options'>
					<?php foreach($item['options'] as $option) { ?>
					<li><?php echo $option; ?></li>
					<?php } ?>
				</ul><?php } ?>
			</div>
			<div class="left "><input type="text" maxlength="3" name="itemid[<?=$item['id']; ?>]" value="<?=$item['qty']; ?>" data-id="<?=$item['id']; ?>" class="item-qty">
					&nbsp;<a href="?act=cart-remove&id=<?=$item['id']; ?>" class="basketRemove">Remove</a>
			</div>
			<div class="center">$ <span class="price"><?=money($item['price']); ?></span></div>
			<div class="right">$ <span class="sub-total"><?=$item['total']; ?></span></div>
		</div>
		<?php } ?>

		<div class="total-row right">
			Total: &nbsp; $ <span id="total"><?=money($total); ?></span>
		</div>
		<div class="button-row right">
			<a href="?act=checkout" class="button">Checkout</a>
		</div>

	<?php } else { ?>
		<div class="center">Your cart is empty.</div>
	<?php } ?>

	<p class="center">
		<a href="." class="">Continue Shopping</a>
	</p>

</main>
<script src="cart.js"></script>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/footer.php'; ?>