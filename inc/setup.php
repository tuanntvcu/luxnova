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

add_filter( 'nav_menu_css_class', 'luxnova_nav_active_class', 10, 4 );
function luxnova_nav_active_class( array $classes, WP_Post $menu_item ): array {
	$title = strtolower( remove_accents( wp_strip_all_tags( $menu_item->title ) ) );
	$url   = untrailingslashit( (string) $menu_item->url );

	if (
		( luxnova_is_project_context() && ( 'du an' === $title || untrailingslashit( get_post_type_archive_link( 'luxnova_project' ) ?: '' ) === $url ) )
		|| ( luxnova_is_service_context() && ( 'dich vu' === $title || untrailingslashit( get_post_type_archive_link( 'luxnova_service' ) ?: '' ) === $url ) )
		|| ( luxnova_is_pricing_context() && ( 'bang gia' === $title || untrailingslashit( home_url( '/bang-gia/' ) ) === $url ) )
		|| ( luxnova_is_knowledge_context() && ( 'kien thuc' === $title || untrailingslashit( luxnova_knowledge_url() ) === $url ) )
	) {
		$classes[] = 'current-menu-item';
	}

	return array_unique( $classes );
}

add_filter( 'nav_menu_link_attributes', 'luxnova_nav_link_attributes', 10, 4 );
function luxnova_nav_link_attributes( array $atts, WP_Post $menu_item ): array {
	$title = strtolower( remove_accents( wp_strip_all_tags( $menu_item->title ) ) );

	if ( 'du an' === $title ) {
		$atts['href'] = get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' );
	} elseif ( 'dich vu' === $title ) {
		$atts['href'] = get_post_type_archive_link( 'luxnova_service' ) ?: home_url( '/dich-vu/' );
	} elseif ( 'bang gia' === $title ) {
		$atts['href'] = home_url( '/bang-gia/' );
	} elseif ( 'kien thuc' === $title ) {
		$atts['href'] = luxnova_knowledge_url();
	}

	return $atts;
}

function luxnova_is_project_context(): bool {
	return is_post_type_archive( 'luxnova_project' ) || is_singular( 'luxnova_project' ) || is_tax( 'luxnova_project_type' );
}

function luxnova_is_service_context(): bool {
	return is_post_type_archive( 'luxnova_service' ) || is_singular( 'luxnova_service' );
}

function luxnova_is_pricing_context(): bool {
	return is_page( 'bang-gia' ) || luxnova_is_pricing_request_path();
}

function luxnova_knowledge_url(): string {
	return home_url( '/kien-thuc/' );
}

function luxnova_is_knowledge_context(): bool {
	return is_page( 'kien-thuc' ) || ( is_home() && ! is_front_page() ) || is_singular( 'post' ) || luxnova_is_knowledge_request_path();
}

function luxnova_is_pricing_request_path(): bool {
	return luxnova_is_request_path( 'bang-gia' );
}

function luxnova_is_knowledge_request_path(): bool {
	return luxnova_is_request_path( 'kien-thuc' ) || 0 < luxnova_knowledge_paged_from_request();
}

function luxnova_knowledge_paged_from_request(): int {
	$request_path = luxnova_current_relative_request_path();

	if ( preg_match( '#^kien-thuc/page/([0-9]+)/?$#', $request_path, $matches ) ) {
		return max( 1, (int) $matches[1] );
	}

	return 0;
}

function luxnova_is_request_path( string $path ): bool {
	return trim( $path, '/' ) === luxnova_current_relative_request_path();
}

function luxnova_current_relative_request_path(): string {
	$request_path = trim( (string) wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	$home_path    = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );

	if ( '' !== $home_path && str_starts_with( $request_path, $home_path ) ) {
		$request_path = trim( substr( $request_path, strlen( $home_path ) ), '/' );
	}

	return $request_path;
}

add_filter( 'template_include', 'luxnova_pricing_template_include' );
function luxnova_pricing_template_include( string $template ): string {
	if ( luxnova_is_pricing_context() ) {
		$pricing_template = LUXNOVA_DIR . 'page-pricing.php';

		if ( file_exists( $pricing_template ) ) {
			global $wp_query;

			if ( $wp_query instanceof WP_Query ) {
				$wp_query->is_404  = false;
				$wp_query->is_page = true;
			}

			status_header( 200 );
			return $pricing_template;
		}
	}

	return $template;
}

add_filter( 'template_include', 'luxnova_knowledge_template_include' );
function luxnova_knowledge_template_include( string $template ): string {
	if ( luxnova_is_knowledge_request_path() || is_page( 'kien-thuc' ) || ( is_home() && ! is_front_page() ) ) {
		$knowledge_template = LUXNOVA_DIR . 'page-kien-thuc.php';

		if ( file_exists( $knowledge_template ) ) {
			global $wp_query;

			if ( $wp_query instanceof WP_Query && luxnova_is_knowledge_request_path() ) {
				$wp_query->is_404  = false;
				$wp_query->is_page = true;
			}

			status_header( 200 );
			return $knowledge_template;
		}
	}

	return $template;
}

add_filter( 'pre_get_document_title', 'luxnova_pricing_document_title' );
function luxnova_pricing_document_title( string $title ): string {
	if ( luxnova_is_pricing_context() ) {
		return sprintf( 'Bảng giá - %s', get_bloginfo( 'name' ) );
	}

	return $title;
}

add_filter( 'pre_get_document_title', 'luxnova_knowledge_document_title' );
function luxnova_knowledge_document_title( string $title ): string {
	if ( luxnova_is_knowledge_request_path() || is_page( 'kien-thuc' ) || ( is_home() && ! is_front_page() ) ) {
		return sprintf( 'Kiến thức - %s', get_bloginfo( 'name' ) );
	}

	return $title;
}
