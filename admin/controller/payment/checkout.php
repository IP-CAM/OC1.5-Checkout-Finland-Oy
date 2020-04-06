<?php
/********************************************************
*	CHECKOUT FINLAND PAYMENT METHOD						*
*	Version:	2.0.0									*
*	Date:		01.12.2019								*
*	File:		admin/controller/payment/checkout.php	*
*	Author:		HydeNet									*
*	Web:		www.hydenet.fi							*
*	Email:		info@hydenet.fi							*
********************************************************/

class ControllerPaymentCheckout extends Controller {
	private $error = array();
	private $checkoutversion = '2.0.0';

	public function index() {
		define("CHECKOUTVERSION", '2.0.0'); // DO NOT EDIT THIS!!!
		$this->load->language('payment/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('checkout', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_device_html'] = $this->language->get('text_device_html');
		$this->data['text_device_xml'] = $this->language->get('text_device_xml');
		$this->data['text_info'] = $this->checkoutversion;
		$this->data['text_no_file'] = $this->language->get('text_no_file');

		$this->data['entry_merchant'] = $this->language->get('entry_merchant');
		$this->data['entry_safety_key'] = $this->language->get('entry_safety_key');
		$this->data['entry_message'] = $this->language->get('entry_message');
		$this->data['entry_message_fi'] = $this->language->get('entry_message_fi');
		$this->data['entry_message_se'] = $this->language->get('entry_message_se');
		$this->data['entry_message_en'] = $this->language->get('entry_message_en');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_device'] = $this->language->get('entry_device');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_debug_contents'] = $this->language->get('entry_debug_contents');
		$this->data['entry_log'] = $this->language->get('entry_log');
		$this->data['entry_log_contents'] = $this->language->get('entry_log_contents');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_ok_status'] = $this->language->get('entry_ok_status');
		$this->data['entry_delayed_status'] = $this->language->get('entry_delayed_status');
		$this->data['entry_unknown_status'] = $this->language->get('entry_unknown_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_log'] = $this->language->get('tab_log');
		$this->data['tab_info'] = $this->language->get('tab_info');

