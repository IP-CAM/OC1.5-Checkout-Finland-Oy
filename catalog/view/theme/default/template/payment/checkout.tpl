<?php
/****************************************************************************
* CHECKOUT FINLAND PAYMENT METHOD                                           *
* Version:  2.0.0                                                           *
* Date:     01.12.2019                                                      *
* File:     catalog/view/theme/default/template/payment/checkout.tpl        *
* Author:   HydeNet                                                         *
* Web:      www.hydenet.fi                                                  *
* Email:    info@hydenet.fi                                                 *
****************************************************************************/
?>
<?php if ($testmode) { ?>
<div class="warning"><?php echo $text_testmode; ?></div>
<?php } ?>

  <h2><?php echo $text_checkout_title; ?></h2>
  <p><?php echo $text_checkout_info; ?></p>

<div class="checkout-payment-select">
<?php $providers = json_decode($checkout_providers); ?>
<?php foreach ($providers->providers as $provider) { ?>
  <form method="post" action="<?php echo $provider->url; ?>" id="form-<?php echo $provider->id; ?>" class="checkout-payment-form">
  <?php foreach ($provider->parameters as $parameter) { ?>
  <input type="hidden" name="<?php echo $parameter->name; ?>" value="<?php echo $parameter->value; ?>">
  <?php } // end foreach provider ?>
  <input type="image" src="<?php echo $provider->icon; ?>" alt="<?php echo $parameter->name; ?>" class="checkout-payment-button">
  </form>
<?php } // end foreach providers ?>
</div>