<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/header.php'; ?>
	<main id="confirmation">
		<h1>Thank you for your order.</h1>
		<div class="invoice">
			<div class="info-list">
				<div class="info"><b>Invoice #:</b> <?=$invoiceNumber; ?></div>
				<div class="info"><b>Date:</b> <?=$invoiceDate; ?></div>

				<div class="info">
					<b>Name:</b> <?=$firstName;?> <?=$lastName;?><br>
					<br>
					<b>Phone:</b> <?=$phone;?>
				</div>
				<div class="info">
					<b>Address:</b><br>
					<?=$address;?><br>
					<?=$city;?>, <?=$state;?>, <?=$zip;?>
				</div>
			</div>
			<p><b>Email:</b> <?=$email;?></p>
			
			<p><b>Your Order Items</b></p>
			<div class="item-list">
				<div class="item heading">SKU</div>
				<div class="item heading">Name</div>
				<div class="item heading center">QTY</div>
				<div class="item heading right">Price</div>
				<?php foreach($items as $item) { ?>
					<div class="item"><?=$item['itemid'];?></div>
					<div class="item"><?=$item['name'];?>
					<?php if(isset($item['options'])) { ?>
						<ul class='options'>
							<?php foreach($item['options'] as $option) { ?>
							<li><?php echo $option; ?></li>
							<?php } ?>
						</ul>
					<?php } ?>
					</div>
					<div class="item center"><?=$item['qty'];?></div>
					<div class="item right">$ <?=money($item['total']);?></div>
				<?php } ?>
			</div>

			<p class="right"><b>Total:</b> $ <?=money($total);?></p>
		</div>
	</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/week03/view/footer.php'; ?>