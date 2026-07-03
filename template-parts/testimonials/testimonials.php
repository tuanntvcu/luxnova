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
		$cards[] = array(
			'name' => get_the_title( (int) $testimonial_id ),
			'quote' => wp_strip_all_tags( get_post_field( 'post_content', (int) $testimonial_id ) ),
			'rating' => function_exists( 'get_field' ) ? (int) get_field( 'rating', (int) $testimonial_id ) : 5,
			'context' => function_exists( 'get_field' ) ? get_field( 'project_context', (int) $testimonial_id ) : '',
			'avatar' => function_exists( 'get_field' ) ? get_field( 'avatar', (int) $testimonial_id ) : get_post_thumbnail_id( (int) $testimonial_id ),
		);
	}
	$items = $cards;
}
?>
<section class="section section--light section--compact">
	<div class="container">
		<header class="section-heading">
			<h2><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
			<?php echo luxnova_link( $section['archive_link'] ?? array(), 'section-heading__link', 'Xem tất cả đánh giá' ); ?>
		</header>

		<div class="testimonial-grid">
			<?php foreach ( $items as $item ) : ?>
				<article class="testimonial-card reveal-on-scroll">
					<div class="testimonial-card__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'luxnova' ), (int) ( $item['rating'] ?? 5 ) ) ); ?>"><?php echo luxnova_stars( (int) ( $item['rating'] ?? 5 ) ); ?></div>
					<blockquote>“<?php echo esc_html( $item['quote'] ?? '' ); ?>”</blockquote>
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
</section>
