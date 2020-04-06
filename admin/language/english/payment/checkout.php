<?php
/************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD							*
*	Version:	2.0.0										*
*	Date:		01.12.2019									*
*	File:		admin/language/english/payment/checkout.php	*
*	Author:		HydeNet										*
*	Web:		www.hydenet.fi								*
*	Email:		info@hydenet.fi								*
************************************************************/

// Heading
$_['heading_title']					 = 'Checkout';

// Text
$_['text_payment']					= 'Payment type';
$_['text_success']					= 'Maksutavan "Checkout" muokkaus onnistui!';
$_['text_checkout']					= '<a onclick="window.open(\'http://checkout.fi/\');"><img src="view/image/payment/logo_checkout.png" alt="Checkout" title="Checkout"/></a>';
$_['text_products']					= 'Products';
$_['text_order']					= 'Order';
$_['text_device_html']				= 'Separate payment choice page';
$_['text_device_xml']				= 'Embedded payment type selection';
$_['text_no_file']					= 'File not found';
$_['text_status_new']				= 'Payment has been grated but not paid.';
$_['text_status_ok']				= 'Payment was accepted by the provider and confirmed successfully';
$_['text_status_fail']				= 'Payment was cancelled by the user or rejected by the provider';
$_['text_status_pending']			= 'Payment was initially approved by the provider but further processing is needed.';
$_['text_status_delayed']			= 'Payment was delayed by the provider and further processing is needed.';
$_['text_status_error']				= 'Undefined payment status.';
$_['text_checkout_status']			= 'Payment status: %s (Status code: %s)';

// Entry
$_['entry_merchant']				= 'Seller id:';
$_['entry_safety_key']				= 'Seller secret key:';
$_['entry_message']					= 'Message to customer:';
$_['entry_message_fi']				= 'Finnish';
$_['entry_message_se']				= 'Swedish';
$_['entry_message_en']				= 'English';
$_['entry_test']					= 'Test mode:<br/><span class="help">Choose "No" for productive use</span>';
$_['entry_content']					= 'Order items:<br/><span class="help">Products = All individual products<br>Order = Full order on one line</span>';
$_['entry_device']					= 'Payment method choosing:';
$_['entry_debug']					= 'Debug Mode:<br/><span class="help">Tallentaa maksutapahtuman tiedot tiedostoon (checkout.txt) Use only  if you think there is some problem.</span>';
$_['entry_debug_contents']			= 'Debug file content:<br/><span class="help"></span>';
$_['entry_log']						= 'Log:<br/><span class="help">Saves transaction to log file (checkout.log).</span>';
$_['entry_log_contents']			= 'Log file content:<br/><span class="help"></span>';
$_['entry_total']					= 'Amount:<br /><span class="help">Order must be higher than this before this payment type activates.</span>';
$_['entry_geo_zone']				= 'Geo zone:';
$_['entry_ok_status']				= 'Approved payment status:';
$_['entry_delayed_status']			= 'Delayed  payment status:';
$_['entry_unknown_status']			= 'Unclear payment status:';
$_['entry_status']					= 'Status:';
$_['entry_sort_order']				= 'Order:';

// Tab
$_['tab_general']					= 'General';
$_['tab_log']						= 'Log';
$_['tab_info']						= 'Info';

// Button
$_['button_clear_log']				= 'Empty log file';
$_['button_clear_debug']			= 'Empty debug file';
$_['button_list_providers']			= 'List payment providers';

// Error
$_['error_permission']				= 'You dont have permission to modify this payment type!';
$_['error_merchant']				= 'Seller ID reguired!';
$_['error_safety_key']				= 'Secret key reguired!';
$_['error_action']					= 'Payment not found!';
?>