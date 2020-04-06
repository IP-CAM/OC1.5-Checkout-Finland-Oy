<?php
/********************************************************
*	CHECKOUT FINLAND PAYMENT METHOD						*
*	Version:	2.0.0									*
*	Date:		01.12.2019								*
*	File:		catalog/controller/payment/checkout.php	*
*	Author:		HydeNet									*
*	Web:		www.hydenet.fi							*
*	Email:		info@hydenet.fi							*
********************************************************/

class ControllerPaymentCheckout extends Controller {
	protected function index() {
		$this->language->load('payment/checkout');

		$this->data['text_testmode'] = $this->language->get('text_testmode');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['testmode'] = $this->config->get('checkout_test');

		if (!$this->config->get('checkout_test')) {
			$this->data['action'] = 'https://api.checkout.fi';
			$merchant_id = $this->config->get('checkout_merchant'); // Myyjän tunniste
			$secret_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
		} else {
			$this->data['action'] = 'https://api.checkout.fi';
			$merchant_id = 375917; // Myyjän tunniste
			$secret_key = 'SAIPPUAKAUPPIAS'; // Turva-avain
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$testdata = print_r($order_info, true);
			file_put_contents(DIR_LOGS . "checkout/orderinfo.txt", $testdata);

			$testdata = print_r($this->session->data, true);
			file_put_contents(DIR_LOGS . "checkout/session_data.txt", $testdata);

			$delivery_date = date('Y-m-d');

			$stamp = $order_info['order_id'] . '-' . strtotime($order_info['date_added']);

			$tilausnumero = $this->session->data['order_id'];
			if( $tilausnumero < 10 ) {
				$tilausnumero *= 1000;
			}
			elseif( $tilausnumero < 100 ) {
				$tilausnumero *= 100;
			}
			elseif( $tilausnumero < 1000 ) {
				$tilausnumero *= 10;
			}
				$kertoimet = array(7,3,1);
				$pituus = strlen($tilausnumero);
				$summa = 0;
				$viite = str_split($tilausnumero);
			for ($i = $pituus - 1; $i >= 0; --$i) {
				$summa += $viite[$i] * $kertoimet[($pituus - 1 - $i) % 3];
			}
			$tarkiste = (10 - $summa % 10) % 10;
			$fiviite = $tilausnumero . $tarkiste;

			if (strtolower($this->session->data['language']) == 'fi') { // Maksun kieli suomi
				$message = substr($this->config->get('checkout_message_fi'), 0, 512);
				$language = 'FI';
			} elseif (strtolower($this->session->data['language']) == 'se') { // Maksun kieli ruotsi
				$message = substr($this->config->get('checkout_message_se'), 0, 512);
				$language = 'SE';
			} else { // Maksun kieli englanti
				$message = substr($this->config->get('checkout_message_en'), 0, 512);
				$language = 'EN';
			}

			$items = array();
			$total_amount = 0;

			// Order Products
			if ($this->config->get('checkout_content') == 1) { // 1 = tilaus eriteltynä (riveittäin)
				if (isset($this->session->data['coupon'])) {
					$this->load->model('checkout/coupon');
					$coupon_info = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);
					if ($coupon_info) {
						$discount_total = 0;

						if (!$coupon_info['product']) {
							$sub_total = $this->cart->getSubTotal();
						} else {
							$sub_total = 0;

							foreach ($this->cart->getProducts() as $product) {
								if (in_array($product['product_id'], $coupon_info['product'])) {
									$sub_total += $product['total'];
								}
							}					
						}

						if ($coupon_info['type'] == 'F') {
							$coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
						}
					} // end if coupon_info
				} // end if coupon

				foreach ($this->cart->getProducts() as $product) {
					if ($coupon_info) {
						$discount = 0;

						if (!$coupon_info['product']) {
							$status = true;
						} else {
							if (in_array($product['product_id'], $coupon_info['product'])) {
								$status = true;
							} else {
								$status = false;
							}
						}

						if ($status) {
							if ($coupon_info['type'] == 'F') { // Fixed amount
								$discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
								$product_discount_price = ($product['total'] - $discount) / $product['quantity'];
								echo $product_discount_price . ' ';
								$unit_price = $this->eurosToCents($this->tax->calculate($product_discount_price, $product['tax_class_id'], true));
								//$unit_price = 100 * number_format($this->tax->calculate($product_discount_price, $product['tax_class_id'], true), 2, '.', '');
							} elseif ($coupon_info['type'] == 'P') { // Percentage
								$discount = $product['total'] / 100 * $coupon_info['discount'];
								$product_discount_price = ($product['total'] - $discount) / $product['quantity'];
								$unit_price = $this->eurosToCents($this->tax->calculate($product_discount_price, $product['tax_class_id'], true));
							}
						} else {
							$unit_price = $this->eurosToCents($this->tax->calculate($product['price'], $product['tax_class_id'], true));
						}
					} else {
						$unit_price = $this->eurosToCents($this->tax->calculate($product['price'], $product['tax_class_id'], true));
					}

					$tax_rate = $this->tax->getTax(100, $product['tax_class_id']);

					$items[] = array(
						'unitPrice' => $unit_price,
						'units' => $product['quantity'],
						'vatPercentage' => $tax_rate,
						'productCode' => $product['model'],
						'deliveryDate' => $delivery_date,
						'description' => $product['name'],
					);

					$total_amount += $unit_price * $product['quantity'];
				} // end foreach products

				// Order Vouchers
				if (!empty($this->session->data['vouchers'])) {
					foreach ($this->session->data['vouchers'] as $voucher) {
						$unit_price = $this->eurosToCents($voucher['amount']); // Euro sentteinä
						$items[] = array(
							'unitPrice' => $unit_price,
							'units' => 1,
							'vatPercentage' => 0,
							'productCode' => 'vouch',
							'deliveryDate' => $delivery_date,
							'description' => $voucher['description'],
						);

						$total_amount += $unit_price;
					} // end foreach vouchers
				} // end if vouchers

				// Order Totals
				$total = 0;
				$taxes = $this->cart->getTaxes();
				$this->load->model('setting/extension');
				$total_data = array();
				$results = $this->model_setting_extension->getExtensions('total');

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$testdata = print_r($total_data, true);
				file_put_contents(DIR_LOGS . "checkout/orderinfo.txt", $testdata, FILE_APPEND);

				foreach ($total_data as $total) {
					if ($total['code'] == 'shipping') {
						$tax_class = $this->session->data['shipping_method']['tax_class_id'];
						$tax_rate = $this->tax->getTax(100, $tax_class);
						$unit_price = $this->eurosToCents($this->tax->calculate($total['value'], $tax_class, true));

						$items[] = array(
							'unitPrice' => $unit_price,
							'units' => 1,
							'vatPercentage' => $tax_rate,
							'productCode' => $total['title'],
							'deliveryDate' => $delivery_date,
							'description' => $total['title'],
						);
						$total_amount += $unit_price;
					};

					if ($total['code'] == 'low_order_fee' || $total['code'] == 'handling') {
						$tax_class = $this->config->get($total['code'] . '_tax_class_id');
						$tax_rate = $this->tax->getTax(100, $tax_class);
						$unit_price = $this->eurosToCents($this->tax->calculate($total['value'], $tax_class, true));

						$items[] = array(
							'unitPrice' => $unit_price,
							'units' => 1,
							'vatPercentage' => $tax_rate,
							'productCode' => $total['title'],
							'deliveryDate' => $delivery_date,
							'description' => $total['title'],
						);
						$total_amount += $unit_price;
					};

					if ($total['code'] == 'reward' || $total['code'] == 'credit' || /* $total['code'] == 'coupon' || */ $total['code'] == 'voucher') {
						$tax_class = $this->session->data['shipping_method']['tax_class_id'];
						$tax_rate = $this->tax->getTax(100, $tax_class);
						$unit_price = -1 * abs(100 * number_format($total['value'], 2, '.', ''));

						$items[] = array(
							'unitPrice' => $unit_price,
							'units' => 1,
							'vatPercentage' => 0,
							'productCode' => $total['code'],
							'deliveryDate' => $delivery_date,
							'description' => $total['title'],
						);
						$total_amount += $unit_price;
					};

				}; // end Order Totals
			} else { // Tilaus erittelemättä
				$order_amount = $this->eurosToCents($order_info['total']);
				$items[] = array(
					'unitPrice' => $order_amount,
					'units' => 1,
					'vatPercentage' => 24,
					'productCode' => $fiviite,
					'deliveryDate' => $delivery_date,
					'description' => sprintf($this->language->get('text_order_description'), $order_info['order_id'], $order_info['store_name']),
				);

				$total_amount = $order_amount;
			} // end order products

			$customer = array(
				'email'     => $order_info['email'],
				'firstName' => $order_info['payment_firstname'],
				'lastName'  => $order_info['payment_lastname'],
				'phone'     => $order_info['telephone'],
				'vatId'     => $order_info['payment_tax_id']
			);

			$delivery_address = array(
				'streetAddress' => $order_info['shipping_address_1'],
				'postalCode'    => $order_info['shipping_postcode'],
				'city'          => $order_info['shipping_city'],
				'county'        => $order_info['shipping_zone'],
				'country'       => $order_info['shipping_iso_code_2']
			);

			$invoicing_address = array(
				'streetAddress' => $order_info['payment_address_1'],
				'postalCode'    => $order_info['payment_postcode'],
				'city'          => $order_info['payment_city'],
				//'county'        => $order_info['payment_zone'],
				'country'       => $order_info['payment_iso_code_2']
			);

			$redirect_urls = array(
				'success' => $this->url->link('payment/checkout/callback', '', 'SSL'),
				'cancel'  => $this->url->link('payment/checkout/canceled', '', 'SSL')
			);

			$callback_urls = array(
				'success' => $this->url->link('payment/checkout/callback', '', 'SSL'),
				'cancel'  => $this->url->link('payment/checkout/canceled', '', 'SSL')
			);

			$checkout_request = array(
				'stamp'            => $stamp,
				'reference'        => $fiviite,
				'amount'           => $total_amount,
				'currency'         => 'EUR',
				'language'         => $language,
				'orderId'          => $order_info['order_id'],
				'items'            => $items,
				'customer'         => $customer,
				'deliveryAddress'  => $delivery_address,
				'invoicingAddress' => $invoicing_address,
				'redirectUrls'     => $redirect_urls,
				//'callbackUrls'     => $callback_urls,
			);

			$json_request = json_encode($checkout_request, JSON_UNESCAPED_SLASHES);

			$checkout_headers = [
				'checkout-account' => $merchant_id,
				'checkout-algorithm' => 'sha256',
				'checkout-method' => 'POST',
				'checkout-nonce' => time(),
				'checkout-timestamp' => date('c'),
				'content-type' => 'application/json; charset=utf-8'
			];

			$checkout_headers['signature'] = $this->calculateHmac($secret_key, $checkout_headers, $json_request);

			$headers = array();
			foreach ($checkout_headers as $key => $value) {
				$headers[] = $key . ':' . $value;
			}

			$request_json = json_encode($checkout_request, JSON_PRETTY_PRINT);
			$headers_json = print_r($headers, TRUE);
			file_put_contents(DIR_LOGS . "checkout/request.txt", "Headers:\n{$headers_json}\n\nRequest:\n{$request_json}");


			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,'https://api.checkout.fi/payments'); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$res = urldecode(curl_exec($ch));
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

