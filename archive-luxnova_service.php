<?php
/**
 * Service archive template.
 *
 * @package LuxNova
 */

get_header();

$service_cards = luxnova_default_service_cards();
$has_services  = have_posts();
?>
<section class="service-page-hero">
	<div class="service-page-hero__media" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-hero', array( 'class' => 'service-page-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="service-page-hero__overlay"></div>
	<div class="container service-page-hero__content reveal-on-scroll">
		<p class="service-page-hero__eyebrow">Dịch vụ</p>
		<h1>Giải pháp toàn diện cho không gian sống đẳng cấp</h1>
		<p>LuxNova cung cấp dịch vụ thiết kế và thi công nội thất trọn gói, kiến tạo không gian sống tinh tế, chuẩn mực và bền vững.</p>
		<div class="service-page-hero__actions">
			<a href="#consultation-modal" class="button button--gold js-consultation-modal">Đặt lịch tư vấn <span aria-hidden="true">→</span></a>
			<a href="#service-list" class="button button--outline">Tìm hiểu thêm</a>
		</div>
	</div>
</section>

<section class="service-archive-section" id="service-list">
	<div class="container">
		<header class="service-section-heading">
			<h2>Dịch vụ của chúng tôi</h2>
		</header>
		<div class="service-archive-grid">
			<?php if ( $has_services ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php $service_thumbnail = get_post_thumbnail_id(); ?>
					<article class="service-archive-card reveal-on-scroll">
						<a href="<?php the_permalink(); ?>" class="service-archive-card__link">
							<?php echo luxnova_image( $service_thumbnail ?: '', 'luxnova-card', array( 'class' => 'service-archive-card__image', 'alt' => esc_attr( get_the_title() ) ), 'assets/images/placeholder-service-1.svg' ); ?>
							<span class="service-archive-card__icon"><?php echo luxnova_icon( 'design' ); ?></span>
							<span class="service-archive-card__body">
								<strong><?php the_title(); ?></strong>
								<span><?php echo esc_html( has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 22 ) ); ?></span>
								<em>Tìm hiểu thêm →</em>
							</span>
						</a>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<?php foreach ( $service_cards as $card ) : ?>
					<article class="service-archive-card reveal-on-scroll">
						<a href="<?php echo esc_url( $card['url'] ?? '#service-process' ); ?>" class="service-archive-card__link">
							<?php echo luxnova_image( $card['image'] ?? '', 'luxnova-card', array( 'class' => 'service-archive-card__image', 'alt' => esc_attr( $card['title'] ?? '' ) ), 'assets/images/placeholder-service-1.svg' ); ?>
							<span class="service-archive-card__icon"><?php echo luxnova_icon( $card['icon'] ?? 'design' ); ?></span>
							<span class="service-archive-card__body">
								<strong><?php echo esc_html( $card['title'] ?? '' ); ?></strong>
								<span><?php echo esc_html( $card['description'] ?? '' ); ?></span>
								<em>Tìm hiểu thêm →</em>
							</span>
						</a>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="service-process" id="service-process">
	<div class="container">
		<header class="service-section-heading service-section-heading--dark">
			<h2>Quy trình làm việc</h2>
		</header>
		<div class="service-process__grid">
			<?php foreach ( luxnova_service_process_steps() as $step ) : ?>
				<div class="service-process__item reveal-on-scroll">
					<span><?php echo esc_html( $step['number'] ); ?></span>
					<?php echo luxnova_icon( $step['icon'] ); ?>
					<strong><?php echo esc_html( $step['title'] ); ?></strong>
					<p><?php echo esc_html( $step['description'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="why-luxnova">
	<div class="container">
		<header class="service-section-heading">
			<h2>Vì sao chọn LuxNova?</h2>
		</header>
		<div class="why-luxnova__grid">
			<?php foreach ( luxnova_why_choose_items() as $item ) : ?>
				<div class="why-luxnova__item reveal-on-scroll">
					<?php echo luxnova_icon( $item['icon'] ); ?>
					<strong><?php echo esc_html( $item['title'] ); ?></strong>
					<p><?php echo esc_html( $item['description'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="service-closing-cta">
	<div class="service-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-card', array( 'alt' => '' ), 'assets/images/placeholder-interior.svg' ); ?>
	</div>
	<div class="container service-closing-cta__inner">
		<div>
			<h2>Sẵn sàng kiến tạo không gian mơ ước của bạn?</h2>
			<p>Đội ngũ LuxNova luôn sẵn sàng lắng nghe và đưa ra giải pháp tối ưu nhất cho không gian của bạn.</p>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal">Đặt lịch tư vấn <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
