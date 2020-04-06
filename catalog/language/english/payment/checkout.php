<?php
/****************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD								*
*	Version:	2.0.0											*
*	Date:		01.12.2019										*
*	File:		catalog/language/english/payment/checkout.php	*
*	Author:		HydeNet											*
*	Web:		www.hydenet.fi									*
*	Email:		info@hydenet.fi									*
****************************************************************/

// Text
$_['text_title']				= 'Checkout';
$_['text_checkout_title']		= 'Confirm order by selecting your preferred payment method';
$_['text_checkout_info']		= 'Please select the preferred payment method and you are forwarded to the payment service you choose. Be sure to come back after payment by selecting the link in service.';
$_['text_reason']				= 'REASON';
$_['text_testmode']				= 'Warning: The payment gateway is in \'Sandbox Mode\'. Your account will not be charged.';
$_['text_total']				= 'Shipping, Handling, Discounts & Taxes';
$_['text_status_1']				= 'Maksutapahtuma kesken';
$_['text_status_2']				= 'Accepted payment';
$_['text_status_3']				= 'Delayed payment';
$_['text_status_4']				= '???';
$_['text_status_5']				= '???';
$_['text_status_6']				= 'Payment frozen';
$_['text_status_7']				= 'A third party has approved the payment and it requires approval / activation';
$_['text_status_8']				= 'A third party has approved the payment / payment has been activated';
$_['text_status_9']				= '???';
$_['text_status_10']			= 'Payment paid';
$_['text_status_-1']			= 'Payment canceled by user';
$_['text_status_-2']			= 'Payment canceled by system';
$_['text_status_-3']			= 'Payment time out';
$_['text_status_-4']			= 'Payment not found';
$_['text_status_-10']			= 'Payment refunded to the payer';
$_['text_checkout_status']		= 'Payment status: %s (Status code: %s)';
$_['text_order_number']			= 'Order number: ';
$_['text_payment_status']		= 'Payment status: ';
$_['text_success']				= 'Successful payment.';
$_['text_reference']			= 'Payment reference number is %s.';
$_['text_order_description']	= 'Order #%s from %s';

// Error page
$_['heading_title']				= 'Error in payment';
$_['text_error']				= 'Error in payment.';
$_['return_error']				= 'Payment return message encountered an error!';
$_['error_description']			= 'Error in payment verification message.<br />This is most likely caused by an error of transmission.<br /><br />Please contact us by selecting "%s"-button.';

// Cancelled page
$_['heading_title_canceled']		= 'Payment transaction was canceled';
$_['text_error_canceled']			= 'Payment transaction was canceled.';
$_['return_error_canceled']			= 'Payment transaction was canceled!';
$_['error_description_canceled']	= 'Payment transaction was canceled by user.<br /><br />Go back to checkout by selecting "%s"-button.';
$_['text_error_creation']			= 'Error in payment creation.<br />Please try again or contact us by selecting "%s"-button.';
$_['text_error_button']				= 'Contact us';

// reject page
$_['heading_title_reject']		= 'Payment rejected';
$_['text_error_reject']			= 'Payment rejected.';
$_['return_error_reject']		= 'Payment rejected!';
$_['error_description_reject']	= 'System reject payment.<br /><br />Go back to checkout by selecting "%s"-button.';
?>