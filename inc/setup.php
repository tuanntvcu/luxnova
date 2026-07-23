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
	add_image_size( 'luxnova-hero-mobile', 900, 1200, true );
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
function luxnova_nav_active_class( array $classes, object $menu_item ): array {
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

add_filter( 'wp_nav_menu_objects', 'luxnova_primary_menu_without_featured_projects', 10, 2 );
function luxnova_primary_menu_without_featured_projects( array $items, stdClass $args ): array {
	if ( 'primary' !== ( $args->theme_location ?? '' ) ) {
		return $items;
	}

	$featured_url = untrailingslashit( luxnova_featured_projects_url() );

	return array_values(
		array_filter(
			$items,
			static function ( object $item ) use ( $featured_url ): bool {
				$title = strtolower( remove_accents( wp_strip_all_tags( (string) ( $item->title ?? '' ) ) ) );
				$url   = untrailingslashit( (string) ( $item->url ?? '' ) );

				return ! in_array( $title, array( 'case study', 'case studies', 'du an tieu bieu' ), true )
					&& $featured_url !== $url;
			}
		)
	);
}

add_filter( 'wp_nav_menu_objects', 'luxnova_footer_support_menu_items', 20, 2 );
function luxnova_footer_support_menu_items( array $items, stdClass $args ): array {
	if ( 'footer_support' !== ( $args->theme_location ?? '' ) ) {
		return $items;
	}

	return array_values(
		array_filter(
			$items,
			static function ( object $item ): bool {
				$title = strtolower( remove_accents( wp_strip_all_tags( (string) ( $item->title ?? '' ) ) ) );
				return 'chinh sach bao hanh' !== $title;
			}
		)
	);
}

add_filter( 'nav_menu_link_attributes', 'luxnova_nav_link_attributes', 10, 4 );
function luxnova_nav_link_attributes( array $atts, object $menu_item ): array {
	$title = strtolower( remove_accents( wp_strip_all_tags( $menu_item->title ) ) );
	$mapped_url = luxnova_menu_url_for_title( $title );

	if ( '' !== $mapped_url ) {
		$atts['href'] = $mapped_url;
	}

	return $atts;
}

function luxnova_menu_url_for_title( string $title ): string {
	$service_urls = array(
		'thiet ke noi that' => luxnova_service_url_by_slug( 'thiet-ke-noi-that' ),
		'thi cong noi that' => luxnova_service_url_by_slug( 'thi-cong-noi-that' ),
		'noi that tron goi' => luxnova_service_url_by_slug( 'noi-that-tron-goi' ),
	);

	$urls = array(
		'trang chu' => home_url( '/' ),
		'home' => home_url( '/' ),
		'du an' => get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ),
		'dich vu' => get_post_type_archive_link( 'luxnova_service' ) ?: home_url( '/dich-vu/' ),
		'phong cach thiet ke' => luxnova_design_styles_url(),
		'bang gia' => home_url( '/bang-gia/' ),
		'kien thuc' => luxnova_knowledge_url(),
		'lien he' => home_url( '/lien-he/' ),
		'faq' => home_url( '/faq/' ),
		'cau hoi thuong gap' => home_url( '/faq/' ),
		'quy trinh lam viec' => home_url( '/dich-vu/#service-process' ),
		'home audit' => home_url( '/#home-audit' ),
		'home audittm' => home_url( '/#home-audit' ),
		'home audit™' => home_url( '/#home-audit' ),
	);

	$urls = array_merge( $urls, array_filter( $service_urls ) );

	return $urls[ $title ] ?? '';
}

function luxnova_service_url_by_slug( string $slug ): string {
	$post = get_page_by_path( $slug, OBJECT, 'luxnova_service' );
	if ( $post instanceof WP_Post ) {
		return get_permalink( $post );
	}

	return get_post_type_archive_link( 'luxnova_service' ) ?: home_url( '/dich-vu/' );
}

function luxnova_is_project_context(): bool {
	return is_post_type_archive( 'luxnova_project' ) || is_singular( 'luxnova_project' ) || is_tax( 'luxnova_project_type' );
}

function luxnova_featured_projects_url(): string {
	return home_url( '/du-an-tieu-bieu/' );
}

function luxnova_is_featured_projects_context(): bool {
	return is_page( 'du-an-tieu-bieu' ) || luxnova_is_featured_projects_request_path();
}

function luxnova_is_service_context(): bool {
	return is_post_type_archive( 'luxnova_service' ) || is_singular( 'luxnova_service' );
}

function luxnova_design_styles_url(): string {
	return home_url( '/phong-cach-thiet-ke/' );
}

function luxnova_is_design_styles_context(): bool {
	return is_page_template( array( 'page-phong-cach-thiet-ke.php', 'page-chi-tiet-phong-cach-thiet-ke.php' ) ) || luxnova_is_design_styles_request_path();
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

function luxnova_is_design_styles_request_path(): bool {
	$request_path = luxnova_current_relative_request_path();

	return 'phong-cach-thiet-ke' === $request_path || str_starts_with( $request_path, 'phong-cach-thiet-ke/' );
}

function luxnova_is_featured_projects_request_path(): bool {
	return luxnova_is_request_path( 'du-an-tieu-bieu' );
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

add_action( 'template_redirect', 'luxnova_hide_featured_projects_page' );
function luxnova_hide_featured_projects_page(): void {
	if ( ! luxnova_is_featured_projects_context() && ! is_page_template( 'page-du-an-tieu-bieu.php' ) ) {
		return;
	}

	global $wp_query;

	if ( $wp_query instanceof WP_Query ) {
		$wp_query->set_404();
	}

	status_header( 404 );
	nocache_headers();
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
