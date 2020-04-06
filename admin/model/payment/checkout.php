<?php
/****************************************************
*	CHECKOUT FINLAND PAYMENT METHOD					*
*	Version:	2.0.0								*
*	Date:		01.12.2019							*
*	File:		admin/model/payment/checkout.php	*
*	Author:		HydeNet								*
*	Web:		www.hydenet.fi						*
*	Email:		info@hydenet.fi						*
****************************************************/

class ModelPaymentCheckout extends Model {

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
		$this->db->query("UPDATE '" . DB_PREFIX . "order_payment_data SET stamp = '" . $this->db->escape($order_fields['stamp']) . "', reference = '" . $this->db->escape($order_fields['reference']) . "', transaction_id = '" . $this->db->escape($order_fields['transaction_id']) . "', provider = '" . $order_fields['provider'] . "', status = '" . $order_fields['status'] . "' WHERE order_id = '" . (int)$order_id . "'");
	}
	public function getOrderPaymentData($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_payment_data WHERE order_id = '" . (int)$order_id . "' LIMIT 1");

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function install() {
		$this->db->query("
			CREATE TABLE " . DB_PREFIX . "order_payment_data (
				order_payment_data_id int(11) NOT NULL AUTO_INCREMENT,
				order_id int(11) NOT NULL,
				stamp varchar(32) NOT NULL,
				reference varchar(128) NOT NULL,
				transaction_id varchar(128) NOT NULL,
				provider varchar(128) NOT NULL,
				status varchar(128) NOT NULL,
				PRIMARY KEY (order_payment_data_id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "order_payment_data;");
	}


}
?>