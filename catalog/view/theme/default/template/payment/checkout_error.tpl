<?php
/********************************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD												*
*	Version:	2.0.0															*
*	Date:		01.12.2019														*
*	File:		catalog/view/theme/default/template/payment/checkout_error.tpl	*
*	Author:		HydeNet															*
*	Web:		www.hydenet.fi													*
*	Email:		info@hydenet.fi													*
********************************************************************************/
?>
<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
	<h1><?php echo $heading_title; ?></h1>
	<div class="content">
		<div class="warning"><?php echo $return_error; ?></div>
		<p><?php echo $error_description ?></p>
	</div>
	<div class="buttons">
		<div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
	</div>
	<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>