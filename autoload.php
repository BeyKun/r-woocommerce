<?php

defined('ABSPATH') or die('Oppss! you can not access this file');

include_once(ABSPATH.'wp-admin/includes/plugin.php');

if (in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins'))) || array_key_exists( 'woocommerce/woocommerce.php', maybe_unserialize( get_site_option( 'active_sitewide_plugins') ) )) {

    if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	    return;
    }

    $classes = array (
        'Config/Config',
        'Roketin/Roketin',
        'Users/User',
        'Products/Tags/Tag',
        'Products/Category/Category',
        'Products/Products/Product',
        'Order/PaymentMethod',
        'Routes/Route',
        'Resource/RoketinView',
        'Resource/Menu/Menu'
    );

    $dir = dirname( __FILE__ );

    foreach ($classes as $class) {
        if (file_exists($dir . '/includes/' . $class . '.php')) {
            require_once ($dir . '/includes/' . $class . '.php');
        }
    }

    $payment = new PaymentMethod;
    // echo json_encode($payment->getPayment());
    foreach($payment->getPayment() as $method) {
        if (file_exists($dir . '/includes/Order/' . $method->bank_name . 'Register.php')) {
            require_once ($dir . '/includes/Order/' . $method->bank_name . 'Register.php');
        }
    }
    
    
}

