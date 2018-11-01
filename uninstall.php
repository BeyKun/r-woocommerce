<?php

/** 
* Trigger this file on Plugin uninstall
*
* @package Roketin
*/

if (!defined('WP_UNINSTALL_PLUIGIN'))
{
    die;
}

require_once __DIR__.'/vendor/autoload.php';
include_once(__DIR__ . '/includes/Config/Config.php');
include_once(__DIR__ . '/includes/Users/User.php');
include_once(__DIR__ . '/includes/Order/PaymentMethod.php');

global $wpdb;

$config = new Config;
$user = new User;
$payment = new PaymentMethod;
$SecretKey = $user->getSecretKey();
$dbs = $config->getDB();

$woocommerce = new Automattic\WooCommerce\Client(
    get_bloginfo("url"),
    $SecretKey["consumer_key"],
    $SecretKey["consumer_secret"],
    [
        "wp_api" => true,
        "version" => "wc/v2",
        "query_string_auth" => true
    ]
);

$delete = $wpdb->get_results("SELECT * FROM $db[id]");

foreach($delete as $data){
    if($data->type == 'category') {
        $woocommerce->delete('products/categories/' . $data->id_woocommerce, ['force' => true]);
    } else if ($data->type == 'tag') {
        $woocommerce->delete('products/tags/' . $data->id_woocommerce, ['force' => true]);
    } else if ($data->type == 'product') {
        $woocommerce->delete('products/' . $data->id_woocommerce , ['force' => true]);
    } else if ($data->type == 'product') {
        $woocommerce->delete('coupons/' . $data->id_woocommerce, ['force' => true]);
    }
}


foreach($payment->getPayment() as $method) {
    if (file_exists($dir . '/includes/Order/' . $method->bank_name . 'Register.php')) {
        unlink($dir . '/includes/Order/' . $method->bank_name . 'Register.php');
    }
    if (file_exists($dir . '/includes/Order/' . $method->bank_name . 'PaymentMethod.php')) {
        unlink($dir . '/includes/Order/' . $method->bank_name . 'PaymentMethod.php');
    }
}


foreach($dbs as $db){
    $wpdb->query("DROP TABEL $dbs");
}


