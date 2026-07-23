<?php
/**
 * Design style detail page template.
 *
 * Template Name: LuxNova Design Style Detail
 *
 * @package LuxNova
 */

get_header();

$page_id       = (int) get_queried_object_id();
$page_data     = luxnova_design_style_detail_page_data( $page_id );
$hero          = $page_data['hero'] ?? array();
$closing_cta   = $page_data['closing_cta'] ?? array();
$project_cards = luxnova_design_style_project_cards( $page_data, 3 );
$related_cards = luxnova_design_style_related_cards( $page_data, 4 );
$projects_link = is_array( $page_data['projects_link'] ?? null ) ? $page_data['projects_link'] : array();
$primary_link  = is_array( $closing_cta['primary_link'] ?? null ) ? $closing_cta['primary_link'] : array();
$secondary_link = is_array( $closing_cta['secondary_link'] ?? null ) ? $closing_cta['secondary_link'] : array();
$filters       = array();

if ( empty( $projects_link['url'] ) ) {
	$projects_link = array( 'url' => get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ), 'title' => $page_data['projects_link_label'] ?? 'Xem tất cả dự án', 'target' => '' );
}

if ( empty( $primary_link['url'] ) ) {
	$primary_link = array( 'url' => '#consultation-modal', 'title' => $closing_cta['primary_label'] ?? 'Nhận tư vấn miễn phí', 'target' => '' );
}

if ( empty( $secondary_link['url'] ) ) {
	$secondary_link = array( 'url' => home_url( '/bang-gia/' ), 'title' => $closing_cta['secondary_label'] ?? 'Xem bảng giá', 'target' => '' );
}

