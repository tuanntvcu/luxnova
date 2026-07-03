<?php
/**
 * Site header.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$brand        = luxnova_get_option( 'brand_logo_text', 'LUXNOVA' );
$tagline      = luxnova_get_option( 'brand_tagline', 'Interior Design & Build' );
$header_cta   = luxnova_get_option( 'header_cta', array( 'url' => '#lien-he', 'title' => 'Đặt lịch tư vấn', 'target' => '' ) );
$description  = get_bloginfo( 'description' );
$schema_image = luxnova_image_url( luxnova_get_option( 'default_og_image', '' ), 'large', 'assets/images/placeholder-hero.svg' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#06111d">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo esc_attr( wp_get_document_title() ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $schema_image ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'luxnova' ); ?></a>
<header class="site-header" data-site-header>
	<div class="site-header__inner">
		<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<span class="site-brand__name"><?php echo esc_html( $brand ); ?></span>
			<span class="site-brand__tagline"><?php echo esc_html( $tagline ); ?></span>
		</a>

		<nav class="primary-nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'luxnova' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'primary-nav__list',
					'fallback_cb' => 'luxnova_primary_menu_fallback_v2',
				)
			);
			?>
		</nav>

		<div class="site-header__actions">
			<?php echo luxnova_link( $header_cta, 'button button--gold site-header__cta js-consultation-modal', 'Đặt lịch tư vấn' ); ?>
			<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" data-menu-toggle>
				<span class="screen-reader-text"><?php esc_html_e( 'Toggle menu', 'luxnova' ); ?></span>
				<?php echo luxnova_icon( 'menu' ); ?>
			</button>
		</div>
	</div>
</header>

<main id="main-content" class="site-main">
<?php
function luxnova_primary_menu_fallback(): void {
	echo '<ul class="primary-nav__list">';
	$items = array(
		array( 'label' => 'Trang chủ', 'url' => home_url( '/' ) ),
		array( 'label' => 'Dự án', 'url' => get_post_type_archive_link( 'luxnova_project' ) ?: '#' ),
		array( 'label' => 'Dịch vụ', 'url' => get_post_type_archive_link( 'luxnova_service' ) ?: '#' ),
		array( 'label' => 'Bảng giá', 'url' => '#' ),
		array( 'label' => 'Kiến thức', 'url' => get_permalink( get_option( 'page_for_posts' ) ) ?: '#' ),
		array( 'label' => 'Liên hệ', 'url' => '#lien-he' ),
	);
	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
	}
	echo '</ul>';
}

function luxnova_primary_menu_fallback_v2(): void {
	echo '<ul class="primary-nav__list">';
	$items = array(
		array( 'label' => 'Trang chủ', 'url' => home_url( '/' ), 'active' => is_front_page() ),
		array( 'label' => 'Dự án', 'url' => get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ), 'active' => luxnova_is_project_context() ),
		array( 'label' => 'Dịch vụ', 'url' => get_post_type_archive_link( 'luxnova_service' ) ?: '#', 'active' => is_post_type_archive( 'luxnova_service' ) || is_singular( 'luxnova_service' ) ),
		array( 'label' => 'Bảng giá', 'url' => '#', 'active' => false ),
		array( 'label' => 'Kiến thức', 'url' => get_permalink( get_option( 'page_for_posts' ) ) ?: '#', 'active' => is_home() || is_singular( 'post' ) ),
		array( 'label' => 'Liên hệ', 'url' => '#lien-he', 'active' => false ),
	);
	foreach ( $items as $item ) {
		printf(
			'<li class="%s"><a href="%s">%s</a></li>',
			! empty( $item['active'] ) ? 'current-menu-item' : '',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}
