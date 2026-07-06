<?php
/**
 * Statistics section.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$items   = $section['items'] ?? array();
$embedded = ! empty( $args['embedded'] );
?>
<?php if ( $embedded ) : ?>
<div class="stats-band stats-band--in-hero" aria-label="<?php esc_attr_e( 'LuxNova statistics', 'luxnova' ); ?>">
<?php else : ?>
<section class="stats-band" aria-label="<?php esc_attr_e( 'LuxNova statistics', 'luxnova' ); ?>">
<?php endif; ?>
	<div class="container stats-band__grid">
		<?php foreach ( $items as $item ) : ?>
			<article class="stat-item reveal-on-scroll">
				<span class="stat-item__icon"><?php echo luxnova_icon_media( $item, 'chart' ); ?></span>
				<span class="stat-item__value"><span data-count-up="<?php echo esc_attr( preg_replace( '/\D+/', '', (string) ( $item['number'] ?? '0' ) ) ); ?>"><?php echo esc_html( $item['number'] ?? '' ); ?></span><?php echo esc_html( $item['suffix'] ?? '' ); ?></span>
				<span class="stat-item__label"><?php echo esc_html( $item['label'] ?? '' ); ?></span>
			</article>
		<?php endforeach; ?>
	</div>
<?php if ( $embedded ) : ?>
</div>
<?php else : ?>
</section>
<?php endif; ?>
