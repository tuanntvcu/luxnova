<?php
/**
 * Services section.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$items   = $section['items'] ?? array();
?>
<section class="section section--light" id="dich-vu">
	<div class="container">
		<header class="section-heading">
			<div>
				<h2><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
				<?php if ( ! empty( $section['subtitle'] ) ) : ?>
					<p><?php echo esc_html( $section['subtitle'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php echo luxnova_link( $section['archive_link'] ?? array(), 'section-heading__link', 'Xem tất cả dịch vụ' ); ?>
		</header>

		<div class="service-grid">
			<?php foreach ( $items as $item ) : ?>
				<article class="service-card reveal-on-scroll">
					<?php echo luxnova_image( $item['image'] ?? '', 'luxnova-card', array( 'class' => 'service-card__image', 'alt' => esc_attr( $item['title'] ?? '' ) ), 'assets/images/placeholder-interior.svg' ); ?>
					<div class="service-card__content">
						<h3><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
						<p><?php echo esc_html( $item['tagline'] ?? '' ); ?></p>
						<ul>
							<?php foreach ( (array) ( $item['features'] ?? array() ) as $feature ) : ?>
								<?php $text = is_array( $feature ) ? ( $feature['text'] ?? '' ) : $feature; ?>
								<?php if ( '' === $text ) { continue; } ?>
								<li><?php echo esc_html( $text ); ?></li>
							<?php endforeach; ?>
						</ul>
						<?php echo luxnova_link( $item['link'] ?? array(), 'service-card__link', 'Tìm hiểu thêm' ); ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
