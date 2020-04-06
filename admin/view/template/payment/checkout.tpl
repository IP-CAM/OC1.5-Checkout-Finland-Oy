<?php
/******************************************************
* CHECKOUT FINLAND PAYMENT METHOD                     *
* Version:  2.0.0                                     *
* Date:     01.12.2019                                *
* File:     admin/view/template/payment/checkout.tpl  *
* Author:   HydeNet                                   *
* Web:      www.hydenet.fi                            *
* Email:    info@hydenet.fi                           *
******************************************************/
?>
<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment/icon_checkout.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
    <div id="htabs" class="htabs">
      <a href="#tab-general"><?php echo $tab_general; ?></a>
      <a href="#tab-log"><?php echo $tab_log; ?></a>
      <a href="#tab-info"><?php echo $tab_info; ?></a>
    </div> <!-- htabs -->
    <div id="tab-general">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_merchant; ?></td>
            <td><input type="text" name="checkout_merchant" value="<?php echo $checkout_merchant; ?>" />
              <?php if ($error_merchant) { ?>
              <span class="error"><?php echo $error_merchant; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_safety_key; ?></td>
            <td><input type="text" name="checkout_safety_key" value="<?php echo $checkout_safety_key; ?>" style="width: 50%;"/>
              <?php if ($error_safety_key) { ?>
              <span class="error"><?php echo $error_safety_key; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_message; ?></td>
            <td>
              <input type="text" name="checkout_message_fi" value="<?php echo $checkout_message_fi; ?>" style="width: 50%;"/><img src="view/image/flags/fi.png" title="<?php echo $entry_message_fi; ?>" alt="<?php echo $entry_message_fi; ?>" style="vertical-align: middle; margin-left: 5px;" /><br />
              <div style="margin: 5px 0;"><input type="text" name="checkout_message_se" value="<?php echo $checkout_message_se; ?>" style="width: 50%;"/><img src="view/image/flags/se.png" title="<?php echo $entry_message_se; ?>" alt="<?php echo $entry_message_se; ?>" style="vertical-align: middle; margin-left: 5px;" /></div>
              <input type="text" name="checkout_message_en" value="<?php echo $checkout_message_en; ?>" style="width: 50%;"/><img src="view/image/flags/gb.png" title="<?php echo $entry_message_en; ?>" alt="<?php echo $entry_message_en; ?>" style="vertical-align: middle; margin-left: 5px;" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($checkout_test) { ?>
              <input type="radio" name="checkout_test" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="checkout_test" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="checkout_test" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="checkout_test" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_debug; ?></td>
            <td><?php if ($checkout_debug) { ?>
              <input type="radio" name="checkout_debug" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="checkout_debug" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="checkout_debug" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="checkout_debug" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_log; ?></td>
            <td><?php if ($checkout_log) { ?>
              <input type="radio" name="checkout_log" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="checkout_log" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="checkout_log" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="checkout_log" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_content; ?></td>
            <td><select name="checkout_content" disabled>
                <?php if ($checkout_content == 1) { ?>
                <option value="1" selected="selected"><?php echo $text_products; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_products; ?></option>
                <?php } ?>
                <?php if ($checkout_content == 2) { ?>
                <option value="2" selected="selected"><?php echo $text_order; ?></option>
                <?php } else { ?>
                <option value="2"><?php echo $text_order; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <!--
          <tr>
            <td><?php echo $entry_device; ?></td>
            <td><select name="checkout_device">
                <?php if ($checkout_device == 10) { ?>
                <option value="10" selected="selected"><?php echo $text_device_xml; ?></option>
                <?php } else { ?>
                <option value="10"><?php echo $text_device_xml; ?></option>
                <?php } ?>
                <?php if ($checkout_device == 1) { ?>
                <option value="1" selected="selected"><?php echo $text_device_html; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_device_html; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          -->
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="checkout_total" value="<?php echo $checkout_total; ?>" /></td>
          </tr>          
          <tr>
            <td><?php echo $entry_ok_status; ?></td>
            <td><select name="checkout_ok_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $checkout_ok_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_delayed_status; ?></td>
            <td><select name="checkout_delayed_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $checkout_delayed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_unknown_status; ?></td>
            <td><select name="checkout_unknown_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $checkout_unknown_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="checkout_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $checkout_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="checkout_status">
                <?php if ($checkout_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="checkout_sort_order" value="<?php echo $checkout_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div> <!-- tab general -->
    <div id="tab-log">
      <table class="form">
        <tr>
          <td>
            <?php echo $entry_log_contents; ?><br /><?php echo $log_file; ?>
            <div class="buttons"><a href="<?php echo $clear_log; ?>" class="button"><?php echo $button_clear_log; ?></a></div>
          </td>
          <td>
            <textarea wrap="off" style="width: 98%; height: 300px; padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow: scroll;"><?php echo $log; ?></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $entry_debug_contents; ?><br /><?php echo $debug_file; ?>
            <div class="buttons"><a href="<?php echo $clear_debug; ?>" class="button"><?php echo $button_clear_debug; ?></a></div>
          </td>
          <td>
            <textarea wrap="off" style="width: 98%; height: 300px; padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow: scroll;"><?php echo $debug; ?></textarea>
          </td>
        </tr>
      </table>
    </div> <!-- tab log -->
    <div id="tab-info">
      <div id="providers-reguest"><button type="button" id="list-payment-providers"><?php echo $button_list_providers; ?></button></div>
      <div id="payment-providers"></div>
    </div> <!-- tab log -->
    </div>
  <small style="font-size: 9px;"><?php echo $heading_title; ?> <?php echo $text_info; ?> &copy; <a href="http://www.hydenet.fi" target="_blank">HydeNet</a> <?php echo date('Y') ?></small>
  </div>
</div>
<!-- välilehdet -->
<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script>
<script type="text/javascript"><!--
  $('#list-payment-providers').live('click', function() {
    $.ajax({
      url: 'index.php?route=payment/checkout/paymentProviders&token=<?php echo $token; ?>',
      dataType: 'json',
      beforeSend: function() {
        $('#list-payment-providers').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
      },
      complete: function() {
        $('.loading').remove();
      },
      success: function(json) {
        $('.success, .warning').remove();

        if (json['error']) {
          $('#providers-reguest').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
          $('.warning').fadeIn('slow');
        }

        if (json.status_id) {
          $('#payment-providers').empty();
          $.each(json.providers, function(i, type) {
            $.each(type, function(j, provider) {
              $('#payment-providers').append('<img src="' + provider.icon + '" alt="' + provider.name + '" title="' + provider.name + '" style="float: left; padding: 5px; box-sizing: border-box; border: 1px solid #ccc; text-align: center; margin: 5px;" />');
            });
          });
        }
      }
    });
  });
//--></script>

<?php echo $footer; ?> 