<?php
/**
 * Project archive template.
 *
 * @package LuxNova
 */

get_header();

$selected_type = sanitize_title( wp_unslash( $_GET['project_type'] ?? '' ) );
$selected_sort = sanitize_key( wp_unslash( $_GET['project_sort'] ?? 'newest' ) );
$stats_section = luxnova_default_homepage_sections()[1] ?? array( 'items' => array() );
$fallback_cards = luxnova_default_archive_project_cards();
$has_real_posts = have_posts();

if ( '' !== $selected_type && ! $has_real_posts ) {
	$fallback_cards = array_values(
		array_filter(
			$fallback_cards,
			static fn( array $card ): bool => $selected_type === ( $card['type_slug'] ?? '' )
		)
	);
}

if ( 'oldest' === $selected_sort ) {
	$fallback_cards = array_reverse( $fallback_cards );
} elseif ( 'title' === $selected_sort ) {
	usort(
		$fallback_cards,
		static fn( array $a, array $b ): int => strcasecmp( $a['title'] ?? '', $b['title'] ?? '' )
	);
}
?>
<section class="project-archive-hero">
	<div class="project-archive-hero__media" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-hero', array( 'class' => 'project-archive-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="project-archive-hero__overlay"></div>
	<div class="container project-archive-hero__content reveal-on-scroll">
		<p class="project-archive-hero__eyebrow">Dự án</p>
		<h1>Không gian sống được kiến tạo từ cảm hứng</h1>
		<p>Mỗi dự án là một hành trình sáng tạo, nơi LuxNova kết hợp giữa thẩm mỹ, công năng và dấu ấn cá nhân để tạo nên những không gian sống bền vững.</p>
	</div>
	<div class="project-archive-hero__stats">
		<?php get_template_part( 'template-parts/statistics/statistics', null, array( 'section' => $stats_section, 'embedded' => true ) ); ?>
	</div>
</section>

<section class="project-archive-section">
	<div class="container">
		<div class="project-archive-toolbar">
			<nav class="project-filter-tabs" aria-label="Lọc dự án">
				<?php foreach ( luxnova_project_archive_tabs() as $tab ) : ?>
					<a class="<?php echo $selected_type === $tab['slug'] ? 'is-active' : ''; ?>" href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>

			<form class="project-sort-form" method="get">
				<?php if ( '' !== $selected_type ) : ?>
					<input type="hidden" name="project_type" value="<?php echo esc_attr( $selected_type ); ?>">
				<?php endif; ?>
				<label>
					<span class="screen-reader-text">Sắp xếp dự án</span>
					<select name="project_sort" onchange="this.form.submit()">
						<option value="newest" <?php selected( $selected_sort, 'newest' ); ?>>Sắp xếp: Mới nhất</option>
						<option value="oldest" <?php selected( $selected_sort, 'oldest' ); ?>>Sắp xếp: Cũ nhất</option>
						<option value="title" <?php selected( $selected_sort, 'title' ); ?>>Sắp xếp: Tên A-Z</option>
					</select>
				</label>
			</form>
		</div>

		<div class="project-listing-grid">
			<?php if ( $has_real_posts ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					$project_id = get_the_ID();
					$terms      = get_the_terms( $project_id, 'luxnova_project_type' );
					$type       = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0]->name : 'Dự án';
					$card       = array(
						'title' => get_the_title(),
						'type' => $type,
						'location' => function_exists( 'get_field' ) ? ( get_field( 'location', $project_id ) ?: 'Hà Nội' ) : 'Hà Nội',
						'area' => function_exists( 'get_field' ) ? ( get_field( 'area', $project_id ) ?: '' ) : '',
						'style' => function_exists( 'get_field' ) ? ( get_field( 'style', $project_id ) ?: '' ) : '',
						'year' => get_the_date( 'Y' ),
						'image' => get_post_thumbnail_id( $project_id ),
						'url' => get_permalink(),
					);
					luxnova_render_project_listing_card( $card );
					?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php foreach ( $fallback_cards as $card ) : ?>
					<?php luxnova_render_project_listing_card( $card ); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<?php if ( $has_real_posts ) : ?>
			<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
		<?php else : ?>
			<nav class="project-archive-pagination" aria-label="Phân trang dự án">
				<span class="is-current">1</span>
				<a href="#">2</a>
				<a href="#">3</a>
				<span>...</span>
				<a href="#">12</a>
				<a href="#" aria-label="Trang tiếp theo">›</a>
			</nav>
		<?php endif; ?>
	</div>
</section>

<section class="project-consultation-cta">
	<div class="project-consultation-cta__image" aria-hidden="true">
		<?php echo luxnova_image( '', 'luxnova-card', array( 'alt' => '' ), 'assets/images/placeholder-interior.svg' ); ?>
	</div>
	<div class="container project-consultation-cta__inner">
		<div>
			<h2>Bạn có dự án cần tư vấn?</h2>
			<p>Đội ngũ LuxNova luôn sẵn sàng lắng nghe và đưa ra giải pháp thiết kế tối ưu nhất cho không gian của bạn.</p>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal">Đặt lịch tư vấn <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
