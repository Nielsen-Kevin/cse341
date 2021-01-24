<?php
/*--------------------
	Items
--------------------*/

$items_list = [
	['itemid' => 2882, 'price' => 34.98, 'name' => 'Item1', 'description' => ''],
	['itemid' => 1234, 'price' => 99.98, 'name' => 'Item2', 'description' => ''],
	['itemid' => 987, 'price' => 0.50, 'name' => 'Item3', 'description' => ''],
	['itemid' => 2882, 'price' => 55.55, 'name' => 'Item1 with option', 'description' => 'Imprint your name on the front.', 'attribute' => ['Your Name'], 'type' => 'text'],
	['itemid' => 1234, 'price' => 100.00, 'name' => 'Item2 with option', 'description' => '', 'attribute' => ['RED','BLUE'], 'type' => 'checkbox'],
	['itemid' => 987, 'price' => 1.00, 'name' => 'Item3 with option', 'description' => 'Choose your color', 'attribute' => ['RED','BLUE'], 'type' => 'radio']
];

function getRecord($array, $id) {
	$indexOfIds = array_column($array, 'itemid');
	$index = array_search($id, $indexOfIds);
	return $array[$index];
}

/*--------------------
	Cart Functions
--------------------*/

function money($number) {
	return number_format($number, 2, '.', '');
}

function addCartItem($itemid, $qty = 1, $option = false) {
	if(!empty($_SESSION['cart'])) {
		
		foreach($_SESSION['cart'] as $id => $item) {
			if($item['itemid'] == $itemid) {
				// Found and check options
				$opt1 = $opt2 = '';
				if($option) {
					$opt1 = json_encode($option);
				}
				if(isset($item['opt'])) {
					$opt2 = json_encode($item['opt']);
				}
				if($opt1 == $opt2) {
					// Update
					$_SESSION['cart'][$id]['qty'] = (int)$_SESSION['cart'][$id]['qty'] + (int)$qty;
					// Found and exit
					return;
				}
			}
		}
	}
	if($option) {
		// Add new with option
		$_SESSION['cart'][] = array(
			'itemid' => $itemid,
			'qty' => $qty,
			'opt' => $option
		);
	} else {
		// Add new
		$_SESSION['cart'][] = array(
			'itemid' => $itemid,
			'qty' => $qty
		);
	}
}

function updateCartId($cartid, $qty = 0) {
	if ($qty <= 0) {
		unset($_SESSION['cart'][$cartid]);
	} else {
		$_SESSION['cart'][$cartid]['qty'] = (int)$qty;
	}
}

function checkcart() {
	global $items_list;
	$data = ['qty' => 0, 'total' => 0];

	if(!empty($_SESSION['cart'])) {
		foreach($_SESSION['cart'] as $k => $v) {

			if(is_null($v)) {
				continue;
			}
			
			$item = getRecord($items_list, $v['itemid']);
			if(!$item) {
				continue;
			}

			$data['qty'] += $v['qty'];
			$data['total'] += $v['qty'] * $item['price'];
		}
	}
	return $data;
}

/*--------------------
	Field Validation
--------------------*/

// Check for valid email address
// Returns empty if invalided
function checkEmail($clientEmail) {
	$valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
	return $valEmail;
}

// Check multidimensional array but associative key for if value is found in array
// Returns empty or value
function inNested($value, $array, $column) {
	if( in_array($value, array_column($array, $column)) ) {
		return $value;
	}
	return NULL;
}

/*--------------------
	Debugging
--------------------*/

// Team10 custom function to printing out data for testing
function print_e() {
	echo '<pre style=background-color: #fdfdfd;=>';
	$numargs = func_num_args();
	$arg_list = func_get_args();
	for ($i = 0; $i < $numargs; $i++) {
		print_r( $arg_list[$i] );
		echo "\n";
	}
	echo '</pre>';
}