foreach ( (array) ( $page_data['collection_filters'] ?? array() ) as $filter ) {
	$filters[] = is_array( $filter ) ? ( $filter['label'] ?? '' ) : $filter;
}
$filters = array_values( array_filter( array_map( 'strval', $filters ) ) );
?>
<section class="design-style-detail-hero">
	<div class="design-style-detail-hero__media" aria-hidden="true">
		<?php echo luxnova_responsive_image( $hero['image'] ?? '', $hero['mobile_image'] ?? '', 'luxnova-hero', array( 'class' => 'design-style-detail-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="design-style-detail-hero__overlay"></div>
	<div class="container design-style-detail-hero__content reveal-on-scroll">
		<nav class="design-style-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'luxnova' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $hero['home_label'] ?? 'Trang chủ' ); ?></a>
			<span aria-hidden="true">›</span>
			<a href="<?php echo esc_url( luxnova_design_styles_url() ); ?>"><?php echo esc_html( $hero['parent_label'] ?? 'Phong cách thiết kế' ); ?></a>
			<span aria-hidden="true">›</span>
			<span><?php echo esc_html( $hero['title'] ?? '' ); ?></span>
		</nav>
		<h1><?php echo esc_html( $hero['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $hero['subtitle'] ) ) : ?>
			<p><?php echo esc_html( $hero['subtitle'] ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="design-style-detail">
	<div class="container">
		<?php if ( ! empty( $page_data['meta'] ) ) : ?>
			<div class="design-style-meta reveal-on-scroll">
				<?php foreach ( (array) $page_data['meta'] as $item ) : ?>
					<div class="design-style-meta__item">
						<span><?php echo luxnova_icon_media( (array) $item, (string) ( $item['icon'] ?? 'design' ) ); ?></span>
						<div>
							<em><?php echo esc_html( $item['label'] ?? '' ); ?></em>
							<strong><?php echo esc_html( $item['value'] ?? '' ); ?></strong>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $page_data['summary'] ) ) : ?>
			<div class="design-style-summary reveal-on-scroll">
				<p><?php echo esc_html( $page_data['summary'] ); ?></p>
			</div>
		<?php endif; ?>

		<section class="design-style-block">
			<h2><?php echo esc_html( $page_data['features_heading'] ?? '' ); ?></h2>
			<div class="design-style-feature-grid">
				<?php foreach ( (array) ( $page_data['features'] ?? array() ) as $feature ) : ?>
					<article class="design-style-feature reveal-on-scroll">
						<span><?php echo luxnova_icon_media( (array) $feature, (string) ( $feature['icon'] ?? 'shield' ) ); ?></span>
						<h3><?php echo esc_html( $feature['title'] ?? '' ); ?></h3>
						<p><?php echo esc_html( $feature['description'] ?? '' ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="design-style-block">
			<h2><?php echo esc_html( $page_data['collection_heading'] ?? '' ); ?></h2>
			<?php if ( ! empty( $filters ) ) : ?>
				<div class="design-style-filter-tabs" aria-label="<?php esc_attr_e( 'Bộ lọc bộ sưu tập', 'luxnova' ); ?>">
					<?php foreach ( $filters as $index => $filter ) : ?>
						<button type="button" class="<?php echo 0 === $index ? 'is-active' : ''; ?>"><?php echo esc_html( $filter ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="design-style-gallery">
				<?php foreach ( (array) ( $page_data['gallery'] ?? array() ) as $index => $item ) : ?>
					<figure class="<?php echo in_array( $index, array( 0, 3, 6 ), true ) ? 'is-tall' : ''; ?> reveal-on-scroll">
						<?php echo luxnova_image( $item['image'] ?? '', 'luxnova-card', array( 'alt' => esc_attr( $item['label'] ?? ( $hero['title'] ?? '' ) ) ), 'assets/images/placeholder-interior.svg' ); ?>
					</figure>
				<?php endforeach; ?>
			</div>
		</section>

		<div class="design-style-duo">
			<section class="design-style-block">
				<h2><?php echo esc_html( $page_data['palette_heading'] ?? '' ); ?></h2>
				<div class="design-style-palette">
					<?php foreach ( (array) ( $page_data['palette'] ?? array() ) as $color ) : ?>
						<div>
							<span style="--swatch-color: <?php echo esc_attr( $color['color'] ?? '#d6a84f' ); ?>"></span>
							<em><?php echo esc_html( $color['name'] ?? '' ); ?></em>
						</div>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="design-style-block">
				<h2><?php echo esc_html( $page_data['materials_heading'] ?? '' ); ?></h2>
				<div class="design-style-materials">
					<?php foreach ( (array) ( $page_data['materials'] ?? array() ) as $material ) : ?>
						<div>
							<?php echo luxnova_image( $material['image'] ?? '', 'thumbnail', array( 'alt' => esc_attr( $material['title'] ?? '' ) ), 'assets/images/placeholder-interior.svg' ); ?>
							<em><?php echo esc_html( $material['title'] ?? '' ); ?></em>
						</div>
					<?php endforeach; ?>
				</div>
			</section>
		</div>

		<section class="design-style-block">
			<h2><?php echo esc_html( $page_data['audience_heading'] ?? '' ); ?></h2>
			<div class="design-style-audience-grid">
				<?php foreach ( (array) ( $page_data['audience'] ?? array() ) as $audience ) : ?>
					<article class="design-style-audience reveal-on-scroll">
						<span><?php echo luxnova_icon_media( (array) $audience, (string) ( $audience['icon'] ?? 'home' ) ); ?></span>
						<h3><?php echo esc_html( $audience['title'] ?? '' ); ?></h3>
						<p><?php echo esc_html( $audience['description'] ?? '' ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="design-style-block">
			<h2><?php echo esc_html( $page_data['budget_heading'] ?? '' ); ?></h2>
			<div class="design-style-budget-grid">
				<?php foreach ( (array) ( $page_data['budgets'] ?? array() ) as $budget ) : ?>
					<article class="design-style-budget reveal-on-scroll">
						<strong><?php echo esc_html( $budget['label'] ?? '' ); ?></strong>
						<span><?php echo esc_html( $budget['area'] ?? '' ); ?></span>
						<em><?php echo esc_html( $budget['price'] ?? '' ); ?></em>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="design-style-block">
			<div class="design-style-section-head">
				<h2><?php echo esc_html( $page_data['projects_heading'] ?? '' ); ?></h2>
				<a href="<?php echo esc_url( $projects_link['url'] ); ?>" <?php echo ! empty( $projects_link['target'] ) ? 'target="' . esc_attr( $projects_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $page_data['projects_link_label'] ?? ( $projects_link['title'] ?? 'Xem tất cả dự án' ) ); ?> <span aria-hidden="true">-&gt;</span></a>
			</div>
			<div class="design-style-project-grid">
				<?php foreach ( $project_cards as $project_card ) : ?>
					<article class="design-style-project-card reveal-on-scroll">
						<a href="<?php echo esc_url( $project_card['url'] ?? '#' ); ?>">
							<?php echo luxnova_image( $project_card['image'] ?? '', 'luxnova-card', array( 'alt' => esc_attr( $project_card['title'] ?? '' ) ), 'assets/images/placeholder-project-1.svg' ); ?>
							<span>
								<strong><?php echo esc_html( $project_card['title'] ?? '' ); ?></strong>
								<em><?php echo esc_html( $project_card['meta'] ?? '' ); ?></em>
							</span>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="design-style-block">
			<h2><?php echo esc_html( $page_data['related_heading'] ?? '' ); ?></h2>
			<div class="design-style-related-grid">
				<?php foreach ( $related_cards as $related_card ) : ?>
					<article class="design-style-related-card reveal-on-scroll">
						<a class="design-style-related-card__image" href="<?php echo esc_url( $related_card['url'] ?? '#' ); ?>">
							<?php echo luxnova_image( $related_card['image'] ?? '', 'luxnova-card', array( 'alt' => esc_attr( $related_card['title'] ?? '' ) ), 'assets/images/placeholder-interior.svg' ); ?>
						</a>
						<h3><a href="<?php echo esc_url( $related_card['url'] ?? '#' ); ?>"><?php echo esc_html( $related_card['title'] ?? '' ); ?></a></h3>
						<p><?php echo esc_html( $related_card['excerpt'] ?? '' ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
	</div>
</section>

<section class="design-style-closing-cta">
	<div class="container design-style-closing-cta__inner reveal-on-scroll">
		<div>
			<h2><?php echo esc_html( $closing_cta['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $closing_cta['description'] ) ) : ?>
				<p><?php echo esc_html( $closing_cta['description'] ); ?></p>
			<?php endif; ?>
		</div>
		<div class="design-style-closing-cta__actions">
			<a class="button button--gold <?php echo '#consultation-modal' === ( $primary_link['url'] ?? '' ) ? 'js-consultation-modal' : ''; ?>" href="<?php echo esc_url( $primary_link['url'] ); ?>" <?php echo ! empty( $primary_link['target'] ) ? 'target="' . esc_attr( $primary_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $closing_cta['primary_label'] ?? ( $primary_link['title'] ?? 'Nhận tư vấn miễn phí' ) ); ?></a>
			<a class="button button--outline" href="<?php echo esc_url( $secondary_link['url'] ); ?>" <?php echo ! empty( $secondary_link['target'] ) ? 'target="' . esc_attr( $secondary_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $closing_cta['secondary_label'] ?? ( $secondary_link['title'] ?? 'Xem bảng giá' ) ); ?></a>
		</div>
	</div>
</section>
<?php
get_footer();
