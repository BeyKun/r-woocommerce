<?php
/** /
* @package roketin
*/
/*
Plugin Name: Roketin
Plugin URI: http://github.com/beykun/wp-roketin
Description: this plugin to connect woocomerce to roketin engine
Author: Bayu Rasukma Raga
Author URI: http://github.com/beykun
Licence: MIT
Version: 0.0.2
Text domain: Roketin Plugin
*/

defined('ABSPATH') or die('Oppss! you can not access this file');

require_once __DIR__.'/vendor/autoload.php';

include_once(__DIR__ . '/autoload.php');

include_once(__DIR__ . '/includes/query.php');

include_once('roketin_shipping_kec.php');
$upload_dir = wp_upload_dir();
$plugin_dir = plugin_dir_path(__FILE__);

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins'))) || array_key_exists( 'woocommerce/woocommerce.php', maybe_unserialize( get_site_option( 'active_sitewide_plugins') ) )) {
    
	function wc_shipping_tikijne_init() {
		if(!class_exists('WC_Shipping_Tikijne')){
    		include_once(__DIR__ .  '/includes/Order/Shiping.php');
 		}
    }
    
    add_action( 'woocommerce_shipping_init', 'wc_shipping_tikijne_init' );
	function add_tikijne_shipping_method( $methods ) {
			$methods[] = 'WC_Shipping_Tikijne';
			return $methods;
    }
    add_filter( 'woocommerce_shipping_methods', 'add_tikijne_shipping_method' );

    function override_default_address() {
        $fields = array(
                'first_name' => array(
                        'label'        => __( 'Nama Depan', 'woocommerce' ),
                        'required'     => true,
                        'class'        => array( 'form-row-first' ),
                        'autocomplete' => 'given-name',
                        'autofocus'    => true,
                        'priority'     => 10,
                ),   
                'last_name' => array(
                        'label'        => __( 'Nama Belakang', 'woocommerce' ),
                        'required'     => true,
                        'class'        => array( 'form-row-last' ),
                        'autocomplete' => 'family-name',
                        'priority'     => 20,
                ),   
                'company' => array(
                        'label'        => __( 'Company name', 'woocommerce' ),
                        'class'        => array( 'form-row-wide' ),
                        'autocomplete' => 'organization',
                        'priority'     => 30,
                ),   
                'country' => array(
                        'type'         => 'country',
                        'label'        => __( 'Negara', 'woocommerce' ),
                        'required'     => true,
                        'class'        => array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
                        'autocomplete' => 'country',
                        'priority'     => 40,
                ),
                'address_1' => array(
                        'label'        => __( 'Address', 'woocommerce' ),
                        'placeholder'  => esc_attr__( 'Street address', 'woocommerce' ),
                        'required'     => true,
                        'class'        => array( 'form-row-wide', 'address-field' ),
                        'autocomplete' => 'address-line1',
                        'priority'     => 50,
                ),
                'address_2' => array(
                        'placeholder'  => esc_attr__( 'Apartment, suite, unit etc. (optional)', 'woocommerce' ),
                        'class'        => array( 'form-row-wide', 'address-field' ),
                        'required'     => false,
                        'autocomplete' => 'address-line2',
                        'priority'     => 60,
                ),
                'address_4' => array(
                    'placeholder'  => esc_attr__( 'Courier', 'woocommerce' ),
                    'class'        => array( 'form-row-wide', 'address-field' ),
                    'required'     => false,
                    'autocomplete' => 'address-line1',
                    'priority'     => 70,
                ),
                'state' => array(
                        'type'         => 'state',
                        'label'        => __( 'Courier', 'woocommerce' ),
                        'required'     => true,
                        'class'        => array( 'form-row-wide', 'address-field' ),
                        'validate'     => array( 'state' ),
                        'autocomplete' => 'address-level1',
                        'priority'     => 80,
                ),
                'postcode' => array(
                        'label'        => __( 'Kodepos', 'woocommerce' ),
                        'required'     => true,
                        'class'        => array( 'form-row-last', 'address-field' ),
                        'validate'     => array( 'postcode' ),
                        'autocomplete' => 'postal-code',
                        'priority'     => 90,
                ),
          );
        return $fields;
}

