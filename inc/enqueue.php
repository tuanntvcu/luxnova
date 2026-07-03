<?php
/**
 * Asset loading.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'luxnova_enqueue_assets' );
function luxnova_enqueue_assets(): void {
	$css_path = LUXNOVA_DIR . 'assets/css/main.css';
	$js_path  = LUXNOVA_DIR . 'assets/js/main.js';

	wp_enqueue_style(
		'luxnova-main',
		LUXNOVA_URI . 'assets/css/main.css',
		array(),
		file_exists( $css_path ) ? (string) filemtime( $css_path ) : LUXNOVA_VERSION
	);

	wp_enqueue_script(
		'luxnova-main',
		LUXNOVA_URI . 'assets/js/main.js',
		array(),
		file_exists( $js_path ) ? (string) filemtime( $js_path ) : LUXNOVA_VERSION,
		true
	);

	wp_localize_script(
		'luxnova-main',
		'LuxNovaConsultation',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'luxnova_consultation_form' ),
		)
	);
}

add_filter( 'script_loader_tag', 'luxnova_defer_scripts', 10, 3 );
function luxnova_defer_scripts( string $tag, string $handle, string $src ): string {
	if ( 'luxnova-main' !== $handle ) {
		return $tag;
	}

	return sprintf(
		'<script src="%s" id="%s-js" defer></script>' . "\n",
		esc_url( $src ),
		esc_attr( $handle )
	);
}

add_action( 'wp_head', 'luxnova_print_schema', 20 );
function luxnova_print_schema(): void {
	$schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'LocalBusiness',
		'name' => luxnova_get_option( 'brand_logo_text', 'LuxNova' ),
		'description' => get_bloginfo( 'description' ),
		'url' => home_url( '/' ),
		'telephone' => luxnova_get_option( 'phone', '0968 888 168' ),
		'email' => luxnova_get_option( 'email', 'hello@luxnova.vn' ),
		'address' => array(
			'@type' => 'PostalAddress',
			'streetAddress' => luxnova_get_option( 'address', 'Tòa nhà HH1, KĐT Yên Hòa, Cầu Giấy, Hà Nội' ),
			'addressCountry' => 'VN',
		),
		'image' => luxnova_image_url( luxnova_get_option( 'default_og_image', '' ), 'large', 'assets/images/placeholder-hero.svg' ),
	);

	printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
}
