<?php
/**
 * Partner logos.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$items   = $section['items'] ?? array();
?>
<section class="partner-strip" aria-label="<?php esc_attr_e( 'Partner brands', 'luxnova' ); ?>">
	<div class="container partner-strip__grid">
		<?php foreach ( $items as $item ) : ?>
			<?php
			$name = is_array( $item ) ? ( $item['name'] ?? '' ) : $item;
			$url  = is_array( $item ) ? ( $item['url'] ?? '' ) : '';
			$logo = is_array( $item ) ? ( $item['logo'] ?? '' ) : '';
			?>
			<?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $name ); ?>"><?php else : ?><span><?php endif; ?>
				<?php
				if ( $logo ) {
					echo luxnova_image( $logo, 'medium', array( 'alt' => esc_attr( $name ) ), 'assets/images/placeholder-logo.svg' );
				} else {
					echo esc_html( $name );
				}
				?>
			<?php if ( $url ) : ?></a><?php else : ?></span><?php endif; ?>
		<?php endforeach; ?>
	</div>
</section>
