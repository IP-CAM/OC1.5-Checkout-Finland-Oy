<?php
/************************************************************
*	CHECKOUT FINLAND PAYMENT METHOD							*
*	Version:	2.0.0										*
*	Date:		01.12.2019									*
*	File:		admin/language/finnish/payment/checkout.php	*
*	Author:		HydeNet										*
*	Web:		www.hydenet.fi								*
*	Email:		info@hydenet.fi								*
************************************************************/

// Heading
$_['heading_title']					= 'Checkout';

// Text
$_['text_payment']					= 'Maksutavat';
$_['text_success']					= 'Maksutavan "Checkout" muokkaus onnistui!';
$_['text_checkout']					= '<a onclick="window.open(\'http://checkout.fi/\');"><img src="view/image/payment/logo_checkout.png" alt="Checkout" title="Checkout" /></a>';
$_['text_products']					= 'Tuotteet';
$_['text_order']					= 'Tilaus';
$_['text_device_html']				= 'Erillinen maksutavan valinta';
$_['text_device_xml']				= 'Upotettu maksutavan valinta';
$_['text_no_file']					= 'Tiedostoa ei löydy';
$_['text_status_new']				= 'Maksutapahtuma luotu, mutta ei maksettu.';
$_['text_status_ok']				= 'Hyväksytty maksu';
$_['text_status_fail']				= 'Maksu peruutettu tai hylätty';
$_['text_status_pending']			= 'Odottaa vahvistamista';
$_['text_status_delayed']			= 'Viivästynyt maksu.';
$_['text_status_error']				= 'Maksutapahtuman tila tuntematon.';
$_['text_checkout_status']			= '<strong>Maksun tila: %s</strong> (Tilakoodi: %s)';

// Entry
$_['entry_merchant']				= 'Myyjän tunniste:';
$_['entry_safety_key']				= 'Myyjän turva-avain:';
$_['entry_message']					= 'Viesti asiakkaalle:<br/><span class="help">Tämä näkyy erillisellä maksutavan valintasivulla ja maksuntiedoissa.</span>';
$_['entry_message_fi']				= 'Suomeksi';
$_['entry_message_se']				= 'Ruotsiksi';
$_['entry_message_en']				= 'Englanniksi';
$_['entry_test']					= 'Testitila:<br/><span class="help">Valitse "Ei" tuotantokäyttöä varten.</span>';
$_['entry_content']					= 'Tilauksen tietojen vienti:<br/><span class="help">Tuotteet = Kaikki tuotteet yksittäin<br>Tilaus = Koko tilaus yhtenä rivinä</span>';
$_['entry_device']					= 'Maksutavan valinta:';
$_['entry_debug']					= 'Debug Mode:<br/><span class="help">Tallentaa maksutapahtuman tiedot tiedostoon (checkout.txt) Käytä vain jos epäilet ongelmia maksutavan toiminnassa tai haluat testata.</span>';
$_['entry_debug_contents']			= 'Debug tiedoston sisältö:<br/><span class="help"></span>';
$_['entry_log']						= 'Loki:<br/><span class="help">Tallentaa maksutapahtumat lokitiedostoon (checkout.log).</span>';
$_['entry_log_contents']			= 'Loki tiedoston sisältö:<br/><span class="help"></span>';
$_['entry_total']					= 'Summa:<br /><span class="help">Tilauksen lopusumman oltava vähintään ennen kuin maksutapa aktivoituu.</span>';
$_['entry_geo_zone']				= 'Maantieteellinen alue:';
$_['entry_ok_status']				= 'Hyväksytyn maksun tila:';
$_['entry_delayed_status']			= 'Viivästetyn maksun tila:';
$_['entry_unknown_status']			= 'Epäselvän maksun tila:';
$_['entry_status']					= 'Tila:';
$_['entry_sort_order']				= 'Järjestysnumero:';

// Tab
$_['tab_general']					= 'Yleiset';
$_['tab_log']						= 'Loki';
$_['tab_info']						= 'Tiedot';

// Button
$_['button_clear_log']				= 'Tyhjennä loki tiedosto';
$_['button_clear_debug']			= 'Tyhjennä debug tiedosto';
$_['button_list_providers']			= 'Näytä käytettävissä olevat maksutavat';

// Error
$_['error_permission']				= 'Käyttöoikeutesi eivät riitä maksutavan muokkaukseen!';
$_['error_merchant']				= 'Myyjän tunniste vaaditaan!';
$_['error_safety_key']				= 'Myyjän turva-avain vaaditaan!';
$_['error_action']					= 'Maksun tietoja ei löydy!';
?>