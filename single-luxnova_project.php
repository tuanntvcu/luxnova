<?php
/**
 * Single project template.
 *
 * @package LuxNova
 */

get_header();

while ( have_posts() ) :
	the_post();

	$project_id             = get_the_ID();
	$page_data              = luxnova_single_project_page_data( $project_id );
	$terms                  = get_the_terms( $project_id, 'luxnova_project_type' );
	$type                   = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0]->name : 'Dự án';
	$location               = function_exists( 'get_field' ) ? ( get_field( 'location', $project_id ) ?: 'Hà Nội' ) : 'Hà Nội';
	$area                   = function_exists( 'get_field' ) ? ( get_field( 'area', $project_id ) ?: '' ) : '';
	$style                  = function_exists( 'get_field' ) ? ( get_field( 'style', $project_id ) ?: '' ) : '';
	$year                   = function_exists( 'get_field' ) ? ( get_field( 'completion_year', $project_id ) ?: get_the_date( 'Y' ) ) : get_the_date( 'Y' );
	$scope                  = function_exists( 'get_field' ) ? ( get_field( 'scope', $project_id ) ?: 'Thiết kế & Thi công nội thất' ) : 'Thiết kế & Thi công nội thất';
	$architect              = function_exists( 'get_field' ) ? ( get_field( 'architect', $project_id ) ?: 'LuxNova Design Team' ) : 'LuxNova Design Team';
	$brochure               = function_exists( 'get_field' ) ? get_field( 'brochure', $project_id ) : '';
	$brochure_url           = luxnova_project_brochure_url( $brochure );
	$brochure_download_attr = '#project-info' === $brochure_url ? '' : ' download';
	$gallery                = function_exists( 'get_field' ) ? (array) get_field( 'gallery', $project_id ) : array();
	$gallery_videos         = function_exists( 'get_field' ) ? (array) get_field( 'gallery_videos', $project_id ) : array();
	$hero_image             = get_post_thumbnail_id( $project_id );
	$hero_mobile_image      = function_exists( 'get_field' ) ? get_field( 'hero_mobile_image', $project_id ) : '';
	$summary                = has_excerpt() ? get_the_excerpt() : ( $page_data['summary_fallback'] ?? '' );
	$meta_labels            = $page_data['meta_labels'] ?? array();
	$actions                = $page_data['actions'] ?? array();
	$info_labels            = $page_data['info_labels'] ?? array();
	$closing_cta            = $page_data['closing_cta'] ?? array();
	$gallery_thumb_fallback = $hero_image
		? luxnova_image_url( $hero_image, 'luxnova-card', 'assets/images/placeholder-project-2.svg' )
		: luxnova_asset( 'assets/images/placeholder-project-2.svg' );

	if ( empty( $gallery ) ) {
		$gallery = array(
			$hero_image ?: luxnova_asset( 'assets/images/placeholder-project-2.svg' ),
			luxnova_asset( 'assets/images/placeholder-project-1.svg' ),
			luxnova_asset( 'assets/images/placeholder-service-2.svg' ),
			luxnova_asset( 'assets/images/placeholder-project-4.svg' ),
			luxnova_asset( 'assets/images/placeholder-interior.svg' ),
			luxnova_asset( 'assets/images/placeholder-service-3.svg' ),
		);
	}

	$gallery_media = array();
	foreach ( $gallery as $media ) {
		$gallery_item = luxnova_project_gallery_media_item( $media, get_the_title() . ' gallery image', $gallery_thumb_fallback );
		if ( ! empty( $gallery_item['url'] ) ) {
			$gallery_media[] = $gallery_item;
		}
	}

	foreach ( $gallery_videos as $video_row ) {
		$video_media = is_array( $video_row ) ? ( $video_row['video'] ?? '' ) : $video_row;
		$video_item  = luxnova_project_gallery_media_item( $video_media, get_the_title() . ' gallery video', $gallery_thumb_fallback );

		if ( ! empty( $video_row['poster'] ) ) {
			$video_item['thumb'] = luxnova_image_url( $video_row['poster'], 'luxnova-card', 'assets/images/placeholder-interior.svg' );
		}

		if ( ! empty( $video_item['url'] ) ) {
			$video_item['type'] = 'video';
			$gallery_media[]    = $video_item;
		}
	}

	if ( empty( $gallery_media ) ) {
		$gallery_media[] = luxnova_project_gallery_media_item( luxnova_asset( 'assets/images/placeholder-project-2.svg' ), get_the_title() . ' gallery image', $gallery_thumb_fallback );
	}
	?>
	<article <?php post_class( 'single-project' ); ?>>
		<section class="single-project-hero">
			<div class="single-project-hero__media" aria-hidden="true">
				<?php echo luxnova_responsive_image( $hero_image, $hero_mobile_image, 'luxnova-hero', array( 'class' => 'single-project-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-project-2.svg' ); ?>
			</div>
			<div class="single-project-hero__overlay"></div>
			<div class="container single-project-hero__content">
				<nav class="single-project-breadcrumb" aria-label="Breadcrumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $page_data['breadcrumb']['home_label'] ?? '' ); ?></a>
					<span aria-hidden="true">›</span>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ) ); ?>"><?php echo esc_html( $page_data['breadcrumb']['archive_label'] ?? '' ); ?></a>
					<span aria-hidden="true">›</span>
					<span><?php the_title(); ?></span>
				</nav>

				<p class="single-project-hero__type"><?php echo esc_html( $type ); ?></p>
				<h1><?php the_title(); ?></h1>
				<?php if ( ! empty( $summary ) ) : ?>
					<p class="single-project-hero__summary"><?php echo esc_html( $summary ); ?></p>
				<?php endif; ?>

				<ul class="single-project-hero__meta">
					<li><?php echo luxnova_icon( 'pin' ); ?><span><?php echo esc_html( $meta_labels['location'] ?? '' ); ?></span><strong><?php echo esc_html( $location ); ?></strong></li>
					<li><?php echo luxnova_icon( 'measure' ); ?><span><?php echo esc_html( $meta_labels['area'] ?? '' ); ?></span><strong><?php echo esc_html( $area ); ?></strong></li>
					<li><?php echo luxnova_icon( 'home' ); ?><span><?php echo esc_html( $meta_labels['style'] ?? '' ); ?></span><strong><?php echo esc_html( $style ); ?></strong></li>
					<li><?php echo luxnova_icon( 'document' ); ?><span><?php echo esc_html( $meta_labels['year'] ?? '' ); ?></span><strong><?php echo esc_html( $year ); ?></strong></li>
				</ul>

				<div class="single-project-hero__actions">
					<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $actions['consultation_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
					<a href="<?php echo esc_url( $brochure_url ); ?>" class="button button--outline"<?php echo $brochure_download_attr; ?>><?php echo esc_html( $actions['brochure_label'] ?? '' ); ?> <span aria-hidden="true">↓</span></a>
				</div>
			</div>
			<a class="single-project-hero__gallery-link" href="#project-gallery"><?php echo esc_html( $actions['gallery_label'] ?? '' ); ?> (1/<?php echo esc_html( (string) count( $gallery_media ) ); ?>) <span aria-hidden="true">⌗</span></a>
		</section>

		<section class="single-project-story" id="project-info">
			<div class="container single-project-story__grid">
				<div class="single-project-story__content">
					<h2><?php echo esc_html( $page_data['story_heading'] ?? '' ); ?></h2>
					<div class="single-project-story__text">
						<?php if ( trim( get_the_content() ) ) : ?>
							<?php the_content(); ?>
						<?php else : ?>
							<?php foreach ( (array) ( $page_data['story_fallback'] ?? array() ) as $paragraph ) : ?>
								<?php $paragraph = is_array( $paragraph ) ? ( $paragraph['paragraph'] ?? '' ) : $paragraph; ?>
								<?php if ( '' !== trim( (string) $paragraph ) ) : ?>
									<p><?php echo esc_html( $paragraph ); ?></p>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $page_data['features'] ) ) : ?>
						<div class="single-project-features">
							<?php foreach ( $page_data['features'] as $feature ) : ?>
								<div>
									<?php echo luxnova_icon_media( $feature, 'home' ); ?>
									<h3><?php echo esc_html( $feature['title'] ?? '' ); ?></h3>
									<p><?php echo esc_html( $feature['description'] ?? '' ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<aside class="single-project-info-card">
					<h2><?php echo esc_html( $page_data['info_heading'] ?? '' ); ?></h2>
					<dl>
						<div><dt><?php echo esc_html( $info_labels['type'] ?? '' ); ?></dt><dd><?php echo esc_html( $type ); ?></dd></div>
						<div><dt><?php echo esc_html( $info_labels['location'] ?? '' ); ?></dt><dd><?php echo esc_html( $location ); ?></dd></div>
						<div><dt><?php echo esc_html( $info_labels['area'] ?? '' ); ?></dt><dd><?php echo esc_html( $area ); ?></dd></div>
						<div><dt><?php echo esc_html( $info_labels['style'] ?? '' ); ?></dt><dd><?php echo esc_html( $style ); ?></dd></div>
						<div><dt><?php echo esc_html( $info_labels['year'] ?? '' ); ?></dt><dd><?php echo esc_html( $year ); ?></dd></div>
						<div><dt><?php echo esc_html( $info_labels['scope'] ?? '' ); ?></dt><dd><?php echo esc_html( $scope ); ?></dd></div>
						<div><dt><?php echo esc_html( $info_labels['architect'] ?? '' ); ?></dt><dd><?php echo esc_html( $architect ); ?></dd></div>
					</dl>
					<a href="<?php echo esc_url( $brochure_url ); ?>" class="button button--outline"<?php echo $brochure_download_attr; ?>><?php echo esc_html( $actions['brochure_label'] ?? '' ); ?> <span aria-hidden="true">↓</span></a>
				</aside>
			</div>
		</section>

		<section class="single-project-gallery" id="project-gallery">
			<div class="container">
				<header class="single-project-section-heading">
					<h2><?php echo esc_html( $page_data['gallery_heading'] ?? '' ); ?></h2>
				</header>
				<div class="single-project-gallery__grid" data-project-gallery>
					<?php foreach ( array_slice( $gallery_media, 0, 6 ) as $index => $media ) : ?>
						<button
							type="button"
							class="single-project-gallery__item <?php echo 0 === $index ? 'is-large' : ''; ?>"
							data-project-gallery-item="<?php echo esc_attr( wp_json_encode( $media ) ); ?>"
							data-project-gallery-index="<?php echo esc_attr( (string) $index ); ?>"
							aria-label="<?php echo esc_attr( sprintf( '%s %d', $page_data['gallery_heading'] ?? 'Gallery item', $index + 1 ) ); ?>"
						>
							<img src="<?php echo esc_url( $media['thumb'] ); ?>" alt="<?php echo esc_attr( $media['alt'] ); ?>" loading="lazy" decoding="async">
							<?php if ( 'video' === ( $media['type'] ?? '' ) ) : ?><span class="single-project-gallery__play" aria-hidden="true">▶</span><?php endif; ?>
							<?php if ( 5 === $index && count( $gallery_media ) > 6 ) : ?><strong>+<?php echo esc_html( (string) ( count( $gallery_media ) - 6 ) ); ?><small><?php echo esc_html( $page_data['gallery_more_label'] ?? '' ); ?></small></strong><?php endif; ?>
						</button>
					<?php endforeach; ?>
				</div>
				<script type="application/json" data-project-gallery-data><?php echo wp_json_encode( $gallery_media, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ); ?></script>
			</div>
		</section>

		<div class="project-gallery-lightbox" data-project-gallery-lightbox hidden aria-hidden="true">
			<div class="project-gallery-lightbox__backdrop" data-project-gallery-close></div>
			<div class="project-gallery-lightbox__dialog" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( $page_data['gallery_heading'] ?? 'Thư viện hình ảnh' ); ?>" tabindex="-1">
				<button type="button" class="project-gallery-lightbox__close" data-project-gallery-close aria-label="Đóng">×</button>
				<button type="button" class="project-gallery-lightbox__nav project-gallery-lightbox__nav--prev" data-project-gallery-prev aria-label="Ảnh trước">‹</button>
				<div class="project-gallery-lightbox__media" data-project-gallery-media></div>
				<button type="button" class="project-gallery-lightbox__nav project-gallery-lightbox__nav--next" data-project-gallery-next aria-label="Ảnh tiếp theo">›</button>
				<div class="project-gallery-lightbox__counter" data-project-gallery-counter></div>
			</div>
		</div>

		<?php if ( ! empty( $page_data['benefits'] ) ) : ?>
			<section class="single-project-benefits" aria-label="<?php echo esc_attr( $page_data['benefits_label'] ?? '' ); ?>">
				<div class="container single-project-benefits__grid">
					<?php foreach ( $page_data['benefits'] as $benefit ) : ?>
						<div>
							<?php echo luxnova_icon_media( $benefit, 'shield' ); ?>
							<strong><?php echo esc_html( $benefit['title'] ?? '' ); ?></strong>
							<span><?php echo esc_html( $benefit['description'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="single-project-related">
			<div class="container">
				<header class="section-heading">
					<h2><?php echo esc_html( $page_data['related_heading'] ?? '' ); ?></h2>
					<a class="section-heading__link" href="<?php echo esc_url( get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ) ); ?>"><?php echo esc_html( $page_data['related_link_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
				</header>
				<div class="single-project-related__grid">
					<?php
					$related_term_ids = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? wp_list_pluck( $terms, 'term_id' ) : array();
					$related_args     = array(
						'post_type' => 'luxnova_project',
						'posts_per_page' => 4,
						'post__not_in' => array( $project_id ),
					);

					if ( ! empty( $related_term_ids ) ) {
						$related_args['tax_query'] = array(
							array(
								'taxonomy' => 'luxnova_project_type',
								'field' => 'term_id',
								'terms' => $related_term_ids,
							),
						);
					}

					$related     = new WP_Query( $related_args );
					$related_ids = wp_list_pluck( $related->posts, 'ID' );
					$remaining   = 4 - count( $related_ids );

					if ( $remaining > 0 && ! empty( $related_term_ids ) ) {
						$related_fallback = new WP_Query(
							array(
								'post_type' => 'luxnova_project',
								'posts_per_page' => $remaining,
								'post__not_in' => array_merge( array( $project_id ), $related_ids ),
							)
						);

						if ( $related_fallback->have_posts() ) {
							$related->posts      = array_merge( $related->posts, $related_fallback->posts );
							$related->post_count = count( $related->posts );
						}
					}
					if ( $related->have_posts() ) :
						while ( $related->have_posts() ) :
							$related->the_post();
							$related_id    = get_the_ID();
							$related_terms = get_the_terms( $related_id, 'luxnova_project_type' );
							luxnova_render_project_listing_card(
								array(
									'title' => get_the_title(),
									'type' => ( ! is_wp_error( $related_terms ) && ! empty( $related_terms ) ) ? $related_terms[0]->name : 'Dự án',
									'location' => function_exists( 'get_field' ) ? ( get_field( 'location', $related_id ) ?: 'Hà Nội' ) : 'Hà Nội',
									'area' => function_exists( 'get_field' ) ? ( get_field( 'area', $related_id ) ?: '' ) : '',
									'style' => function_exists( 'get_field' ) ? ( get_field( 'style', $related_id ) ?: '' ) : '',
									'year' => get_the_date( 'Y' ),
									'image' => get_post_thumbnail_id( $related_id ),
									'url' => get_permalink(),
								)
							);
						endwhile;
						wp_reset_postdata();
					else :
						foreach ( array_slice( luxnova_default_archive_project_cards(), 0, 4 ) as $card ) {
							luxnova_render_project_listing_card( $card );
						}
					endif;
					?>
				</div>
			</div>
		</section>

		<section class="project-consultation-cta">
			<div class="project-consultation-cta__image" aria-hidden="true">
				<?php echo luxnova_image( $closing_cta['image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $closing_cta['image_fallback'] ?? 'assets/images/placeholder-interior.svg' ); ?>
			</div>
			<div class="container project-consultation-cta__inner">
				<div>
					<h2><?php echo esc_html( $closing_cta['title'] ?? '' ); ?></h2>
					<?php if ( ! empty( $closing_cta['description'] ) ) : ?>
						<p><?php echo esc_html( $closing_cta['description'] ); ?></p>
					<?php endif; ?>
				</div>
				<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $closing_cta['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
			</div>
		</section>
	</article>
	<?php
endwhile;

get_footer();
