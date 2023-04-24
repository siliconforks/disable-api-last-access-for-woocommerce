<?php

namespace siliconforks\disable_api_last_access_for_woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is for debugging purposes only and is disabled by default.
 *
 * If you want to enable it, create a plugin with the following code:
 *
 *     add_action( 'plugins_loaded', function () {
 *         if ( class_exists( '\siliconforks\disable_api_last_access_for_woocommerce\Logger' ) ) {
 *             \siliconforks\disable_api_last_access_for_woocommerce\Logger::$is_enabled = TRUE;
 *         }
 *     } );
 */
class Logger {
	public static $is_enabled = false;

	public static $num_updates = 0;

	public static function log_updates() {
		if ( self::$num_updates > 0 ) {
			if ( 1 === self::$num_updates ) {
				$message = 'Disabled last access update';
			} else {
				$message = sprintf( 'Disabled %d last access updates', self::$num_updates );
			}

			if ( isset( $_SERVER['REQUEST_URI'] ) ) {
				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				$request_uri = wp_unslash( $_SERVER['REQUEST_URI'] );

				$parameters = array(
					'oauth_consumer_key',
					'oauth_nonce',
					'oauth_signature',
					'consumer_key',
					'consumer_secret',
				);
				foreach ( $parameters as $parameter ) {
					// phpcs:disable WordPress.Security.NonceVerification.Recommended
					if ( isset( $_GET[ $parameter ] ) ) {
						// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
						$sensitive = wp_unslash( $_GET[ $parameter ] );

						$replacement = '...' . substr( $sensitive, -7, 7 );
						$request_uri = add_query_arg( $parameter, rawurlencode( $replacement ), $request_uri );
					}
					// phpcs:enable WordPress.Security.NonceVerification.Recommended
				}
				$message .= ' - ' . $request_uri;
			}

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( $message );
		}
	}
}

function query( $query ) {
	global $wpdb;

	if ( preg_match( '/^UPDATE `([^`]+)` SET `last_access` = \'[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\' WHERE `key_id` = [1-9][0-9]*$/', $query, $matches ) ) {
		$table = $matches[1];
		if ( $table === $wpdb->prefix . 'woocommerce_api_keys' ) {
			++Logger::$num_updates;
			return '';
		}
	}

	return $query;
}

function add_query_filter() {
	add_filter( 'query', __NAMESPACE__ . '\query' );
	if ( Logger::$is_enabled ) {
		add_action( 'shutdown', array( Logger::class, 'log_updates' ) );
	}
}

// Legacy WooCommerce API.
add_action( 'woocommerce_api_loaded', __NAMESPACE__ . '\add_query_filter' );

// WP REST API.
add_action( 'rest_api_init', __NAMESPACE__ . '\add_query_filter' );
