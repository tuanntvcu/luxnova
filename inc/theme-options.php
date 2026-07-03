<?php
/**
 * Theme option pages.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'luxnova_register_options_pages' );
function luxnova_register_options_pages(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => esc_html__( 'LuxNova Theme Settings', 'luxnova' ),
			'menu_title' => esc_html__( 'LuxNova Settings', 'luxnova' ),
			'menu_slug'  => 'luxnova-theme-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => false,
			'position'   => 59,
		)
	);
}
