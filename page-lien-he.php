<?php
/**
 * Contact page template.
 *
 * Template Name: LuxNova Contact
 *
 * @package LuxNova
 */

get_header();

$phone     = luxnova_get_option( 'phone', '0968 888 168' );
$email     = luxnova_get_option( 'email', 'hello@luxnova.vn' );
$address   = luxnova_get_option( 'address', 'Tầng 5, Tòa nhà Harmony, 47-49-51 Phùng Khắc Khoan, P. Đa Kao, Quận 1, TP. Hồ Chí Minh' );
$map_image = luxnova_get_option( 'map_image', '' );
$facebook  = '#';
$socials   = luxnova_get_option( 'social_links', array() );

foreach ( (array) $socials as $social ) {
	if ( false !== stripos( (string) ( $social['platform'] ?? '' ), 'facebook' ) && ! empty( $social['url'] ) ) {
		$facebook = $social['url'];
		break;
	}
}

$contact_items = array(
	array(
		'icon' => 'pin',
		'title' => 'Địa chỉ',
		'content' => $address,
	),
	array(
		'icon' => 'phone',
		'title' => 'Số điện thoại',
		'content' => $phone,
		'url' => 'tel:' . preg_replace( '/\D+/', '', (string) $phone ),
	),
	array(
		'icon' => 'mail',
		'title' => 'Email',
		'content' => $email,
		'url' => 'mailto:' . $email,
	),
	array(
		'icon' => 'clock',
		'title' => 'Giờ làm việc',
		'content' => "Thứ 2 - Thứ 7: 8:30 - 17:30\nChủ nhật: 9:00 - 16:00",
	),
	array(
		'icon' => 'facebook',
		'title' => 'Fanpage',
		'content' => 'facebook.com/luxnova.vn',
		'url' => $facebook,
	),
);
?>
<section class="contact-hero">
	<div class="contact-hero__media" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-hero', array( 'class' => 'contact-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-service-2.svg' ); ?>
	</div>
	<div class="contact-hero__overlay"></div>
	<div class="container contact-hero__content reveal-on-scroll">
		<p class="contact-hero__eyebrow">Liên hệ</p>
		<h1>Chúng tôi luôn sẵn sàng <span>lắng nghe và đồng hành</span> cùng bạn</h1>
		<p>Hãy chia sẻ ý tưởng của bạn, LuxNova sẽ phản hồi trong thời gian sớm nhất để cùng bạn kiến tạo không gian sống lý tưởng.</p>
		<div class="contact-hero__trust">
			<div>
				<?php echo luxnova_icon( 'clock' ); ?>
				<span>Phản hồi nhanh chóng<br>trong 24h</span>
			</div>
			<div>
				<?php echo luxnova_icon( 'shield' ); ?>
				<span>Bảo mật thông tin<br>tuyệt đối</span>
			</div>
			<div>
				<?php echo luxnova_icon( 'phone' ); ?>
				<span>Tư vấn tận tâm<br>hoàn toàn miễn phí</span>
			</div>
		</div>
	</div>
</section>

<section class="contact-main">
	<div class="container contact-main__grid">
		<div class="contact-form-panel reveal-on-scroll">
			<header class="service-section-heading">
				<h2>Gửi yêu cầu tư vấn</h2>
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
				<h2>Thông tin liên hệ</h2>
			</header>
			<div class="contact-info-list">
				<?php foreach ( $contact_items as $item ) : ?>
					<div class="contact-info-item">
						<span class="contact-info-item__icon"><?php echo luxnova_icon( $item['icon'] ); ?></span>
						<div>
							<strong><?php echo esc_html( $item['title'] ); ?></strong>
							<?php if ( ! empty( $item['url'] ) ) : ?>
								<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo nl2br( esc_html( $item['content'] ) ); ?></a>
							<?php else : ?>
								<p><?php echo nl2br( esc_html( $item['content'] ) ); ?></p>
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
			<?php echo luxnova_image( $map_image, 'large', array( 'class' => 'contact-map__image', 'alt' => esc_attr__( 'LuxNova office map', 'luxnova' ) ), 'assets/images/placeholder-map.svg' ); ?>
			<div class="contact-map__card">
				<p class="contact-map__label">Ghé thăm văn phòng</p>
				<p>Chúng tôi rất hân hạnh được đón tiếp bạn tại văn phòng để trao đổi chi tiết hơn về dự án của bạn.</p>
				<a class="button button--outline" href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( (string) $address ); ?>" target="_blank" rel="noopener noreferrer">Chỉ đường <span aria-hidden="true">→</span></a>
			</div>
		</div>
	</div>
</section>

<section class="contact-closing-cta">
	<div class="contact-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-card', array( 'alt' => '' ), 'assets/images/placeholder-interior.svg' ); ?>
	</div>
	<div class="container contact-closing-cta__inner">
		<div>
			<p>Bắt đầu hành trình kiến tạo không gian sống</p>
			<h2>Đặt lịch tư vấn miễn phí cùng LuxNova</h2>
			<span>Đội ngũ kiến trúc sư giàu kinh nghiệm của chúng tôi sẽ đồng hành cùng bạn từ ý tưởng đến hiện thực.</span>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal">Đặt lịch tư vấn ngay <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
