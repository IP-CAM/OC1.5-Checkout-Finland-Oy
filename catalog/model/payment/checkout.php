<?php
/****************************************************
*	CHECKOUT FINLAND PAYMENT METHOD					*
*	Version:	2.0.0								*
*	Date:		01.12.2019							*
*	File:		catalog/model/payment/checkout.php	*
*	Author:		HydeNet								*
*	Web:		www.hydenet.fi						*
*	Email:		info@hydenet.fi						*
****************************************************/

class ModelPaymentCheckout extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/checkout');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('checkout_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('checkout_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('checkout_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}	

		$method_data = array();

		if ($status) {  
			$method_data = array( 
				'code'       => 'checkout',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('checkout_sort_order')
			);
		}

		return $method_data;
	}

	public function changeOrderStatus($order_id, $order_status_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	}

	public function addOrderHistory($order_id, $order_status_id, $comment, $notify) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '0', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	}

	public function addOrderPaymentData($order_id, $order_fields) { // order_id stamp reference transaction_id provider status
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_payment_data SET order_id = '" . (int)$order_id . "', stamp = '" . $this->db->escape($order_fields['stamp']) . "', reference = '" . $this->db->escape($order_fields['reference']) . "', transaction_id = '" . $this->db->escape($order_fields['transaction_id']) . "', provider = '" . $order_fields['provider'] . "', status = '" . $order_fields['status'] . "'");
	}
	public function updateOrderPaymentData($order_id, $order_fields) {
		$this->db->query("UPDATE " . DB_PREFIX . "order_payment_data SET stamp = '" . $this->db->escape($order_fields['stamp']) . "', reference = '" . $this->db->escape($order_fields['reference']) . "', transaction_id = '" . $this->db->escape($order_fields['transaction_id']) . "', provider = '" . $order_fields['provider'] . "', status = '" . $order_fields['status'] . "' WHERE order_id = '" . (int)$order_id . "'");
	}
}
?>