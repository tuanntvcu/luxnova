<?php
/**
 * Featured projects.
 *
 * @package LuxNova
 */

$section = $args['section'] ?? array();
$items   = $section['items'] ?? array();

if ( ! empty( $items ) && is_numeric( reset( $items ) ) ) {
	$cards = array();
	foreach ( $items as $project_id ) {
		$cards[] = array(
			'title' => get_the_title( (int) $project_id ),
			'image' => get_post_thumbnail_id( (int) $project_id ),
			'area' => function_exists( 'get_field' ) ? get_field( 'area', (int) $project_id ) : '',
			'style' => function_exists( 'get_field' ) ? get_field( 'style', (int) $project_id ) : '',
			'budget' => function_exists( 'get_field' ) ? get_field( 'budget', (int) $project_id ) : '',
			'timeline' => function_exists( 'get_field' ) ? get_field( 'timeline', (int) $project_id ) : '',
			'url' => get_permalink( (int) $project_id ),
		);
	}
	$items = $cards;
}
?>
<section class="section section--light section--compact" id="du-an">
	<div class="container">
		<header class="section-heading">
			<h2><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
			<?php echo luxnova_link( $section['archive_link'] ?? array(), 'section-heading__link', 'Xem tất cả dự án' ); ?>
		</header>

		<div class="project-grid">
			<?php foreach ( $items as $item ) : ?>
				<article class="project-card reveal-on-scroll">
					<a href="<?php echo esc_url( $item['url'] ?? '#' ); ?>" class="project-card__link" aria-label="<?php echo esc_attr( $item['title'] ?? '' ); ?>">
						<?php echo luxnova_image( $item['image'] ?? '', 'luxnova-project', array( 'class' => 'project-card__image', 'alt' => esc_attr( $item['title'] ?? '' ) ), 'assets/images/placeholder-project-1.svg' ); ?>
						<div class="project-card__content">
							<h3><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
							<ul>
								<li><?php echo luxnova_icon( 'measure' ); ?><?php echo esc_html( $item['area'] ?? '' ); ?></li>
								<li><?php echo luxnova_icon( 'home' ); ?><?php echo esc_html( $item['style'] ?? '' ); ?></li>
								<li><?php echo luxnova_icon( 'document' ); ?><?php echo esc_html( $item['budget'] ?? '' ); ?></li>
								<li><?php echo luxnova_icon( 'chart' ); ?><?php echo esc_html( $item['timeline'] ?? '' ); ?></li>
							</ul>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
