<?php
/**
 * Plugin Name: Disable API Last Access for WooCommerce
 * Description: For every call to the WooCommerce REST API, WooCommerce updates a database field storing the last access time.  This plugin disables that feature entirely.
 * Update URI: false
 */

/*
Copyright (C) 2023  siliconforks

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/includes/query.php';