		$this->data['button_clear_log'] = $this->language->get('button_clear_log');
		$this->data['button_clear_debug'] = $this->language->get('button_clear_debug');
		$this->data['button_list_providers'] = $this->language->get('button_list_providers');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['merchant'])) {
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}

 		if (isset($this->error['safety_key'])) {
			$this->data['error_safety_key'] = $this->error['safety_key'];
		} else {
			$this->data['error_safety_key'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['checkout_merchant'])) {
			$this->data['checkout_merchant'] = $this->request->post['checkout_merchant'];
		} else {
			$this->data['checkout_merchant'] = $this->config->get('checkout_merchant');
		}

		if (isset($this->request->post['checkout_safety_key'])) {
			$this->data['checkout_safety_key'] = $this->request->post['checkout_safety_key'];
		} else {
			$this->data['checkout_safety_key'] = $this->config->get('checkout_safety_key');
		}

		if (isset($this->request->post['checkout_message_fi'])) {
			$this->data['checkout_message_fi'] = $this->request->post['checkout_message_fi'];
		} else {
			$this->data['checkout_message_fi'] = $this->config->get('checkout_message_fi');
		}

		if (isset($this->request->post['checkout_message_se'])) {
			$this->data['checkout_message_se'] = $this->request->post['checkout_message_se'];
		} else {
			$this->data['checkout_message_se'] = $this->config->get('checkout_message_se');
		}

		if (isset($this->request->post['checkout_message_en'])) {
			$this->data['checkout_message_en'] = $this->request->post['checkout_message_en'];
		} else {
			$this->data['checkout_message_en'] = $this->config->get('checkout_message_en');
		}

		if (isset($this->request->post['checkout_test'])) {
			$this->data['checkout_test'] = $this->request->post['checkout_test'];
		} else {
			$this->data['checkout_test'] = $this->config->get('checkout_test');
		}

		if (isset($this->request->post['checkout_debug'])) {
			$this->data['checkout_debug'] = $this->request->post['checkout_debug'];
		} else {
			$this->data['checkout_debug'] = $this->config->get('checkout_debug');
		}

		if (isset($this->request->post['checkout_log'])) {
			$this->data['checkout_log'] = $this->request->post['checkout_log'];
		} else {
			$this->data['checkout_log'] = $this->config->get('checkout_log');
		}

		if (isset($this->request->post['checkout_content'])) {
			$this->data['checkout_content'] = $this->request->post['checkout_content'];
		} elseif ($this->config->has('checkout_content')) {
			$this->data['checkout_content'] = $this->config->get('checkout_content');
		} else {
			$this->data['checkout_content'] = '2'; // 2 = order
		}

		if (isset($this->request->post['checkout_device'])) {
			$this->data['checkout_device'] = $this->request->post['checkout_device'];
		} elseif ($this->config->has('checkout_device')) {
			$this->data['checkout_device'] = $this->config->get('checkout_device');
		} else {
			$this->data['checkout_device'] = '10';
		}

		if (isset($this->request->post['checkout_total'])) {
			$this->data['checkout_total'] = $this->request->post['checkout_total'];
		} else {
			$this->data['checkout_total'] = $this->config->get('checkout_total'); 
		} 

		if (isset($this->request->post['checkout_ok_status_id'])) {
			$this->data['checkout_ok_status_id'] = $this->request->post['checkout_ok_status_id'];
		} else {
			$this->data['checkout_ok_status_id'] = $this->config->get('checkout_ok_status_id');
		}

		if (isset($this->request->post['checkout_delayed_status_id'])) {
			$this->data['checkout_delayed_status_id'] = $this->request->post['checkout_delayed_status_id'];
		} else {
			$this->data['checkout_delayed_status_id'] = $this->config->get('checkout_delayed_status_id');
		}

		if (isset($this->request->post['checkout_unknown_status_id'])) {
			$this->data['checkout_unknown_status_id'] = $this->request->post['checkout_unknown_status_id'];
		} else {
			$this->data['checkout_unknown_status_id'] = $this->config->get('checkout_unknown_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['checkout_geo_zone_id'])) {
			$this->data['checkout_geo_zone_id'] = $this->request->post['checkout_geo_zone_id'];
		} else {
			$this->data['checkout_geo_zone_id'] = $this->config->get('checkout_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['checkout_status'])) {
			$this->data['checkout_status'] = $this->request->post['checkout_status'];
		} else {
			$this->data['checkout_status'] = $this->config->get('checkout_status');
		}

		if (isset($this->request->post['checkout_sort_order'])) {
			$this->data['checkout_sort_order'] = $this->request->post['checkout_sort_order'];
		} else {
			$this->data['checkout_sort_order'] = $this->config->get('checkout_sort_order');
		}

		$file = DIR_LOGS . "checkout/checkout.log";
		if (file_exists($file)) {
			$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			$this->data['log_file'] = $file;
		} else {
			$this->data['log'] = '';
			$this->data['log_file'] = $this->language->get('text_no_file');
		}
		$this->data['clear_log'] = $this->url->link('payment/checkout/clear_log', 'token=' . $this->session->data['token'], 'SSL');

		$file = DIR_LOGS . "checkout/checkout.txt";
		if (file_exists($file)) {
			$this->data['debug'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			$this->data['debug_file'] = $file;
		} else {
			$this->data['debug'] = '';
			$this->data['debug_file'] = $this->language->get('text_no_file');
		}
		$this->data['clear_debug'] = $this->url->link('payment/checkout/clear_debug', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'payment/checkout.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('payment/checkout');
		$this->model_payment_checkout->install();

		if (!file_exists(DIR_LOGS . "checkout")) {
			mkdir(DIR_LOGS . "checkout", 0777, true);
		}
	}

	public function uninstall() {
		$this->load->model('payment/checkout');
		$this->model_payment_checkout->uninstall();

		$path = DIR_LOGS . "checkout";
		$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? removeDirectory($file) : unlink($file);
		}
		rmdir($path);
	}

	public function clear_log() {
		$this->load->language('payment/checkout');

		$file = DIR_LOGS . "checkout/checkout.log";

		$handle = fopen($file, 'w+'); 

		fclose($handle);

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function clear_debug() {
		$this->load->language('payment/checkout');

		$file = DIR_LOGS . "checkout/checkout.txt";

		$handle = fopen($file, 'w+'); 

		fclose($handle);

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('payment/checkout', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function paymentStatus() {
		$this->load->language('payment/checkout');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission'); 
		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');
			$this->load->model('payment/checkout');

			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
			$payment_info = $this->model_payment_checkout->getOrderPaymentData($this->request->get['order_id']);

			if ($payment_info) {
				if (!$this->config->get('checkout_test')) {
					$merchant_id = $this->config->get('checkout_merchant'); // Myyjän tunniste
					$secret_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
					$endpoint = 'https://api.checkout.fi/payments/' . $payment_info['transaction_id'];
				} else {
					$merchant_id = 375917; // Myyjän tunniste
					$secret_key = 'SAIPPUAKAUPPIAS'; // Turva-avain
					$endpoint = 'https://api.checkout.fi/payments/' . $payment_info['transaction_id'];
				}

				$checkout_headers = [
					'checkout-account' => $merchant_id,
					'checkout-algorithm' => 'sha256',
					'checkout-method' => 'GET',
					'checkout-nonce' => time(),
					'checkout-timestamp' => date('c'),
					'checkout-method' => 'GET',
					'checkout-transaction-id' => $payment_info['transaction_id'],
					'cof-plugin-version' => 'OpenCart ' . VERSION . ' / HydeNet ' . $this->checkoutversion
				];

				$checkout_headers['signature'] = $this->calculateHmac($secret_key, $checkout_headers);

				$headers = array();
				foreach ($checkout_headers as $key => $value) {
					$headers[] = $key . ':' . $value;
				}

				//$request_json = json_encode($checkout_request, JSON_PRETTY_PRINT);
				$headers_json = print_r($headers, TRUE);
				file_put_contents(DIR_LOGS . "checkout/adm_request.txt", "Headers:\n{$headers_json}\n\nRequest URL:\n{$endpoint}");


				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $endpoint); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
				//curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);
				//curl_setopt($ch, CURLOPT_POST, 1);
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
				file_put_contents(DIR_LOGS . "checkout/adm_headers.txt", "Headers:\n{$headers}\n\nFull Response:\n{$res}");

				if ($curlError) {
					$aika = date("Y-m-d H:i:s");
					file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika}\nConnection failure. Please check that api.checkout.fi is reachable from your environment({$curlError})\n", FILE_APPEND);
					$this->data['text_error'] = $this->language->get('text_connection_failure');

					$json['status_id'] = 'Connection failure. Please check that api.checkout.fi is reachable from your environment(' . $curlError . ')';

				} elseif ($httpCode != 200) {

					switch ($httpCode) {
						case "200":
							$http_message = 'Code: 200 OK = Everything worked as expected.';
							break;
						case "201":
							$http_message = 'Code: 201 Created = A payment/refund was created successfully.';
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

					$json['status_id'] = $http_message;

				} else {
					$payment_info = json_decode($res_body);
					switch ($payment_info->status) {
						case "new":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_new'),$payment_info->status);
							break;
						case "ok":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_ok'),$payment_info->status);
							break;
						case "fail":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_fail'),$payment_info->status);
							break;
						case "pending":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_pending'),$payment_info->status);
							break;
						case "delayed":
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_delayed'),$payment_info->status);
							break;
						default:
							$json['status_id'] = sprintf($this->language->get('text_checkout_status'),$this->language->get('text_status_error'),$payment_info->status);
					} //end switch
				}
			} // end if order_info
		}

		$this->response->setOutput(json_encode($json));
	} // end paymentStatus

	public function paymentProviders() {
		$this->load->language('payment/checkout');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission'); 
		} else {
			if (!$this->config->get('checkout_test')) {
				$merchant_id = $this->config->get('checkout_merchant'); // Myyjän tunniste
				$secret_key = html_entity_decode($this->config->get('checkout_safety_key')); // Turva-avain
				$endpoint = 'https://api.checkout.fi/merchants/payment-providers';
			} else {
				$merchant_id = 375917; // Myyjän tunniste
				$secret_key = 'SAIPPUAKAUPPIAS'; // Turva-avain
				$endpoint = 'https://api.checkout.fi/merchants/payment-providers';
			}

			$checkout_headers = [
				'checkout-account' => $merchant_id,
				'checkout-algorithm' => 'sha256',
				'checkout-method' => 'GET',
				'checkout-nonce' => time(),
				'checkout-timestamp' => date('c'),
				'checkout-method' => 'GET',
				//'checkout-transaction-id' => $payment_info['transaction_id'],
				'cof-plugin-version' => 'OpenCart ' . VERSION . ' / HydeNet ' . $this->checkoutversion
			];

			$checkout_headers['signature'] = $this->calculateHmac($secret_key, $checkout_headers);

			$headers = array();
			foreach ($checkout_headers as $key => $value) {
				$headers[] = $key . ':' . $value;
			}

			//$request_json = json_encode($checkout_request, JSON_PRETTY_PRINT);
			$headers_json = print_r($headers, TRUE);
			file_put_contents(DIR_LOGS . "checkout/adm_request.txt", "Headers:\n{$headers_json}\n\nRequest URL:\n{$endpoint}");

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $endpoint); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);
			//curl_setopt($ch, CURLOPT_POST, 1);
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
			file_put_contents(DIR_LOGS . "checkout/adm_headers.txt", "Headers:\n{$headers}\n\nFull Response:\n{$res}");

			if ($curlError) {
				$aika = date("Y-m-d H:i:s");
				file_put_contents(DIR_LOGS . "checkout/checkout.txt", "{$aika}\nConnection failure. Please check that api.checkout.fi is reachable from your environment({$curlError})\n", FILE_APPEND);
				$this->data['text_error'] = $this->language->get('text_connection_failure');

				$json['status_id'] = 'Connection failure. Please check that api.checkout.fi is reachable from your environment(' . $curlError . ')';

			} elseif ($httpCode != 200) {

				switch ($httpCode) {
					case "200":
						$http_message = 'Code: 200 OK = Everything worked as expected.';
						break;
					case "201":
						$http_message = 'Code: 201 Created = A payment/refund was created successfully.';
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

				$json['status_id'] = $http_message;

			} else {
				$response_json = json_encode(json_decode($res_body), JSON_PRETTY_PRINT);
				file_put_contents(DIR_LOGS . "checkout/adm_response.txt", "HTTP code: {$httpCode}\nContent type: {$contentType}\n\n{$response_json}");
				$providers = json_decode($res_body, TRUE);
				$bank = array();
				$creditcard = array();
				$credit = array();
				$mobile = array();
				$other = array();
				foreach ($providers as $provider) {
					switch ($provider['group']) {
						case 'bank':
							$bank[$provider['id']] = array(
								'name' => $provider['name'],
								'icon' => $provider['icon']
							);
							break;
						case 'creditcard':
							$creditcard[$provider['id']] = array(
								'name' => $provider['name'],
								'icon' => $provider['icon']
							);
							break;
						case 'credit':
							$credit[$provider['id']] = array(
								'name' => $provider['name'],
								'icon' => $provider['icon']
							);
							break;
						case 'mobile':
							$mobile[$provider['id']] = array(
								'name' => $provider['name'],
								'icon' => $provider['icon']
							);
							break;
						default:
							$other[$provider['id']] = array(
								'name' => $provider['name'],
								'icon' => $provider['icon']
							);
					}
				}
				$json['status_id'] = ':D';
				$json['providers'] = array(
					'bank'       => $bank,
					'creditcard' => $creditcard,
					'credit'     => $credit,
					'mobile'     => $mobile,
					'other'      => $other
				);
				$provider_data = print_r($json['providers'], TRUE);
				file_put_contents(DIR_LOGS . "checkout/providers.txt", $provider_data);
			}
		}

		$this->response->setOutput(json_encode($json));
	} // end paymentProviders

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/checkout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['checkout_merchant']) {
			$this->error['merchant'] = $this->language->get('error_merchant');
		}

		if (!$this->request->post['checkout_safety_key']) {
			$this->error['safety_key'] = $this->language->get('error_safety_key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

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

}
?>