add_filter ('woocommerce_default_address_fields', 'override_default_address');

	function custom_checkout_fields( $fields ) {
        $billing_first_name_tmp = $fields['billing']['billing_first_name'];
        $billing_last_name_tmp = $fields['billing']['billing_last_name'];
            $shipping_first_name_tmp = $fields['shipping']['shipping_first_name'];
        $shipping_last_name_tmp = $fields['shipping']['shipping_last_name'];
        $billing_state_tmp = $fields['billing']['billing_state'];
        $shipping_state_tmp = $fields['shipping']['shipping_state'];
        $billing_address_1_tmp = $fields['billing']['billing_address_1'];
        $shipping_address_1_tmp = $fields['shipping']['shipping_address_1'];
          $billing_city_tmp = $fields['billing']['billing_city'];
        $shipping_city_tmp = $fields['shipping']['shipping_city'];
        $billing_address_2_tmp = $fields['billing']['billing_address_2'];
        $billing_address_4_tmp = $fields['billing']['billing_address_4'];
        $shipping_address_2_tmp = $fields['shipping']['shipping_address_2'];
        $billing_postcode_tmp = $fields['billing']['billing_postcode'];
        $shipping_postcode_tmp = $fields['shipping']['shipping_postcode'];
        $billing_phone_tmp = $fields['billing']['billing_phone'];
        $billing_email_tmp = $fields['billing']['billing_email'];
        $shipping_country_tmp = $fields['shipping']['shipping_country'];
        $billing_country_tmp = $fields['billing']['billing_country'];
        unset($fields['billing']);
        unset($fields['shipping']);
       
        $fields['billing']['billing_first_name'] = $billing_first_name_tmp;
        $fields['billing']['billing_last_name'] = $billing_last_name_tmp;
       
        $fields['shipping']['shipping_first_name'] = $shipping_first_name_tmp;
        $fields['shipping']['shipping_last_name'] = $shipping_last_name_tmp;
           
        $fields['billing']['billing_address_1'] = $billing_address_1_tmp;
                $fields['billing']['billing_address_1']['label'] = 'Alamat Lengkap';
                $fields['billing']['billing_address_1']['placeholder'] = '';
   
        $fields['shipping']['shipping_address_1'] = $shipping_address_1_tmp;
                $fields['shipping']['shipping_address_1']['label'] = 'Alamat Lengkap';
                $fields['shipping']['shipping_address_1']['placeholder'] = '';

        $list_of_kota_kabupaten = get_list_of_kota_kabupaten();

        $fields['billing']['billing_city'] = $billing_city_tmp;
                $fields['billing']['billing_city']['label'] = 'Kota/Kabupaten';
                $fields['billing']['billing_city']['placeholder'] = 'Select Kota/Kabupaten';
                $fields['billing']['billing_city']['type'] = 'select';
                $fields['billing']['billing_city']['options'] = $list_of_kota_kabupaten;

                $fields['shipping']['shipping_city'] = $shipping_city_tmp;
                $fields['shipping']['shipping_city']['label'] = 'Kota/Kabupaten';
                $fields['shipping']['shipping_city']['placeholder'] = 'Select Kota/Kabupaten';
                $fields['shipping']['shipping_city']['type'] = 'select';
                $fields['shipping']['shipping_city']['options'] = $list_of_kota_kabupaten;

        $list_of_kecamatan = get_list_of_kecamatan('init');
        $fields['billing']['billing_address_2'] = $billing_address_2_tmp;
        $fields['billing']['billing_address_2']['label'] = 'Kecamatan';
        $fields['billing']['billing_address_2']['type'] = 'select'; 
        $fields['billing']['billing_address_2']['placeholder'] = 'Select Kecamatan';
        $fields['billing']['billing_address_2']['required'] = true;
        $fields['billing']['billing_address_2']['class'] = array(
                        'form-row','form-row-wide','address-field','validate-required','update_totals_on_change');
        $fields['billing']['billing_address_2']['options'] = $list_of_kecamatan;
       
         $fields['shipping']['shipping_address_2'] = $shipping_address_2_tmp;
        $fields['shipping']['shipping_address_2']['label'] = 'Kecamatan';
        $fields['shipping']['shipping_address_2']['type'] = 'select';
        $fields['shipping']['shipping_address_2']['placeholder'] = 'Select Kecamatan';
        $fields['shipping']['shipping_address_2']['required'] = true;
        $fields['shipping']['shipping_address_2']['class'] = array(
                        'form-row','form-row-wide','address-field','validate-required','update_totals_on_change');
          $fields['shipping']['shipping_address_2']['options'] = $list_of_kecamatan;
        
       
        $fields['billing']['billing_address_3']['label'] = 'Kelurahan';
                $fields['billing']['billing_address_3']['type'] = 'text';
        $fields['billing']['billing_address_3']['required'] = true;

                $fields['shipping']['shipping_address_3']['label'] = 'Kelurahan';
        $fields['shipping']['shipping_address_3']['required'] = true;
                $fields['shipping']['shipping_address_3']['type'] = 'text';

        $fields['billing']['billing_state'] = $billing_state_tmp;
        $fields['billing']['billing_state']['class'] = array('form-row','form-row-first','address_field','validate-required','update_totals_on_change');
        $fields['billing']['billing_postcode'] = $billing_postcode_tmp;
        
        $fields['shipping']['shipping_state'] = $shipping_state_tmp;
        $fields['shipping']['shipping_state']['class'] = array('form-row','form-row-first','address_field','validate-required','update_totals_on_change');
        $fields['shipping']['shipping_postcode'] = $shipping_postcode_tmp;
        $fields['billing']['billing_country'] = $billing_country_tmp;
        $fields['billing']['billing_email'] = $billing_email_tmp;
        $fields['billing']['billing_phone'] = $billing_phone_tmp;
        $fields['shipping']['shipping_country'] = $shipping_country_tmp;


        $list_of_courier = get_list_of_courier('init');
        $fields['billing']['billing_address_4'] = $billing_address_4_tmp;
        $fields['billing']['billing_address_4']['label'] = 'Courier';
        $fields['billing']['billing_address_4']['type'] = 'select'; 
        $fields['billing']['billing_address_4']['placeholder'] = 'Select Courier';
        $fields['billing']['billing_address_4']['required'] = true;
        $fields['billing']['billing_address_4']['class'] = array(
                        'form-row','form-row-wide','address-field','validate-required','update_totals_on_change');
        $fields['billing']['billing_address_4']['options'] = $list_of_courier;

        return $fields;
       }
   add_filter( 'woocommerce_checkout_fields' ,  'custom_checkout_fields' );

   function js_change_select_class() {
           wp_enqueue_script('init_controls',plugins_url('/js/init_controls.js',__FILE__), array('jquery'));
           ?>
           <script type="text/javascript">
            jQuery(document).ready(function($) { init_control(); $('#billing_address_3').val('<?php global $current_user; echo get_user_meta($current_user -> ID, 'kelurahan', true); ?>'); $('#shipping_address_3').val('<?php global $current_user; echo get_user_meta($current_user -> ID, 'kelurahan', true); ?>');});
           </script>
           <?php
   }
   add_action ('woocommerce_after_order_notes', 'js_change_select_class');

	function js_query_kecamatan_shipping_form(){
		$kec_url = admin_url('admin-ajax.php');
		wp_enqueue_script('ajax_shipping_kec',plugins_url('/js/shipping_kecamatan.js',__FILE__), array('jquery'));
        wp_localize_script( 'ajax_shipping_kec', 'PT_Ajax_Ship_Kec', array(
            'ajaxurl'       => $kec_url,
			'nextNonce'     => wp_create_nonce('myajax-next-nonce'),
        ));

	?>	
		<script type="text/javascript">
			jQuery(document).ready(function($){
					shipping_kecamatan();
				});
		    </script>
	  <?php
    }

    function js_query_kecamatan_billing_form(){
        $kec_url = admin_url('admin-ajax.php');
        wp_enqueue_script('ajax_billing_kec',plugins_url('/js/billing_kecamatan.js',__FILE__), array('jquery'));
            wp_localize_script( 'ajax_billing_kec', 'PT_Ajax_Bill_Kec', array(
                   'ajaxurl'       => $kec_url,
                   'nextNonce'     => wp_create_nonce('myajax-next-nonce'),
            ));

      ?>
        <script type="text/javascript">
        jQuery(document).ready(function($){
                                    billing_kecamatan();
        });
        </script>
        <?php	
    }

    function js_query_courier_billing_form(){
        $kec_url = admin_url('admin-ajax.php');
        wp_enqueue_script('ajax_billing_courier',plugins_url('/js/billing_courier.js',__FILE__), array('jquery'));
        wp_localize_script( 'ajax_billing_courier', 'PT_Ajax_Bill_Courier', array(
               'ajaxurl'       => $kec_url,
               'nextNonce'     => wp_create_nonce('myajax-next-nonce'),
        ));

      ?>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            billing_courier();
        });
        </script>
        <?php	
    }

    function js_query_courier_shipping_form(){
        $kec_url = admin_url('admin-ajax.php');
        wp_enqueue_script('ajax_shipping_courier',plugins_url('/js/shipping_courier.js',__FILE__), array('jquery'));
        wp_localize_script( 'ajax_shipping_courier', 'PT_Ajax_Ship_Courier', array(
               'ajaxurl'       => $kec_url,
               'nextNonce'     => wp_create_nonce('myajax-next-nonce'),
        ));

      ?>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            shipping_courier();
        });
        </script>
        <?php	
    }

    add_action('woocommerce_after_checkout_shipping_form','js_query_kecamatan_shipping_form');
    add_action('woocommerce_after_checkout_shipping_form','js_query_courier_shipping_form');
    add_action('woocommerce_after_checkout_billing_form','js_query_kecamatan_billing_form');
    add_action('woocommerce_after_checkout_billing_form','js_query_courier_billing_form');

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
 
