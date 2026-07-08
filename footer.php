<?php
/**
 * Site footer.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$description = luxnova_get_option( 'footer_description', 'LuxNova - Đơn vị thiết kế & thi công nội thất cao cấp, mang đến không gian sống tinh tế, hiện đại và bền vững.' );
$phone       = luxnova_get_option( 'phone', '0968 888 168' );
$email       = luxnova_get_option( 'email', 'hello@luxnova.vn' );
$address     = luxnova_get_option( 'address', 'Tòa nhà HH1, KĐT Yên Hòa, Cầu Giấy, Hà Nội' );
$map_iframe  = luxnova_get_option( 'map_iframe', '' );
$map_image   = luxnova_get_option( 'map_image', '' );
$socials     = luxnova_get_option(
	'social_links',
	array(
		array( 'platform' => 'Facebook', 'url' => '#' ),
		array( 'platform' => 'Instagram', 'url' => '#' ),
		array( 'platform' => 'YouTube', 'url' => '#' ),
	)
);
$phone_digits = preg_replace( '/\D+/', '', (string) $phone );
$facebook_url = '#';

foreach ( (array) $socials as $social ) {
	if ( ! is_array( $social ) || empty( $social['url'] ) ) {
		continue;
	}

	if ( 'facebook' === luxnova_social_platform_slug( $social ) ) {
		$facebook_url = (string) $social['url'];
		break;
	}
}

$phone_url = '' !== $phone_digits ? 'tel:' . $phone_digits : '#';
$zalo_url  = '' !== $phone_digits ? 'https://zalo.me/' . $phone_digits : '#';
?>
</main>

<footer class="site-footer" id="lien-he">
	<div class="container site-footer__grid">
		<div class="site-footer__brand">
			<?php echo luxnova_brand_markup( 'site-brand site-brand--footer' ); ?>
			<p><?php echo esc_html( $description ); ?></p>
			<ul class="social-list" aria-label="<?php esc_attr_e( 'Social links', 'luxnova' ); ?>">
				<?php foreach ( (array) $socials as $social ) : ?>
					<?php if ( ! is_array( $social ) ) { continue; } ?>
					<?php if ( empty( $social['url'] ) ) { continue; } ?>
					<li><a href="<?php echo esc_url( $social['url'] ); ?>" aria-label="<?php echo esc_attr( luxnova_social_label( $social ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo luxnova_social_icon_media( $social ); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<p class="site-footer__copy">© <?php echo esc_html( gmdate( 'Y' ) ); ?> LuxNova. All rights reserved.</p>
		</div>

		<div>
			<h2><?php esc_html_e( 'Liên kết', 'luxnova' ); ?></h2>
			<?php wp_nav_menu( array( 'theme_location' => 'footer_links', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => 'luxnova_footer_links_fallback' ) ); ?>
		</div>

		<div>
			<h2><?php esc_html_e( 'Dịch vụ', 'luxnova' ); ?></h2>
			<?php wp_nav_menu( array( 'theme_location' => 'footer_services', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => 'luxnova_footer_services_fallback' ) ); ?>
		</div>

		<div>
			<h2><?php esc_html_e( 'Hỗ trợ', 'luxnova' ); ?></h2>
			<?php wp_nav_menu( array( 'theme_location' => 'footer_support', 'container' => false, 'menu_class' => 'footer-menu', 'fallback_cb' => 'luxnova_footer_support_fallback' ) ); ?>
		</div>

		<address class="site-footer__contact">
			<h2><?php esc_html_e( 'Thông tin liên hệ', 'luxnova' ); ?></h2>
			<p><?php echo luxnova_icon( 'phone' ); ?><a href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', (string) $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
			<p><?php echo luxnova_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
			<p><?php echo luxnova_icon( 'pin' ); ?><span><?php echo esc_html( $address ); ?></span></p>
			<?php
			$footer_map_embed = luxnova_map_embed( $map_iframe, 'site-footer__map', __( 'LuxNova map location', 'luxnova' ) );
			echo $footer_map_embed ?: luxnova_image( $map_image, 'medium', array( 'class' => 'site-footer__map', 'alt' => esc_attr__( 'LuxNova map location', 'luxnova' ) ), 'assets/images/placeholder-map.svg' );
			?>
		</address>
	</div>
</footer>

<?php get_template_part( 'template-parts/modal/consultation' ); ?>

<aside class="floating-actions" aria-label="<?php esc_attr_e( 'Quick contact actions', 'luxnova' ); ?>" data-floating-actions>
	<div class="floating-actions__contacts">
		<a class="floating-actions__item floating-actions__item--facebook" href="<?php echo esc_url( $facebook_url ); ?>" aria-label="<?php esc_attr_e( 'Facebook LuxNova', 'luxnova' ); ?>" target="_blank" rel="noopener noreferrer">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 8h2V4h-2c-3 0-5 2-5 5v2H7v4h3v5h4v-5h3l1-4h-4V9c0-.6.4-1 1-1Z"/></svg>
		</a>
		<a class="floating-actions__item floating-actions__item--phone" href="<?php echo esc_url( $phone_url ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Call LuxNova %s', $phone ) ); ?>">
			<?php echo luxnova_icon( 'phone' ); ?>
		</a>
		<a class="floating-actions__item floating-actions__item--zalo" href="<?php echo esc_url( $zalo_url ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Zalo LuxNova %s', $phone ) ); ?>" target="_blank" rel="noopener noreferrer">
			<span aria-hidden="true">Zalo</span>
		</a>
	</div>
	<button class="floating-actions__top" type="button" aria-label="<?php esc_attr_e( 'Scroll to top', 'luxnova' ); ?>" data-scroll-top>
		<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 15 7-7 7 7"/></svg>
	</button>
</aside>

<?php wp_footer(); ?>
</body>
</html>
<?php
function luxnova_footer_links_fallback(): void {
	luxnova_footer_menu_fallback(
		array(
			array( 'label' => 'Trang chủ', 'url' => home_url( '/' ) ),
			array( 'label' => 'Dự án', 'url' => get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ) ),
			array( 'label' => 'Dịch vụ', 'url' => get_post_type_archive_link( 'luxnova_service' ) ?: home_url( '/dich-vu/' ) ),
			array( 'label' => 'Bảng giá', 'url' => home_url( '/bang-gia/' ) ),
			array( 'label' => 'Kiến thức', 'url' => luxnova_knowledge_url() ),
			array( 'label' => 'Liên hệ', 'url' => home_url( '/lien-he/' ) ),
		)
	);
}

function luxnova_footer_services_fallback(): void {
	luxnova_footer_menu_fallback(
		array(
			array( 'label' => 'Thiết kế nội thất', 'url' => luxnova_service_url_by_slug( 'thiet-ke-noi-that' ) ),
			array( 'label' => 'Thi công nội thất', 'url' => luxnova_service_url_by_slug( 'thi-cong-noi-that' ) ),
			array( 'label' => 'Nội thất trọn gói', 'url' => luxnova_service_url_by_slug( 'noi-that-tron-goi' ) ),
			array( 'label' => 'Home Audit™', 'url' => home_url( '/#home-audit' ) ),
		)
	);
}

function luxnova_footer_support_fallback(): void {
	echo '<ul class="footer-menu">';
	$items = array(
		array( 'label' => 'Quy trình làm việc', 'url' => home_url( '/dich-vu/#service-process' ) ),
		array( 'label' => 'Câu hỏi thường gặp', 'url' => home_url( '/faq/' ) ),
		array( 'label' => 'Liên hệ', 'url' => home_url( '/lien-he/' ) ),
	);

	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
	}
	echo '</ul>';
}

function luxnova_footer_menu_fallback( array $items ): void {
	echo '<ul class="footer-menu">';
	foreach ( $items as $item ) {
		if ( is_array( $item ) ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( $item['url'] ?? '#' ), esc_html( $item['label'] ?? '' ) );
		} else {
			printf( '<li><a href="#">%s</a></li>', esc_html( $item ) );
		}
	}
	echo '</ul>';
}
