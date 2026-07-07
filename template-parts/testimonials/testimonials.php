<?php
/**
 * Testimonials.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$items   = $section['items'] ?? array();

if ( ! empty( $items ) && is_numeric( reset( $items ) ) ) {
	$cards = array();
	foreach ( $items as $testimonial_id ) {
		$cards[] = luxnova_testimonial_card_data( (int) $testimonial_id );
	}
	$items = $cards;
}
?>
<section class="section section--light section--compact">
	<div class="container">
		<header class="section-heading">
			<h2><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
		</header>

		<div class="testimonial-grid testimonial-slider" data-testimonial-slider>
			<div class="testimonial-slider__track">
				<?php foreach ( $items as $item ) : ?>
					<article class="testimonial-card testimonial-slider__slide reveal-on-scroll">
						<?php $rating = max( 1, min( 5, (int) ( $item['rating'] ?? 5 ) ) ); ?>
						<div class="testimonial-card__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'luxnova' ), $rating ) ); ?>"><?php echo luxnova_stars( $rating ); ?></div>
						<?php if ( ! empty( $item['quote'] ) ) : ?>
							<blockquote>&ldquo;<?php echo esc_html( $item['quote'] ); ?>&rdquo;</blockquote>
						<?php endif; ?>
						<footer>
							<?php echo luxnova_image( $item['avatar'] ?? '', 'luxnova-avatar', array( 'alt' => esc_attr( $item['name'] ?? '' ) ), 'assets/images/placeholder-avatar-1.svg' ); ?>
							<div>
								<strong><?php echo esc_html( $item['name'] ?? '' ); ?></strong>
								<span><?php echo esc_html( $item['context'] ?? '' ); ?></span>
							</div>
						</footer>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