function my_custom_checkout_field_update_order_meta( $order_id ) {
    global $current_user;
	$flag = false;
    if ( ! empty( $_POST['billing_address_3'] ) ) {
        update_post_meta( $order_id, 'billing_kelurahan', sanitize_text_field( $_POST['billing_address_3'] ) );
	update_user_meta( $current_user->ID, 'kelurahan', sanitize_text_field( $_POST['billing_address_3'] ) );
	$flag = true;
    }
    if ( ! empty( $_POST['billing_address_2'] ) ) {
        update_post_meta( $order_id, 'billing_kecamatan', sanitize_text_field( $_POST['billing_address_2'] ) );
    }

    if ( ! empty( $_POST['billing_address_4'] ) ) {
        update_post_meta( $order_id, 'billing_courier', sanitize_text_field( $_POST['billing_address_4'] ) );
    }
	
    if ( ! empty( $_POST['shipping_address_3'] ) ) {
        update_post_meta( $order_id, 'shipping_kelurahan', sanitize_text_field( $_POST['shipping_address_3'] ) );
        if (!$flag)
 	 update_user_meta( $current_user->ID, 'kelurahan', sanitize_text_field( $_POST['shipping_address_3'] ) );
    }
    if ( ! empty( $_POST['shipping_address_2'] ) ) {
        update_post_meta( $order_id, 'shipping_kecamatan', sanitize_text_field( $_POST['shipping_address_2'] ) );
    }
}
/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_billing_field_display_admin_order_meta', 10, 1 );

