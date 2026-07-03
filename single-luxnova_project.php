<?php
/**
 * Single project template.
 *
 * @package LuxNova
 */

get_header();

while ( have_posts() ) :
	the_post();

	$project_id = get_the_ID();
	$terms      = get_the_terms( $project_id, 'luxnova_project_type' );
	$type       = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0]->name : 'Penthouse';
	$location   = function_exists( 'get_field' ) ? ( get_field( 'location', $project_id ) ?: 'TP. Hồ Chí Minh' ) : 'TP. Hồ Chí Minh';
	$area       = function_exists( 'get_field' ) ? ( get_field( 'area', $project_id ) ?: '450m²' ) : '450m²';
	$style      = function_exists( 'get_field' ) ? ( get_field( 'style', $project_id ) ?: 'Modern Luxury' ) : 'Modern Luxury';
	$year       = function_exists( 'get_field' ) ? ( get_field( 'completion_year', $project_id ) ?: get_the_date( 'Y' ) ) : get_the_date( 'Y' );
	$scope      = function_exists( 'get_field' ) ? ( get_field( 'scope', $project_id ) ?: 'Thiết kế & Thi công nội thất' ) : 'Thiết kế & Thi công nội thất';
	$architect  = function_exists( 'get_field' ) ? ( get_field( 'architect', $project_id ) ?: 'LuxNova Design Team' ) : 'LuxNova Design Team';
	$brochure   = function_exists( 'get_field' ) ? get_field( 'brochure', $project_id ) : '';
	$brochure_url = luxnova_project_brochure_url( $brochure );
	$brochure_download_attr = '#project-info' === $brochure_url ? '' : ' download';
	$gallery    = function_exists( 'get_field' ) ? (array) get_field( 'gallery', $project_id ) : array();
	$hero_image = get_post_thumbnail_id( $project_id );
	$summary    = has_excerpt() ? get_the_excerpt() : 'Không gian penthouse mang phong cách Modern Luxury, kết hợp vật liệu tự nhiên và đường nét tinh giản để tạo nên sự sang trọng vượt thời gian.';

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
	?>
	<article <?php post_class( 'single-project' ); ?>>
		<section class="single-project-hero">
			<div class="single-project-hero__media" aria-hidden="true">
				<?php echo luxnova_image( $hero_image, 'luxnova-hero', array( 'class' => 'single-project-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), 'assets/images/placeholder-project-2.svg' ); ?>
			</div>
			<div class="single-project-hero__overlay"></div>
			<div class="container single-project-hero__content">
				<nav class="single-project-breadcrumb" aria-label="Breadcrumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a>
					<span aria-hidden="true">›</span>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ) ); ?>">Dự án</a>
					<span aria-hidden="true">›</span>
					<span><?php the_title(); ?></span>
				</nav>

				<p class="single-project-hero__type"><?php echo esc_html( $type ); ?></p>
				<h1><?php the_title(); ?></h1>
				<p class="single-project-hero__summary"><?php echo esc_html( $summary ); ?></p>

				<ul class="single-project-hero__meta">
					<li><?php echo luxnova_icon( 'pin' ); ?><span>Địa điểm</span><strong><?php echo esc_html( $location ); ?></strong></li>
					<li><?php echo luxnova_icon( 'measure' ); ?><span>Diện tích</span><strong><?php echo esc_html( $area ); ?></strong></li>
					<li><?php echo luxnova_icon( 'home' ); ?><span>Phong cách</span><strong><?php echo esc_html( $style ); ?></strong></li>
					<li><?php echo luxnova_icon( 'document' ); ?><span>Năm hoàn thành</span><strong><?php echo esc_html( $year ); ?></strong></li>
				</ul>

				<div class="single-project-hero__actions">
					<a href="#consultation-modal" class="button button--gold js-consultation-modal">Đặt lịch tư vấn <span aria-hidden="true">→</span></a>
					<a href="<?php echo esc_url( $brochure_url ); ?>" class="button button--outline"<?php echo $brochure_download_attr; ?>>Tải hồ sơ dự án <span aria-hidden="true">↓</span></a>
				</div>
			</div>
			<a class="single-project-hero__gallery-link" href="#project-gallery">Xem ảnh (1/<?php echo esc_html( (string) count( $gallery ) ); ?>) <span aria-hidden="true">⌗</span></a>
		</section>

		<section class="single-project-story" id="project-info">
			<div class="container single-project-story__grid">
				<div class="single-project-story__content">
					<h2>Câu chuyện dự án</h2>
					<div class="single-project-story__text">
						<?php if ( trim( get_the_content() ) ) : ?>
							<?php the_content(); ?>
						<?php else : ?>
							<p>Tọa lạc trên tầng cao nhất của một biểu tượng đô thị, dự án được LuxNova định hình như một không gian sống riêng tư, cân bằng giữa ánh sáng tự nhiên, vật liệu cao cấp và nhịp sống hiện đại.</p>
							<p>LuxNova đã kiến tạo một không gian mở, tràn ngập ánh sáng tự nhiên, sử dụng các vật liệu cao cấp như đá marble, gỗ óc chó, da thật và kim loại mạ đồng. Từng chi tiết được thiết kế riêng, thể hiện đẳng cấp và phong cách sống thượng lưu.</p>
						<?php endif; ?>
					</div>

					<div class="single-project-features">
						<div><?php echo luxnova_icon( 'home' ); ?><h3>Tối ưu công năng</h3><p>Bố cục không gian hợp lý, đáp ứng mọi nhu cầu sinh hoạt.</p></div>
						<div><?php echo luxnova_icon( 'design' ); ?><h3>Vật liệu cao cấp</h3><p>Lựa chọn kỹ lưỡng các vật liệu tự nhiên và nhập khẩu cao cấp.</p></div>
						<div><?php echo luxnova_icon( 'users' ); ?><h3>Thiết kế tinh tế</h3><p>Đường nét tinh giản, màu sắc trung tính tạo nên vẻ đẹp sang trọng.</p></div>
					</div>
				</div>

				<aside class="single-project-info-card">
					<h2>Thông tin dự án</h2>
					<dl>
						<div><dt>Loại công trình</dt><dd><?php echo esc_html( $type ); ?></dd></div>
						<div><dt>Địa điểm</dt><dd><?php echo esc_html( $location ); ?></dd></div>
						<div><dt>Diện tích</dt><dd><?php echo esc_html( $area ); ?></dd></div>
						<div><dt>Phong cách</dt><dd><?php echo esc_html( $style ); ?></dd></div>
						<div><dt>Năm hoàn thành</dt><dd><?php echo esc_html( $year ); ?></dd></div>
						<div><dt>Hạng mục thực hiện</dt><dd><?php echo esc_html( $scope ); ?></dd></div>
						<div><dt>Kiến trúc sư</dt><dd><?php echo esc_html( $architect ); ?></dd></div>
					</dl>
					<a href="<?php echo esc_url( $brochure_url ); ?>" class="button button--outline"<?php echo $brochure_download_attr; ?>>Tải hồ sơ dự án <span aria-hidden="true">↓</span></a>
				</aside>
			</div>
		</section>

		<section class="single-project-gallery" id="project-gallery">
			<div class="container">
				<header class="single-project-section-heading">
					<h2>Thư viện hình ảnh</h2>
				</header>
				<div class="single-project-gallery__grid">
					<?php foreach ( array_slice( $gallery, 0, 6 ) as $index => $image ) : ?>
						<a class="single-project-gallery__item <?php echo 0 === $index ? 'is-large' : ''; ?>" href="<?php echo esc_url( luxnova_image_url( $image, 'luxnova-hero', 'assets/images/placeholder-project-2.svg' ) ); ?>">
							<?php echo luxnova_image( $image, 0 === $index ? 'luxnova-hero' : 'luxnova-card', array( 'alt' => esc_attr( get_the_title() . ' gallery image' ) ), 'assets/images/placeholder-project-2.svg' ); ?>
							<?php if ( 0 === $index ) : ?><span aria-hidden="true">▶</span><?php endif; ?>
							<?php if ( 5 === $index && count( $gallery ) > 6 ) : ?><strong>+<?php echo esc_html( (string) ( count( $gallery ) - 5 ) ); ?><small>Xem thêm ảnh</small></strong><?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="single-project-benefits" aria-label="LuxNova project benefits">
			<div class="container single-project-benefits__grid">
				<div><?php echo luxnova_icon( 'users' ); ?><strong>Thiết kế cá nhân hóa</strong><span>Đo ni đóng giày theo phong cách riêng</span></div>
				<div><?php echo luxnova_icon( 'tools' ); ?><strong>Thi công trọn gói</strong><span>Đảm bảo tiến độ và chất lượng</span></div>
				<div><?php echo luxnova_icon( 'shield' ); ?><strong>Bảo hành 5 năm</strong><span>Cam kết đồng hành lâu dài</span></div>
				<div><?php echo luxnova_icon( 'design' ); ?><strong>Vật liệu cao cấp</strong><span>Nguồn gốc rõ ràng, tiêu chuẩn quốc tế</span></div>
			</div>
		</section>

		<section class="single-project-related">
			<div class="container">
				<header class="section-heading">
					<h2>Dự án liên quan</h2>
					<a class="section-heading__link" href="<?php echo esc_url( get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' ) ); ?>">Xem tất cả dự án <span aria-hidden="true">→</span></a>
				</header>
				<div class="single-project-related__grid">
					<?php
					$related = new WP_Query(
						array(
							'post_type' => 'luxnova_project',
							'posts_per_page' => 4,
							'post__not_in' => array( $project_id ),
						)
					);
					if ( $related->have_posts() ) :
						while ( $related->have_posts() ) :
							$related->the_post();
							$related_id = get_the_ID();
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
	</article>
	<?php
endwhile;

get_footer();
