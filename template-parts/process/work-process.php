<?php
/**
 * Work process.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$steps   = $section['steps'] ?? array();
?>
<section class="section section--cream">
	<div class="container">
		<header class="section-heading section-heading--solo">
			<h2><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
		</header>
		<div class="process-line">
			<?php foreach ( $steps as $step ) : ?>
				<article class="process-step reveal-on-scroll">
					<span class="process-step__icon"><?php echo luxnova_icon_media( $step, 'home' ); ?></span>
					<span class="process-step__number"><?php echo esc_html( $step['number'] ?? '' ); ?></span>
					<h3><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $step['description'] ?? '' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
