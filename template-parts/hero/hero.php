<?php
/**
 * Hero section.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$title   = $section['title'] ?? '';
?>
<section class="hero-section<?php echo empty( $section['statistics'] ) ? '' : ' hero-section--with-stats'; ?>">
	<div class="hero-section__media" aria-hidden="true">
		<?php echo luxnova_responsive_image( $section['background_image'] ?? '', $section['background_image_mobile'] ?? '', 'luxnova-hero', array( 'class' => 'hero-section__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="hero-section__overlay"></div>
	<div class="container hero-section__content reveal-on-scroll">
		<h1><?php echo esc_html( $title ); ?></h1>
		<?php if ( ! empty( $section['highlight'] ) ) : ?>
			<p class="hero-section__highlight"><?php echo esc_html( $section['highlight'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $section['description'] ) ) : ?>
			<p class="hero-section__description"><?php echo esc_html( $section['description'] ); ?></p>
		<?php endif; ?>
		<div class="hero-section__actions">
			<?php echo luxnova_link( $section['primary_button'] ?? array(), 'button button--gold js-consultation-modal', 'Đặt lịch tư vấn' ); ?>
			<?php echo luxnova_link( $section['secondary_button'] ?? array(), 'button button--outline', 'Xem dự án' ); ?>
		</div>
	</div>
	<?php
	if ( ! empty( $section['statistics'] ) ) {
		get_template_part( 'template-parts/statistics/statistics', null, array( 'section' => $section['statistics'], 'embedded' => true ) );
	}
	?>
</section>
