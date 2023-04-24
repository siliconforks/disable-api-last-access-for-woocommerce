<?php
/**
 * Plugin Name: Disable API Last Access for WooCommerce
 * Description: For every call to the WooCommerce REST API, WooCommerce updates a database field storing the last access time.  This plugin disables that feature entirely.
 * Update URI: false
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/includes/query.php';
