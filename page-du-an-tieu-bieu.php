<?php
/**
 * Template Name: Dự án tiêu biểu
 *
 * @package LuxNova
 */

get_header();

$page_id     = (int) get_queried_object_id();
$page_data   = luxnova_featured_case_study_page_data( $page_id );
$hero        = $page_data['hero'] ?? array();
$project_ids = luxnova_featured_case_study_project_ids( $page_data );
?>
<section class="featured-case-hero">
	<div class="featured-case-hero__media" aria-hidden="true">
		<?php echo luxnova_image( $hero['image'] ?? '', 'luxnova-hero', array( 'class' => 'featured-case-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="featured-case-hero__overlay"></div>
	<div class="container featured-case-hero__inner">
		<div class="featured-case-hero__copy reveal-on-scroll">
			<h1>
				<span><?php echo esc_html( $hero['title'] ?? 'Dự án tiêu biểu' ); ?></span>
				<strong><?php echo esc_html( $hero['highlight'] ?? 'Case Study' ); ?></strong>
			</h1>
			<?php if ( ! empty( $hero['description'] ) ) : ?>
				<p><?php echo esc_html( $hero['description'] ); ?></p>
			<?php endif; ?>
		</div>
		<div class="featured-case-hero__brand" aria-hidden="true">
			<?php echo luxnova_brand_markup( 'featured-case-hero__logo' ); ?>
		</div>
	</div>
</section>

<section class="featured-case-section">
	<div class="container featured-case-section__inner">
		<?php if ( empty( $project_ids ) ) : ?>
			<p class="featured-case-empty"><?php echo esc_html( $page_data['empty_message'] ?? '' ); ?></p>
		<?php endif; ?>

		<?php foreach ( $project_ids as $index => $project_id ) : ?>
			<?php
			if ( 'publish' !== get_post_status( $project_id ) ) {
				continue;
			}

			$case       = luxnova_project_case_study_data( (int) $project_id, $index );
			$meta_items = array_filter(
				array(
					array( 'icon' => 'pin', 'label' => 'Vị trí', 'value' => $case['location'] ?? '' ),
					array( 'icon' => 'home', 'label' => 'Loại hình', 'value' => $case['type'] ?? '' ),
					array( 'icon' => 'clock', 'label' => 'Thời gian', 'value' => $case['timeline'] ?? '' ),
					array( 'icon' => 'document', 'label' => 'Chi phí', 'value' => $case['budget'] ?? '' ),
				),
				static fn( array $item ): bool => '' !== trim( (string) $item['value'] )
			);
			$story_items = array_filter(
				array(
					array( 'icon' => 'document', 'title' => 'Giới thiệu', 'text' => $case['overview'] ?? '' ),
					array( 'icon' => 'users', 'title' => 'Nhu cầu khách hàng', 'text' => $case['client_needs'] ?? '' ),
					array( 'icon' => 'tools', 'title' => 'Giải pháp', 'text' => $case['solution'] ?? '' ),
				),
				static fn( array $item ): bool => '' !== trim( (string) $item['text'] )
			);
			?>
			<article class="featured-case-card reveal-on-scroll" id="case-<?php echo esc_attr( (string) $case['id'] ); ?>">
				<header class="featured-case-card__header">
					<div>
						<p class="featured-case-card__number"><span><?php echo esc_html( $case['number'] ); ?>.</span> <?php echo esc_html( $case['title'] ); ?></p>
						<span><?php echo esc_html( $case['type'] ); ?></span>
					</div>
					<?php if ( ! empty( $meta_items ) ) : ?>
						<ul class="featured-case-meta" aria-label="Thông tin dự án">
							<?php foreach ( $meta_items as $item ) : ?>
								<li><?php echo luxnova_icon( $item['icon'] ); ?><span><?php echo esc_html( $item['label'] ); ?></span><strong><?php echo esc_html( $item['value'] ); ?></strong></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</header>

				<div class="featured-case-card__body">
					<div class="featured-case-story">
						<?php foreach ( $story_items as $item ) : ?>
							<section class="featured-case-story__item">
								<div><?php echo luxnova_icon( $item['icon'] ); ?></div>
								<h2><?php echo esc_html( $item['title'] ); ?></h2>
								<p><?php echo esc_html( $item['text'] ); ?></p>
							</section>
						<?php endforeach; ?>
					</div>

					<div class="featured-case-gallery" aria-label="<?php echo esc_attr( $case['title'] ); ?>">
						<div class="featured-case-gallery__group">
							<span>Trước</span>
							<?php foreach ( $case['before_images'] as $image ) : ?>
								<figure>
									<?php echo luxnova_image( $image['image'] ?? '', 'luxnova-card', array( 'alt' => esc_attr( $image['alt'] ?? $case['title'] ) ), 'assets/images/placeholder-project-1.svg' ); ?>
								</figure>
							<?php endforeach; ?>
						</div>
						<div class="featured-case-gallery__group featured-case-gallery__group--after">
							<span>Sau</span>
							<?php foreach ( $case['after_images'] as $image ) : ?>
								<figure>
									<?php echo luxnova_image( $image['image'] ?? '', 'luxnova-card', array( 'alt' => esc_attr( $image['alt'] ?? $case['title'] ) ), 'assets/images/placeholder-project-2.svg' ); ?>
								</figure>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<footer class="featured-case-card__footer">
					<?php if ( ! empty( $case['results'] ) ) : ?>
						<section class="featured-case-results">
							<h2>Kết quả</h2>
							<ul>
								<?php foreach ( $case['results'] as $result ) : ?>
									<li><?php echo esc_html( $result ); ?></li>
								<?php endforeach; ?>
							</ul>
						</section>
					<?php endif; ?>

					<?php if ( ! empty( $case['quote'] ) || ! empty( $case['client_name'] ) ) : ?>
						<section class="featured-case-quote">
							<div class="featured-case-quote__content">
								<h2>Phản hồi khách hàng</h2>
								<div class="featured-case-quote__line">
									<div class="featured-case-quote__mark" aria-hidden="true">“</div>
									<div>
										<blockquote><?php echo esc_html( $case['quote'] ); ?></blockquote>
										<?php if ( ! empty( $case['client_name'] ) ) : ?>
											<span>– <?php echo esc_html( $case['client_name'] ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<figure class="featured-case-quote__photo">
								<?php echo luxnova_image( $case['client_avatar'] ?? '', 'luxnova-card', array( 'alt' => esc_attr( $case['client_name'] ?? '' ) ), 'assets/images/placeholder-avatar-1.svg' ); ?>
							</figure>
						</section>
					<?php endif; ?>
				</footer>
			</article>
		<?php endforeach; ?>
	</div>
</section>
<?php
get_footer();
