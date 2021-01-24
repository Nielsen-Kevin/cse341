'use strict'

// Update carts inventory on each item change

const qtybox = document.querySelectorAll(".item-qty");

for (let i = 0; i < qtybox.length; i++) {
	qtybox[i].addEventListener("change", function() {
		let qty = qtybox[i].value;
		let id = qtybox[i].dataset.id;
		let getURL = "?act=cart-update&id=" + id + "&qty=" + qty;

		if(qty == 0){
			document.getElementById("id_" + id).outerHTML = "";
			updateTotal();
		} else {
			updateSubTotal(id, qty);
		}
		fetch(getURL) 
		.then(function (response) {
			if (response.ok) {
				return;
			} 
			throw Error("Network response was not OK");
		})
		.catch(function (error) {
			console.log('There was a problem: ', error.message);
		});

	});
}

function updateSubTotal(id, qty) {
	const item = document.getElementById("id_" + id);
	let num = item.querySelector(".price").innerHTML;
	let price = isNaN(num) ? 0.0 : parseFloat(num);
	let subTotal = price * qty;

	item.querySelector(".sub-total").innerHTML = subTotal.toFixed(2);

	updateTotal();
	updatetotalQTY();
}

function updateTotal() {
	let sum = 0.0;
	let subs = document.querySelectorAll('.sub-total');

	for (var i = 0; i < subs.length; i++) {
		let num = subs[i].innerHTML;
		sum += isNaN(num) ? 0 : parseFloat(num);
	}

	document.getElementById("total").innerHTML = sum.toFixed(2);
	document.getElementById("cart-total").innerHTML = sum.toFixed(2);
}

function updatetotalQTY() {
	let sum = 0.0;

	for (var i = 0; i < qtybox.length; i++) {
		let qty = qtybox[i].value;
		sum += isNaN(qty) ? 0 : parseInt(qty);
	}

	document.getElementById("total-qty").innerHTML = sum;
}