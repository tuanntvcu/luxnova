<?php
/**
 * Home audit CTA.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
?>
<section class="audit-cta">
	<div class="container audit-cta__grid">
		<div class="audit-cta__image reveal-on-scroll">
			<?php echo luxnova_image( $section['image'] ?? '', 'medium', array( 'alt' => esc_attr( $section['label'] ?? 'LuxNova Home Audit' ) ), 'assets/images/placeholder-audit.svg' ); ?>
		</div>
		<div class="audit-cta__copy reveal-on-scroll">
			<p class="audit-cta__label"><?php echo esc_html( $section['label'] ?? '' ); ?></p>
			<h2><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
			<p><?php echo esc_html( $section['description'] ?? '' ); ?></p>
		</div>
		<ul class="audit-cta__benefits">
			<?php foreach ( (array) ( $section['benefits'] ?? array() ) as $benefit ) : ?>
				<li class="reveal-on-scroll">
					<span><?php echo luxnova_icon_media( $benefit, 'document' ); ?></span>
					<?php echo esc_html( $benefit['label'] ?? '' ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="audit-cta__action reveal-on-scroll">
			<?php echo luxnova_link( $section['button'] ?? array(), 'button button--gold js-consultation-modal', 'Đăng ký ngay' ); ?>
		</div>
	</div>
</section>
