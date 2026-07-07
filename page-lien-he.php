<?php
/**
 * Contact page template.
 *
 * Template Name: LuxNova Contact
 *
 * @package LuxNova
 */

get_header();

$page_data     = luxnova_contact_page_data();
$hero          = $page_data['hero'] ?? array();
$trust_items   = $page_data['trust_items'] ?? array();
$contact_items = $page_data['contact_items'] ?? array();
$map           = $page_data['map'] ?? array();
$closing_cta   = $page_data['closing_cta'] ?? array();
$map_query     = luxnova_get_option( 'address', '' );

foreach ( $contact_items as $item ) {
	if ( 'pin' === ( $item['icon'] ?? '' ) && ! empty( $item['content'] ) ) {
		$map_query = (string) $item['content'];
		break;
	}
}
?>
<section class="contact-hero">
	<div class="contact-hero__media" aria-hidden="true">
		<?php echo luxnova_responsive_image( $hero['image'] ?? '', $hero['mobile_image'] ?? '', 'luxnova-hero', array( 'class' => 'contact-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-service-2.svg' ); ?>
	</div>
	<div class="contact-hero__overlay"></div>
	<div class="container contact-hero__content reveal-on-scroll">
		<?php if ( ! empty( $hero['eyebrow'] ) ) : ?>
			<p class="contact-hero__eyebrow"><?php echo esc_html( $hero['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1>
			<?php echo esc_html( $hero['title'] ?? '' ); ?>
			<?php if ( ! empty( $hero['highlight'] ) ) : ?>
				<span><?php echo esc_html( $hero['highlight'] ); ?></span>
			<?php endif; ?>
			<?php echo esc_html( $hero['title_suffix'] ?? '' ); ?>
		</h1>
		<?php if ( ! empty( $hero['description'] ) ) : ?>
			<p><?php echo esc_html( $hero['description'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $trust_items ) ) : ?>
			<div class="contact-hero__trust">
				<?php foreach ( $trust_items as $item ) : ?>
					<div>
						<?php echo luxnova_icon_media( $item, 'shield' ); ?>
						<span><?php echo nl2br( esc_html( $item['label'] ?? '' ) ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="contact-main">
	<div class="container contact-main__grid">
		<div class="contact-form-panel reveal-on-scroll">
			<header class="service-section-heading">
				<h2><?php echo esc_html( $page_data['form_heading'] ?? '' ); ?></h2>
			</header>

			<form class="consultation-form contact-form" data-consultation-form>
				<div class="consultation-form__grid consultation-form__grid--two">
					<label>
						<span>Họ và tên <em>*</em></span>
						<input type="text" name="fullname" autocomplete="name" placeholder="Nhập họ và tên" required>
					</label>
					<label>
						<span>Số điện thoại <em>*</em></span>
						<input type="tel" name="phone" autocomplete="tel" placeholder="Nhập số điện thoại" required>
					</label>
				</div>

				<label>
					<span>Email</span>
					<input type="email" name="email" autocomplete="email" placeholder="Nhập email của bạn">
				</label>

				<label>
					<span>Dịch vụ quan tâm</span>
					<select name="project_type">
						<option value="">Chọn dịch vụ quan tâm</option>
						<option>Thiết kế nội thất</option>
						<option>Thi công nội thất</option>
						<option>Nội thất trọn gói</option>
						<option>Home Audit</option>
						<option>Không gian thương mại</option>
					</select>
				</label>

				<label>
					<span>Nội dung yêu cầu</span>
					<textarea name="message" rows="5" placeholder="Bạn vui lòng chia sẻ thêm về nhu cầu hoặc ý tưởng của mình..."></textarea>
				</label>

				<label class="consultation-form__policy">
					<input type="checkbox" name="privacy" required>
					<span>Tôi đồng ý với <a href="#" target="_blank" rel="noopener noreferrer">Chính sách bảo mật</a> của LuxNova.</span>
				</label>

				<button class="button button--gold consultation-form__submit" type="submit" data-consultation-submit>Gửi yêu cầu tư vấn <span aria-hidden="true">→</span></button>
				<p class="consultation-form__message consultation-form__message--success" data-consultation-success aria-live="polite" hidden>Cảm ơn bạn. LuxNova đã nhận được yêu cầu tư vấn và sẽ liên hệ sớm.</p>
				<p class="consultation-form__message consultation-form__message--error" data-consultation-error aria-live="polite" hidden>Không thể gửi yêu cầu lúc này. Vui lòng thử lại sau.</p>
			</form>
		</div>

		<aside class="contact-info-panel reveal-on-scroll">
			<header class="service-section-heading">
				<h2><?php echo esc_html( $page_data['info_heading'] ?? '' ); ?></h2>
			</header>
			<div class="contact-info-list">
				<?php foreach ( $contact_items as $item ) : ?>
					<div class="contact-info-item">
						<span class="contact-info-item__icon"><?php echo luxnova_icon_media( $item, 'pin' ); ?></span>
						<div>
							<strong><?php echo esc_html( $item['title'] ?? '' ); ?></strong>
							<?php if ( ! empty( $item['url'] ) ) : ?>
								<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo nl2br( esc_html( $item['content'] ?? '' ) ); ?></a>
							<?php else : ?>
								<p><?php echo nl2br( esc_html( $item['content'] ?? '' ) ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</aside>
	</div>
</section>

<section class="contact-map-section">
	<div class="container">
		<div class="contact-map reveal-on-scroll">
			<?php
			$contact_map_embed = luxnova_map_embed( $map['iframe'] ?? '', 'contact-map__iframe', __( 'LuxNova office map', 'luxnova' ) );
			echo $contact_map_embed ?: luxnova_image( $map['image'] ?? '', 'large', array( 'class' => 'contact-map__image', 'alt' => esc_attr__( 'LuxNova office map', 'luxnova' ) ), 'assets/images/placeholder-map.svg' );
			?>
			<div class="contact-map__card">
				<p class="contact-map__label"><?php echo esc_html( $map['label'] ?? '' ); ?></p>
				<?php if ( ! empty( $map['description'] ) ) : ?>
					<p><?php echo esc_html( $map['description'] ); ?></p>
				<?php endif; ?>
				<a class="button button--outline" href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( $map_query ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $map['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
			</div>
		</div>
	</div>
</section>

<section class="contact-closing-cta">
	<div class="contact-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( $closing_cta['image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $closing_cta['image_fallback'] ?? 'assets/images/placeholder-interior.svg' ); ?>
	</div>
	<div class="container contact-closing-cta__inner">
		<div>
			<?php if ( ! empty( $closing_cta['eyebrow'] ) ) : ?>
				<p><?php echo esc_html( $closing_cta['eyebrow'] ); ?></p>
			<?php endif; ?>
			<h2><?php echo esc_html( $closing_cta['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $closing_cta['description'] ) ) : ?>
				<span><?php echo esc_html( $closing_cta['description'] ); ?></span>
			<?php endif; ?>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $closing_cta['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