			$curlError = $httpCode > 0 ? null : curl_error($ch).' ('.curl_errno($ch).')';

			// Return headers seperatly from the Response Body
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = substr($res, 0, $header_size);
			$res_body = substr($res, $header_size);

			curl_close($ch);

			//$headers = explode("\r\n", $headers); // The seperator used in the Response Header is CRLF (Aka. \r\n) 
			//$headers = print_r(array_filter($headers), TRUE);
			file_put_contents(DIR_LOGS . "checkout/headers.txt", "Headers:\n{$headers}\n\nFull Response:\n{$res}");

			if ($curlError) {
				$aika = date("Y-m-d H:i:s");
				file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika}\nConnection failure. Please check that api.checkout.fi is reachable from your environment({$curlError})\n", FILE_APPEND);
				$this->data['text_error'] = $this->language->get('text_connection_failure');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
				} else {
					$this->template = 'default/template/payment/checkout_error.tpl';
				}

			} elseif ($httpCode != 201) {

				switch ($httpCode) {
					case "200":
						$http_message = 'Code: 200 OK = Everything worked as expected.';
						break;
					case "400":
						$http_message = 'Code: 400 Bad Reguest = The request was unacceptable, probably due to missing a required parameter.';
						break;
					case "401":
						$http_message = 'Code: 401 Unauthorized = HMAC calculation failed or Merchant has no access to this feature.';
						break;
					case "404":
						$http_message = 'Code: 404 Not Found = The requested resource doesn\'t exist.';
						break;
					case "422":
						$http_message = 'Code: 422 Unprocessable Entity = The requested method is not supported.';
						break;
					default:
						$http_message = 'Code: ' . $httpCode . ' Undefined error';
				}

				$aika = date("Y-m-d H:i:s");
				file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika}\n{$http_message}\n", FILE_APPEND);
				$this->data['text_error'] = $this->language->get('text_error_payment_creation');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
				} else {
					$this->template = 'default/template/payment/checkout_error.tpl';
				}

			} else {
				$response_json = json_encode(json_decode($res_body), JSON_PRETTY_PRINT);
				file_put_contents(DIR_LOGS . "checkout/response.txt", "HTTP code: {$httpCode}\nContent type: {$contentType}\n\n{$response_json}");

				$this->data['checkout_providers'] = $res_body;
				$this->data['text_checkout_title'] = $this->language->get('text_checkout_title');
				$this->data['text_checkout_info'] = $this->language->get('text_checkout_info');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/payment/checkout.tpl';
				} else {
					$this->template = 'default/template/payment/checkout.tpl';
				}

				$this->render();

			}

		} // end if order_info
	} // end index

	private function calculateHmac($secret, $params, $body = '') {
		// Keep only checkout- params, more relevant for response validation. Filter query
		// string parameters the same way - the signature includes only checkout- values.
		$includedKeys = array_filter(array_keys($params), function ($key) {
			return preg_match('/^checkout-/', $key);
		});

		// Keys must be sorted alphabetically
		sort($includedKeys, SORT_STRING);

		$hmacPayload =
			array_map(
				function ($key) use ($params) {
					return join(':', [ $key, $params[$key] ]);
				},
				$includedKeys
			);

		array_push($hmacPayload, $body);

		return hash_hmac('sha256', join("\n", $hmacPayload), $secret);
	} // end calculateHmac

	public function callback() {
		$this->language->load('payment/checkout');

		if (!$this->config->get('checkout_test')) {
			$this->data['action'] = 'https://api.checkout.fi';
			$merchant_id = $this->config->get('checkout_merchant'); // Myyjän tunniste
			$secret_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
		} else {
			$this->data['action'] = 'https://api.checkout.fi';
			$merchant_id = 375917; // Myyjän tunniste
			$secret_key = 'SAIPPUAKAUPPIAS'; // Turva-avain
		}

		// Ladataan paluuarvot
		$return_headers = [
			'checkout-account'        => $this->request->get['checkout-account'], // Checkout account ID
			'checkout-algorithm'      => $this->request->get['checkout-algorithm'], // Used signature algorithm
			'checkout-amount'         => $this->request->get['checkout-amount'], // Payment amount
			'checkout-stamp'          => $this->request->get['checkout-stamp'], // Merchant provided stamp
			'checkout-reference'      => $this->request->get['checkout-reference'], // Merchant provided reference
			'checkout-transaction-id' => $this->request->get['checkout-transaction-id'], // Checkout provided transaction ID
			'checkout-status'         => $this->request->get['checkout-status'], // Payment status
			'checkout-provider'       => $this->request->get['checkout-provider'], // The payment method provider
		];
		$return_signature = $this->request->get['signature']; // HMAC signature

		$stamp = explode('-', $return_headers['checkout-stamp']);
		$order_id = $stamp[0];

		// Lasketaan tarkiste paluuarvoista
		$calculated_signature = $this->calculateHmac($secret_key, $return_headers);

		if($calculated_signature === $return_signature) { // Tarkistussumma oikein
			if($this->config->get('checkout_debug')) {
				$aika = date("Y-m-d H:i:s");
				$viesti = $this->language->get('text_success');
				$getdata = print_r($this->request->get, true);
				file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika} {$viesti}\n{$getdata}\n", FILE_APPEND);
			}

			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($order_id);

			$order_payment_data = [
				'order_id'       => $order_id,
				'stamp'          => $return_headers['checkout-stamp'],
				'reference'      => $return_headers['checkout-reference'],
				'transaction_id' => $return_headers['checkout-transaction-id'],
				'provider'       => $return_headers['checkout-provider'],
				'status'         => $return_headers['checkout-status'],
			];

			if(!$order_info['order_status_id']) { // Vahvistamaton (uusi) tilaus
				$this->load->model('payment/checkout');
				$this->model_payment_checkout->addOrderPaymentData($order_id, $order_payment_data);

				if($return_headers['checkout-status'] == 'ok') { // Onnistunut maksu
					$comment = $this->language->get('text_ok');
					$this->model_checkout_order->confirm($order_id, $this->config->get('checkout_ok_status_id'), $comment, false);
					// $order_id, $order_status_id, $comment = '', $notify = false
				} elseif ($return_headers['checkout-status'] == 'fail') { // Epäonnistunut maksu
					$comment = $this->language->get('text_fail');
					$this->redirect($this->url->link('payment/checkout/canceled'));
				} elseif ($return_headers['checkout-status'] == 'pending') { // Odottava maksu
					$this->model_payment_checkout->changeOrderStatus($order_id, $this->config->get('checkout_pending_status_id'));
					$comment = $this->language->get('text_pending');
					$this->model_payment_checkout->addOrderHistory($order_id, $this->config->get('checkout_pending_status_id'), $comment, $notify);
				} elseif ($return_headers['checkout-status'] == 'delayed') { // Viivästetty maksu
					$this->model_payment_checkout->changeOrderStatus($order_id, $this->config->get('checkout_delayed_status_id'));
					$comment = $this->language->get('text_delayed');
					$this->model_payment_checkout->addOrderHistory($order_id, $this->config->get('checkout_delayed_status_id'), $comment, $notify);
				} else { // Tuntematon tila
					$this->model_payment_checkout->changeOrderStatus($order_id, 0);
					// Send email to admin
				}

				$this->redirect($this->url->link('checkout/success')); 

			} else { // Vahvistettu tilaus (Callback)
				$this->load->model('payment/checkout');
				if($order_info['order_status_id'] != $this->config->get('checkout_ok_status_id')) {
					$this->model_payment_checkout->changeOrderStatus($order_id, 0);
					if($return_headers['checkout-status'] == 'ok') { // Onnistunut maksu
						$comment = $this->language->get('text_ok');
						$this->model_checkout_order->confirm($order_id, $this->config->get('checkout_ok_status_id'), $comment, false);
					} elseif ($return_headers['checkout-status'] == 'fail') { // Epäonnistunut maksu
						$this->model_payment_checkout->changeOrderStatus($order_id, 0);
					} elseif ($return_headers['checkout-status'] == 'pending') { // Odottava maksu
						$this->model_payment_checkout->changeOrderStatus($order_id, $this->config->get('checkout_pending_status_id'));
					} elseif ($return_headers['checkout-status'] == 'delayed') { // Viivästetty maksu
						$this->model_payment_checkout->changeOrderStatus($order_id, $this->config->get('checkout_delayed_status_id'));
					} else { // Tuntematon tila
						$this->model_payment_checkout->changeOrderStatus($order_id, 0);
						// Send email to admin
					}
				}
				$this->model_payment_checkout->updateOrderPaymentData($order_id, $order_payment_data);
			}

			$this->redirect($this->url->link('checkout/success'));

		} else { // Tarkistussumma ei täsmää
			if($this->config->get('checkout_debug')) {
				$aika = date("Y-m-d H:i:s");
				$viesti = $this->language->get('return_error');
				$getdata = print_r($this->request->get, true);
				file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika} {$viesti}\n{$getdata}\n\n", FILE_APPEND);
			}

			if($this->config->get('checkout_log')) {
				file_put_contents(DIR_LOGS . "checkout/checkout.log", date("Y-m-d H:i:s") . " " . $this->language->get('return_error') . " "  . $this->language->get('text_order_number') . $order_id . " "  . $this->language->get('text_payment_status') . $return_headers['checkout-status'] . "\n", FILE_APPEND);
			}

			if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
					$this->data['base'] = $this->config->get('config_url');
			} else {
					$this->data['base'] = $this->config->get('config_ssl');
			}

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['return_error'] = $this->language->get('return_error');
			$this->data['error_description'] = sprintf($this->language->get('error_description'), $this->language->get('button_continue'));

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('information/contact');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
				} else {
					$this->template = 'default/template/payment/checkout_error.tpl';
				}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		}
	} // end callback

	public function canceled() {
		$this->language->load('payment/checkout');

		// Ladataan paluuarvot
		$return_headers = [
			'checkout-account'        => $this->request->get['checkout-account'], // Checkout account ID
			'checkout-algorithm'      => $this->request->get['checkout-algorithm'], // Used signature algorithm
			'checkout-amount'         => $this->request->get['checkout-amount'], // Payment amount
			'checkout-stamp'          => $this->request->get['checkout-stamp'], // Merchant provided stamp
			'checkout-reference'      => $this->request->get['checkout-reference'], // Merchant provided reference
			'checkout-transaction-id' => $this->request->get['checkout-transaction-id'], // Checkout provided transaction ID
			'checkout-status'         => $this->request->get['checkout-status'], // Payment status
			'checkout-provider'       => $this->request->get['checkout-provider'], // The payment method provider
		];
		$return_signature = $this->request->get['signature']; // HMAC signature

		$stamp = explode('-', $return_headers['checkout-stamp']);
		$order_id = $stamp[0];

		if($this->config->get('checkout_debug')) {
			$aika = date("Y-m-d H:i:s");
			$viesti = $this->language->get('text_error_canceled');
			$getdata = print_r($this->request->get, true);
			file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika} {$viesti}\n{$getdata}\n", FILE_APPEND);
		}

		if($this->config->get('checkout_log')) {
			file_put_contents(DIR_LOGS . "checkout/checkout.log", date("Y-m-d H:i:s") . " " . $this->language->get('text_error_canceled') . " " . $this->language->get('text_order_number') . $order_id . "\n", FILE_APPEND);
		}

		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
			$this->data['base'] = $this->config->get('config_url');
		} else {
			$this->data['base'] = $this->config->get('config_ssl');
		}

		$this->document->setTitle($this->language->get('heading_title_canceled'));

		$this->data['heading_title'] = $this->language->get('heading_title_canceled');

		$this->data['return_error'] = $this->language->get('return_error_canceled');
		$this->data['error_description'] = sprintf($this->language->get('error_description_canceled'), $this->language->get('button_continue'));

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('checkout/checkout');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/checkout_error.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/checkout_error.tpl';
		} else {
			$this->template = 'default/template/payment/checkout_error.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	} // end canceled

	private function eurosToCents($value) {
		return intval(strval(floatval(number_format($value, 2, '.', '')) * 100));
	}

}
?>