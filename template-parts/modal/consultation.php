<?php
/**
 * Consultation modal.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$modal_data = luxnova_consultation_modal_data();
$benefits   = $modal_data['benefits'] ?? array();
?>
<div class="consultation-modal" id="consultation-modal" aria-hidden="true" hidden>
	<div class="consultation-modal__backdrop" data-consultation-close></div>
	<div class="consultation-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="consultation-modal-title" tabindex="-1">
		<div class="consultation-modal__form-panel">
			<?php if ( ! empty( $modal_data['eyebrow'] ) ) : ?>
				<p class="consultation-modal__eyebrow"><?php echo esc_html( $modal_data['eyebrow'] ); ?></p>
			<?php endif; ?>
			<h2 id="consultation-modal-title"><?php echo esc_html( $modal_data['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $modal_data['intro'] ) ) : ?>
				<p class="consultation-modal__intro"><?php echo esc_html( $modal_data['intro'] ); ?></p>
			<?php endif; ?>

			<form class="consultation-form" data-consultation-form>
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
					<span>Loại công trình</span>
					<select name="project_type">
						<option value="">Chọn loại công trình</option>
						<option>Căn hộ</option>
						<option>Nhà phố</option>
						<option>Biệt thự</option>
						<option>Penthouse</option>
						<option>Không gian thương mại</option>
					</select>
				</label>

				<div class="consultation-form__grid consultation-form__grid--two">
					<label>
						<span>Thời gian mong muốn</span>
						<input type="date" name="preferred_date">
					</label>
					<label>
						<span>Ngân sách dự kiến</span>
						<select name="budget">
							<option value="">Chọn khoảng ngân sách</option>
							<option>Dưới 300 triệu</option>
							<option>300 - 600 triệu</option>
							<option>600 triệu - 1 tỷ</option>
							<option>Trên 1 tỷ</option>
						</select>
					</label>
				</div>

				<label>
					<span>Nội dung tư vấn</span>
					<textarea name="message" rows="4" placeholder="Mô tả nhu cầu của bạn..."></textarea>
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

		<div class="consultation-modal__visual-panel">
			<button class="consultation-modal__close" type="button" aria-label="Đóng modal" data-consultation-close>
				<span aria-hidden="true">×</span>
			</button>
			<?php echo luxnova_image( $modal_data['image'] ?? '', 'luxnova-card', array( 'class' => 'consultation-modal__image', 'alt' => '' ), $modal_data['image_fallback'] ?? 'assets/images/placeholder-service-2.svg' ); ?>
			<?php if ( ! empty( $benefits ) ) : ?>
				<div class="consultation-modal__benefits">
					<?php foreach ( $benefits as $benefit ) : ?>
						<div>
							<span><?php echo luxnova_icon_media( $benefit, 'shield' ); ?></span>
							<strong><?php echo esc_html( $benefit['title'] ?? '' ); ?></strong>
							<?php if ( ! empty( $benefit['description'] ) ) : ?>
								<p><?php echo esc_html( $benefit['description'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
