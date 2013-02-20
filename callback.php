<?php

require_once ('../../fileloc.php');
require_once ('../../include.php');
require_once ('/libwebtopay/WebToPay.php');

try {
	$response = WebToPay::checkResponse($_REQUEST, array(
	'projectid'     => get_site_preference('PayseraGateway_mapi_pref_prod_id'), 
	'sign_password' => get_site_preference('PayseraGateway_mapi_pref_prod_pass'),
	 ));

	$amount    = 0;
	$quantity  = 1;
	$price     = 0;
	$orderData = array();
	$db        = $gCms->GetDB();
	$config    = $gCms->GetConfig();
	$orderID   = mysql_real_escape_string($response['orderid']);
	$order     = $db->Execute("SELECT * FROM ".$config['db_prefix']."module_orders_items WHERE order_id = ".$orderID);

	while ($order && $line = $order -> FetchRow()) {
		array_push($orderData, $line);
	}

	foreach ($orderData as $key => $value) {
		foreach ($value as $k => $v) {
			if ($k == 'quantity') {
				$quantity = $v;
			}
			if ($k == 'unit_price') {
				$amount = $v;
			}
		}
		$price += $amount * $quantity;
	}

	if ($response['type'] !== 'macro') {
		throw new Exception('Only macro payment callbacks are accepted');
	}

	if ($response['status'] == '1') {
		if ($price * 100 != $response['amount']) {
			throw new Exception('Amounts do not match');
		}

		if (get_site_preference('CGEcommerceBase_mapi_pref_currency_code') != $response['currency']) {
			throw new Exception('Currencies do not match');
		}
		$db->Execute("UPDATE ".$config['db_prefix']."module_orders SET status = 'paid' WHERE id = ".$orderID);
		$db->Execute("UPDATE ".$config['db_prefix']."module_orders_payments SET payment_date = ".time().", status = 'payment_approved', amount = ".$price." WHERE order_id = ".$orderID);
	}
	exit('OK');

} catch (Exception $e) {
	$msg = get_class($e).': '.$e->getMessage();
	echo $msg;
}
?>
