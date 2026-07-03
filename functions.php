<?php
/**
 * LuxNova theme bootstrap.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LUXNOVA_VERSION', '1.0.0' );
define( 'LUXNOVA_DIR', trailingslashit( get_template_directory() ) );
define( 'LUXNOVA_URI', trailingslashit( get_template_directory_uri() ) );

require_once LUXNOVA_DIR . 'inc/helpers.php';
require_once LUXNOVA_DIR . 'inc/setup.php';
require_once LUXNOVA_DIR . 'inc/enqueue.php';
require_once LUXNOVA_DIR . 'inc/custom-post-types.php';
require_once LUXNOVA_DIR . 'inc/theme-options.php';
require_once LUXNOVA_DIR . 'inc/acf/fields.php';
