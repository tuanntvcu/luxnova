<?php
/**
 * Theme setup.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'luxnova_setup' );
function luxnova_setup(): void {
	load_theme_textdomain( 'luxnova', LUXNOVA_DIR . 'languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_image_size( 'luxnova-hero', 1920, 1080, true );
	add_image_size( 'luxnova-card', 760, 520, true );
	add_image_size( 'luxnova-project', 620, 430, true );
	add_image_size( 'luxnova-avatar', 96, 96, true );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'luxnova' ),
			'footer_links' => esc_html__( 'Footer Links', 'luxnova' ),
			'footer_services' => esc_html__( 'Footer Services', 'luxnova' ),
			'footer_support' => esc_html__( 'Footer Support', 'luxnova' ),
		)
	);
}

add_filter( 'excerpt_length', 'luxnova_excerpt_length' );
function luxnova_excerpt_length(): int {
	return 24;
}

add_filter( 'nav_menu_css_class', 'luxnova_project_nav_active_class', 10, 4 );
function luxnova_project_nav_active_class( array $classes, WP_Post $menu_item ): array {
	if ( ! luxnova_is_project_context() ) {
		return $classes;
	}

	$title = strtolower( remove_accents( wp_strip_all_tags( $menu_item->title ) ) );
	$url   = untrailingslashit( (string) $menu_item->url );

	if ( 'du an' === $title || untrailingslashit( get_post_type_archive_link( 'luxnova_project' ) ?: '' ) === $url ) {
		$classes[] = 'current-menu-item';
	}

	return array_unique( $classes );
}

add_filter( 'nav_menu_link_attributes', 'luxnova_project_nav_link_attributes', 10, 4 );
function luxnova_project_nav_link_attributes( array $atts, WP_Post $menu_item ): array {
	$title = strtolower( remove_accents( wp_strip_all_tags( $menu_item->title ) ) );

	if ( 'du an' === $title ) {
		$atts['href'] = get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' );
	}

	return $atts;
}

function luxnova_is_project_context(): bool {
	return is_post_type_archive( 'luxnova_project' ) || is_singular( 'luxnova_project' ) || is_tax( 'luxnova_project_type' );
}
