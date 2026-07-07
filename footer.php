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

<?php wp_footer(); ?>
</body>
</html>
<?php
function luxnova_footer_links_fallback(): void {
	luxnova_footer_menu_fallback( array( 'Trang chủ', 'Dự án', 'Dịch vụ', 'Bảng giá', 'Kiến thức', 'Liên hệ' ) );
}

function luxnova_footer_services_fallback(): void {
	luxnova_footer_menu_fallback( array( 'Thiết kế nội thất', 'Thi công nội thất', 'Nội thất trọn gói', 'Home Audit™' ) );
}

function luxnova_footer_support_fallback(): void {
	echo '<ul class="footer-menu">';
	$items = array(
		array( 'label' => 'Chính sách bảo hành', 'url' => home_url( '/faq/' ) ),
		array( 'label' => 'Quy trình làm việc', 'url' => home_url( '/faq/' ) ),
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
		printf( '<li><a href="#">%s</a></li>', esc_html( $item ) );
	}
	echo '</ul>';
}
