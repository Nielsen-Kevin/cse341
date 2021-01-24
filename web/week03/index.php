<?php
/*
Week 03 Prove : Assignment - PHP Shopping Cart

Your assignment is to create a series of pages that simulate a shopping cart for an online store. 
The kinds of items you can put in your cart and purchase are totally up to you. But you should have at least the following components:

--Browse Items--

On the browse items page, the user sees a list of items they can add to their cart and purchase. 
Again, the kind of items and the formatting of this page is up to you.

You should provide a button or link to add an item to the cart. Doing so should store that item 
in some way to the session, and then keep the user on the browse page.

--View Cart--

Your browse page should contain a link to view the cart. On the view cart page, the user can see 
all the items that are in their cart. Provide a way to remove individual items from the cart.

The view cart page should have a link to return to the browse page for more shopping and a link 
to continue to the checkout page.

--Checkout--

The checkout page should ask the user for the different components of their address. 
(No credit card or other purchase information is collected, only an address.)

It should have the option to complete the purchase or return to the cart.

--Confirmation page--

After completing the purchase from the checkout page, the user is shown a confirmation page. 
It should display all the items they have just purchased as well as the address to which it will be shipped.

Make sure to check for malicious injection, especially from free-entry fields like the address.

----

IDEAS TO GO ABOVE AN BEYOND
- Store quantities of items, and be able to adjust them on the view cart page.
- Add a process to search, filter, and/or browse.
- On the browse page, make each item a link that goes to an "item details" page where the item is actually added to the cart.
- Add excellent styling and design to make it look really professional.
- Anything else you can think of.

*/
#----------------------------------------#
#	Shopping Cart Controller
#----------------------------------------#
session_start();
require '../config.php';
require 'functions.php';

$action = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
if ($action == NULL) {
	$action = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
}

switch ($action) {
	/*--------------------
		cart
	--------------------*/
	case 'cart':

		$items = array();
		$attribute = array();
		$total = $temp = 0;

		if(isset($_SESSION['cart'])) {
			foreach($_SESSION['cart'] as $k => $v) {

				if(is_null($v)) {
					continue;
				}
				
				$item = getRecord($items_list, $v['itemid']);

				if(!$item) {
					unset($_SESSION['cart'][$k]);
					continue;
				}

				$item['id'] = $k;
				$item['qty'] = $v['qty'];
				$temp = $v['qty'] * $item['price'];
				$item['total'] = money($temp);
				$total += $temp;
	
				if(isset($v['opt'])) {
					if(is_array($v['opt'])) {
						foreach($v['opt'] as $opt) {
							$item['options'][] = $opt;	
						}
					} else {
						$item['options'][] = $v['opt'];
					}
				}
				$items[] = $item;
			}
		}

		// Page title
		$docTitle = "Shopping Cart";
		include 'view/cart.php';
	break;

	/*--------------------
		cart add
	--------------------*/
		case 'cart-add':
			$id = filter_input(INPUT_POST, 'itemid', FILTER_SANITIZE_NUMBER_INT);
			$qty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);
			$option = filter_input(INPUT_POST, 'option', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
	
			if (isset($id) && !empty($qty)) {
				addCartItem($id, $qty, (!empty($option) ? $option : false));
			}
			// Redirect to this controller for default action
			header('Location: .');
		break;

	/*--------------------
		cart update
	--------------------*/
	case 'cart-update':
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
		$qty = filter_input(INPUT_GET, 'qty', FILTER_SANITIZE_NUMBER_INT);

		if ((!empty($id) || $id == 0) && (!empty($qty) || $qty == 0)) {
			echo 'update';
			updateCartId($id, $qty);
		}

		// Redirect to this controller for default action
		//header('Location: ?act=cart');
	break;

	/*--------------------
		cart update
	--------------------*/
	case 'cart-remove':
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		if (!empty($id) || $id == 0) {
			updateCartId($id, 0);
		}

		// Redirect to this controller for default action
		header('Location: ?act=cart');
	break;

	/*--------------------
		Checkout
	--------------------*/
	case 'checkout':
		do {
			// Check session if cart is empty
			if(empty($_SESSION['cart'])) {
				// send them back to empty cart
				header('Location: ?act=cart');
				exit;
			}

			// Check for request
			if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
				break;
			}
			// Sanitize data coming in
			$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
			$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
			$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
			$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
			$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
			$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
			$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
			$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);

			// Validation fields and check for missing data
			if(empty($firstName)) {
				$error['firstName'] = 'Please Enter First Name.';
			}
			if(empty($lastName)) {
				$error['lastName'] = 'Please Enter Last Name.';
			}
			if(empty($email)) {
				$error['email'] = 'Please Enter Email Address';
			}
			if(empty(checkEmail($email))) {
				$error['email'] = 'Email Address is invalid';
			}
			if(empty($phone)) {
				$error['phone'] = 'Please Enter Phone.';
			}
			if(empty($address)) {
				$error['address'] = 'Please Enter Address.';
			}
			if(empty($city)) {
				$error['city'] = 'Please Enter City.';
			}
			if(empty($state)) {
				$error['state'] = 'Please Enter State.';
			}
			if(empty($zip)) {
				$error['zip'] = 'Please Enter Zip.';
			}

			// Any errors break
			if(!empty($error)) {
				$message = '<p class="error">Please provide information for all invalid and empty fields.</p>';
				break;
			}

			// Send the data to seesion
			$_SESSION['invoice'] = [
				'firstName' => $firstName,
				'lastName' => $lastName,
				'email' => $email,
				'phone' => $phone,
				'address' => $address,
				'city' => $city,
				'state' => $state,
				'zip' => $zip
			];

			// Forward to confirmation
			header('Location: ?act=confirmation');
			exit;
		} while (false);

		// Page title
		$docTitle = "Checkout";
		include 'view/checkout.php';
	break;

	/*--------------------
		Confirmation
	--------------------*/
	case 'confirmation':
		// Check session has order address
		if(empty($_SESSION['invoice'])) {
			// send them back to checkout
			header('Location: ?act=checkout');
			exit;
		}

		// out puts all values
		extract($_SESSION['invoice']);

		$invoiceNumber = rand(100000, 999999);
		$invoiceDate = date('m/d/Y');
		$items = array();
		$attribute = array();
		$total = $temp = 0;

		//Get the items in the cart
		foreach($_SESSION['cart'] as $k => $v) {

			if(is_null($v)) {
				continue;
			}

			$item = getRecord($items_list, $v['itemid']);

			if(!$item) {
				continue;
			}

			$item['id'] = $k;
			$item['qty'] = $v['qty'];
			$temp = $v['qty'] * $item['price'];
			$item['total'] = money($temp);
			$total += $temp;

			//Format options
			if(isset($v['opt'])) {
				if(is_array($v['opt'])) {
					foreach($v['opt'] as $opt) {
						$item['options'][] = $opt;	
					}
				} else {
					$item['options'][] = $v['opt'];
				}
			}
			$items[] = $item;
		}

		// Empty Cart
		unset($_SESSION['cart']);
		unset($_SESSION['invoice']);
		//session_destroy();

		// Page title
		$docTitle = "Order Confirmation";
		include 'view/confirmation.php';
	break;

	/*--------------------
		default
	--------------------*/
	default:
		// Page title
		$docTitle = "Product List";
		include 'view/items.php';
}

?>