function my_custom_billing_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Kelurahan').':</strong> ' . get_post_meta( $order->id, 'billing_kelurahan', true ) . '</p>';
    echo '<p><strong>'.__('Kecamatan').':</strong> ' . get_post_meta( $order->id, 'billing_kecamatan', true ) . '</p>';
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_shipping_field_display_admin_order_meta', 10, 1 );

function my_custom_shipping_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Kelurahan').':</strong> ' . get_post_meta( $order->id, 'shipping_kelurahan', true ) . '</p>';
    echo '<p><strong>'.__('Kecamatan').':</strong> ' . get_post_meta( $order->id, 'shipping_kecamatan', true ) . '</p>';
}

    
} // end of woocommerce chek





function deactivate(){

}

register_deactivation_hook( __FILE__, 'deactivate');


add_action("template_redirect", 'roketin_theme_redirect');

function roketin_theme_redirect(){
    $plugindir = dirname( __FILE__ );
    if (get_the_title() == 'cekresi') {
        $templatefilename = 'cekresi.php';
        $return_template = $plugindir . '/templates/' . $templatefilename;
        do_theme_redirect($return_template);
    } else if (get_the_title() == 'Payment Confirmation') {
        $templatefilename = 'PaymentConfirmation.php';
        $return_template = $plugindir . '/templates/' . $templatefilename;
        do_theme_redirect($return_template);
    }
}

function do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}



add_action('woocommerce_after_cart_totals','epeken_disable_shipping_in_cart');

function epeken_disable_shipping_in_cart (){

 ?> <script language="javascript"> 
        var elements = document.getElementsByClassName('shipping'); 
        elements[0].style.display = 'none';
  </script><?php

}


// create a scheduled event (if it does not exist already)
function cronstarter_activation() {
	if( !wp_next_scheduled( 'mycronjob' ) ) {  
	   wp_schedule_event( strtotime('00:00:00'), 'daily', 'mycronjob' );  
	}
}
// and make sure it's called whenever WordPress loads
add_action('wp', 'cronstarter_activation');
// unschedule event upon plugin deactivation
function cronstarter_deactivate() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('mycronjob');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'mycronjob');
} 
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');


// here's the function we'd like to call with our cron job
function my_repeat_function() {
    $config = new Config;
    $cilent = new GuzzleHttp\Client();
    $user = new User;
    $endpoint = $config->getEndpoint();
    $types = ['tag', 'category', 'product'];

    foreach($types as $type){
        $response = $cilent->post(
            get_site_url() . '/wp-json/roketin/v1/syncAll',
            [
                'form_params' => [
                    'type' => $type
                ]
            ]
        );
    }

}
 
// hook that function onto our scheduled event:
add_action ('mycronjob', 'my_repeat_function'); 



