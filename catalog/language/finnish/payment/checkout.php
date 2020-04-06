<?php
/****************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD								*
*	Version:	2.0.0											*
*	Date:		01.12.2019										*
*	File:		catalog/language/finnish/payment/checkout.php	*
*	Author:		HydeNet											*
*	Web:		www.hydenet.fi									*
*	Email:		info@hydenet.fi									*
****************************************************************/

// Text
$_['text_title']				= 'Checkout';
$_['text_checkout_title']		= 'Vahvista tilaus valitsemalla haluamasi maksutapa';
$_['text_checkout_info']		= 'Valittuasi maksutavan alla olevista vaihtoehdoista, maksutapahtuma siirtyy maksutavan järjestelmään. Maksu suoritetaan Checkout Finland Oy:n hallinnoimalle tilille, josta se siirretään kauppiaalle.<br />Muista maksun jälkeen palata takaisin kauppaan valitsemalla maksupalvelussa sitä varten oleva linkki tai painike.';
$_['text_testmode']				= 'Maksutapa on testitilassa ja maksua ei oikeasti käsitellä!';
$_['text_status_1']				= 'Maksutapahtuma kesken';
$_['text_status_2']				= 'Hyväksytty maksu';
$_['text_status_3']				= 'Viivästetty maksu';
$_['text_status_4']				= '???';
$_['text_status_5']				= '???';
$_['text_status_6']				= 'Maksu jäädytetty';
$_['text_status_7']				= 'Kolmas osapuoli on hyväksynyt maksun ja se vaatii hyväksyntää/aktivointia';
$_['text_status_8']				= 'Kolmas osapuoli on hyväksynyt maksun / maksu on aktivoitu';
$_['text_status_9']				= '???';
$_['text_status_10']			= 'Maksu tilitetty';
$_['text_status_-1']			= 'Maksu käyttäjän peruma';
$_['text_status_-2']			= 'Maksu järjestelmän peruuttama';
$_['text_status_-3']			= 'Maksutapahtuma aikakatkaistu';
$_['text_status_-4']			= 'Maksutapahtumaa ei löydy';
$_['text_status_-10']			= 'Maksu hyvitetty maksajalle';
$_['text_checkout_status']		= 'Maksun tila: %s (Tilakoodi: %s)';
$_['text_order_number']			= 'Tilausnumero: ';
$_['text_payment_status']		= 'Payment status: ';
$_['text_success']				= 'Onnistunut maksu.';
$_['text_reference']			= 'Maksutapahtuman viitenumero on %s.';
$_['text_ok']					= 'Maksutapahtuma vahvistettu.';
$_['text_fail']					= 'Maksutapahtuma epäonnistui.';
$_['text_pending']				= 'Maksutapahtuma odottaa vahvistusta.';
$_['text_delayed']				= 'Maksutapahtuma odottaa vahvistusta (viivästetty).';
$_['text_unknown']				= '???';
$_['text_order_description']	= 'Tilaus #%s %s verkkokaupasta';

// Error page
$_['heading_title']		= 'Virhe maksussa';
$_['text_error']		= 'Virhe maksussa.';
$_['return_error']		= 'Maksun paluuviestissä havaittiin virhe!';
$_['error_description']	= 'Maksun tarkistus tiedoissa havaittiin virhe.<br />Tämä johtuu todennäköisesti tietoliikenteessä tapahtuneessa häiriössä.<br /><br />Ota yhteyttä asiakaspalveluumme painamalla "%s"-painiketta.';

// Cancelled page
$_['heading_title_canceled']		= 'Maksutapahtuma peruuntui';
$_['text_error_canceled']			= 'Maksutapahtuma peruuntui.';
$_['return_error_canceled']			= 'Maksutapahtuma peruutettu!';
$_['error_description_canceled']	= 'Maksutapahtuma peruutettu.<br /><br />Siirry takaisin kassalle painamalla "%s"-painiketta.';
$_['text_error_creation']			= 'Virhe maksun luonnissa.<br />Yritä uudestaan tai ota yhteyttä asiakaspalveluumme painamalla "%s"-nappia.';
$_['text_error_button']				= 'Ota yhteyttä';

// reject page
$_['heading_title_reject']		= 'Maksutapahtuma hylätty';
$_['text_error_reject']		= 'Maksutapahtuma hylätty.';
$_['return_error_reject']		= 'Maksutapahtuma hylätty!';
$_['error_description_reject']	= 'Järjestelmä hylkäsi maksun.<br /><br />Siirry takaisin kassalle painamalla "%s"-painiketta.';

?>