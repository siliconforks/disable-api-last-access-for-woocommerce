=== Disable API Last Access for WooCommerce ===
Contributors: siliconforks
Tags: disable, rest-api, woocommerce, performance
Requires at least: 6.2
Tested up to: 6.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

For every call to the WooCommerce REST API, WooCommerce updates a database field storing the last access time.  This plugin disables that feature.

== Description ==

WooCommerce has a database table `woocommerce_api_keys` which stores API keys which can be used to access the WooCommerce REST API.
This table has a column `last_access` which stores the time that the API key was last used to make an API call.
Because this column is updated for every API call, each API call will trigger a write to the database (even if the API call itself is read-only).
This can have a negative effect on performance for a site that gets a lot of API calls.

This plugin simply prevents WooCommerce from updating the `last_access` column on every API call.
