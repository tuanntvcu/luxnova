<?php
/**
 * Service archive template.
 *
 * @package LuxNova
 */

get_header();

$page_data     = luxnova_service_archive_data();
$hero          = $page_data['hero'] ?? array();
$closing_cta   = $page_data['closing_cta'] ?? array();
$service_cards = luxnova_default_service_cards();
$has_services  = have_posts();
?>
<section class="service-page-hero">
	<div class="service-page-hero__media" aria-hidden="true">
		<?php echo luxnova_image( $hero['image'] ?? '', 'luxnova-hero', array( 'class' => 'service-page-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="service-page-hero__overlay"></div>
	<div class="container service-page-hero__content reveal-on-scroll">
		<?php if ( ! empty( $hero['eyebrow'] ) ) : ?>
			<p class="service-page-hero__eyebrow"><?php echo esc_html( $hero['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1><?php echo esc_html( $hero['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $hero['description'] ) ) : ?>
			<p><?php echo esc_html( $hero['description'] ); ?></p>
		<?php endif; ?>
		<div class="service-page-hero__actions">
			<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $hero['primary_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
			<a href="#service-list" class="button button--outline"><?php echo esc_html( $hero['secondary_label'] ?? '' ); ?></a>
		</div>
	</div>
</section>

<section class="service-archive-section" id="service-list">
	<div class="container">
		<header class="service-section-heading">
			<h2><?php echo esc_html( $page_data['services_heading'] ?? '' ); ?></h2>
		</header>
		<div class="service-archive-grid">
			<?php if ( $has_services ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					$service_id        = get_the_ID();
					$service_thumbnail = get_post_thumbnail_id( $service_id );
					$service_icon      = function_exists( 'get_field' ) ? ( get_field( 'icon', $service_id ) ?: 'design' ) : 'design';
					$service_icon_image = function_exists( 'get_field' ) ? get_field( 'icon_image', $service_id ) : '';
					?>
					<article class="service-archive-card reveal-on-scroll">
						<a href="<?php the_permalink(); ?>" class="service-archive-card__link">
							<?php echo luxnova_image( $service_thumbnail ?: '', 'luxnova-card', array( 'class' => 'service-archive-card__image', 'alt' => esc_attr( get_the_title() ) ), 'assets/images/placeholder-service-1.svg' ); ?>
							<span class="service-archive-card__icon"><?php echo luxnova_icon_media( array( 'icon' => $service_icon, 'icon_image' => $service_icon_image ), 'design' ); ?></span>
							<span class="service-archive-card__body">
								<strong><?php the_title(); ?></strong>
								<span><?php echo esc_html( has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 22 ) ); ?></span>
								<em><?php echo esc_html( $page_data['card_link_label'] ?? 'Tìm hiểu thêm' ); ?> →</em>
							</span>
						</a>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<?php foreach ( $service_cards as $card ) : ?>
					<article class="service-archive-card reveal-on-scroll">
						<a href="<?php echo esc_url( $card['url'] ?? '#service-process' ); ?>" class="service-archive-card__link">
							<?php echo luxnova_image( $card['image'] ?? '', 'luxnova-card', array( 'class' => 'service-archive-card__image', 'alt' => esc_attr( $card['title'] ?? '' ) ), 'assets/images/placeholder-service-1.svg' ); ?>
							<span class="service-archive-card__icon"><?php echo luxnova_icon_media( $card, 'design' ); ?></span>
							<span class="service-archive-card__body">
								<strong><?php echo esc_html( $card['title'] ?? '' ); ?></strong>
								<span><?php echo esc_html( $card['description'] ?? '' ); ?></span>
								<em><?php echo esc_html( $page_data['card_link_label'] ?? 'Tìm hiểu thêm' ); ?> →</em>
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
			<h2><?php echo esc_html( $page_data['process_heading'] ?? '' ); ?></h2>
		</header>
		<div class="service-process__grid">
			<?php foreach ( luxnova_service_process_steps() as $step ) : ?>
				<div class="service-process__item reveal-on-scroll">
					<span><?php echo esc_html( $step['number'] ); ?></span>
					<?php echo luxnova_icon_media( $step, 'home' ); ?>
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
			<h2><?php echo esc_html( $page_data['why_heading'] ?? '' ); ?></h2>
		</header>
		<div class="why-luxnova__grid">
			<?php foreach ( luxnova_why_choose_items() as $item ) : ?>
				<div class="why-luxnova__item reveal-on-scroll">
					<?php echo luxnova_icon_media( $item, 'shield' ); ?>
					<strong><?php echo esc_html( $item['title'] ); ?></strong>
					<p><?php echo esc_html( $item['description'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="service-closing-cta">
	<div class="service-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( $closing_cta['image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $closing_cta['image_fallback'] ?? 'assets/images/placeholder-interior.svg' ); ?>
	</div>
	<div class="container service-closing-cta__inner">
		<div>
			<h2><?php echo esc_html( $closing_cta['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $closing_cta['description'] ) ) : ?>
				<p><?php echo esc_html( $closing_cta['description'] ); ?></p>
			<?php endif; ?>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $closing_cta['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
