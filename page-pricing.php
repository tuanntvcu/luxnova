<?php
/**
 * Pricing page template.
 *
 * @package LuxNova
 */

get_header();
?>
<section class="pricing-page-hero">
	<div class="pricing-page-hero__media" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-hero', array( 'class' => 'pricing-page-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-service-2.svg' ); ?>
	</div>
	<div class="pricing-page-hero__overlay"></div>
	<div class="container pricing-page-hero__content reveal-on-scroll">
		<p class="pricing-page-hero__eyebrow">Bảng giá</p>
		<h1>Minh bạch chi phí An tâm tận hưởng không gian hoàn hảo</h1>
		<p>LuxNova cung cấp các gói dịch vụ linh hoạt, phù hợp với nhu cầu và ngân sách của bạn.</p>
	</div>
</section>

<section class="pricing-plans">
	<div class="container">
		<header class="service-section-heading">
			<h2>Gói dịch vụ</h2>
		</header>
		<div class="pricing-plans__grid">
			<?php foreach ( luxnova_pricing_plans() as $plan ) : ?>
				<article class="pricing-card <?php echo ! empty( $plan['featured'] ) ? 'is-featured' : ''; ?> reveal-on-scroll">
					<?php if ( ! empty( $plan['featured'] ) ) : ?>
						<span class="pricing-card__ribbon">Phổ biến</span>
					<?php endif; ?>
					<p class="pricing-card__label"><?php echo esc_html( $plan['label'] ); ?></p>
					<h2><?php echo esc_html( $plan['title'] ); ?></h2>
					<div class="pricing-card__price">
						<strong><?php echo esc_html( $plan['price'] ); ?></strong>
						<span><?php echo esc_html( $plan['unit'] ); ?></span>
					</div>
					<ul>
						<?php foreach ( $plan['features'] as $feature ) : ?>
							<li><?php echo esc_html( $feature ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a href="#consultation-modal" class="button <?php echo ! empty( $plan['featured'] ) ? 'button--gold' : 'button--outline-dark'; ?> js-consultation-modal">Liên hệ tư vấn</a>
				</article>
			<?php endforeach; ?>
		</div>
		<p class="pricing-plans__note">*Đơn giá mang tính tham khảo, vui lòng liên hệ để nhận báo giá chi tiết theo từng dự án.</p>
	</div>
</section>

<section class="cost-factors">
	<div class="container">
		<header class="service-section-heading">
			<h2>Các yếu tố ảnh hưởng đến chi phí</h2>
		</header>
		<div class="cost-factors__grid">
			<?php foreach ( luxnova_cost_factors() as $factor ) : ?>
				<div class="cost-factors__item reveal-on-scroll">
					<?php echo luxnova_icon( $factor['icon'] ); ?>
					<strong><?php echo esc_html( $factor['title'] ); ?></strong>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="pricing-faq">
	<div class="container pricing-faq__grid">
		<div>
			<header class="service-section-heading">
				<h2>Câu hỏi thường gặp về báo giá</h2>
			</header>
			<div class="pricing-faq__list">
				<?php foreach ( luxnova_pricing_faqs() as $index => $faq ) : ?>
					<details <?php echo 0 === $index ? 'open' : ''; ?>>
						<summary><?php echo esc_html( $faq['question'] ); ?></summary>
						<p><?php echo esc_html( $faq['answer'] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="pricing-faq__image" aria-hidden="true">
			<?php echo luxnova_image( '', 'luxnova-card', array( 'alt' => '' ), 'assets/images/placeholder-service-3.svg' ); ?>
		</div>
	</div>
</section>

<section class="pricing-closing-cta">
	<div class="pricing-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-card', array( 'alt' => '' ), 'assets/images/placeholder-project-1.svg' ); ?>
	</div>
	<div class="container pricing-closing-cta__inner">
		<div>
			<h2>Nhận báo giá chi tiết cho không gian của bạn</h2>
			<p>Đội ngũ LuxNova sẽ liên hệ và gửi báo giá chi tiết phù hợp nhất với nhu cầu của bạn.</p>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal">Đặt lịch tư vấn <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
