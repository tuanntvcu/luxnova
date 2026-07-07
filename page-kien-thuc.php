<?php
/**
 * Knowledge page template.
 *
 * Template Name: LuxNova Knowledge
 *
 * @package LuxNova
 */

get_header();

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

if ( function_exists( 'luxnova_knowledge_paged_from_request' ) ) {
	$paged = max( $paged, luxnova_knowledge_paged_from_request() );
}

$knowledge_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'ignore_sticky_posts' => false,
	)
);
?>
<section class="knowledge-hero">
	<div class="container knowledge-hero__inner reveal-on-scroll">
		<p class="knowledge-hero__eyebrow"><?php esc_html_e( 'LuxNova Journal', 'luxnova' ); ?></p>
		<h1><?php esc_html_e( 'Kiến thức', 'luxnova' ); ?></h1>
		<p><?php esc_html_e( 'Góc chia sẻ về thiết kế, thi công nội thất, vật liệu và cách tối ưu không gian sống theo tinh thần tinh tế, bền vững.', 'luxnova' ); ?></p>
	</div>
</section>

<section class="knowledge-listing">
	<div class="container">
		<?php if ( $knowledge_query->have_posts() ) : ?>
			<div class="knowledge-grid">
				<?php
				$index = 0;
				while ( $knowledge_query->have_posts() ) :
					$knowledge_query->the_post();
					$categories = get_the_category();
					$category   = ! empty( $categories ) ? $categories[0]->name : __( 'Kiến thức', 'luxnova' );
					?>
					<article <?php post_class( 'knowledge-card reveal-on-scroll ' . ( 0 === $index ? 'knowledge-card--featured' : '' ) ); ?>>
						<a class="knowledge-card__image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 0 === $index ? 'luxnova-hero' : 'luxnova-card' );
							} else {
								echo luxnova_image( '', 0 === $index ? 'luxnova-hero' : 'luxnova-card', array( 'alt' => esc_attr( get_the_title() ) ), 'assets/images/placeholder-interior.svg' );
							}
							?>
						</a>
						<div class="knowledge-card__body">
							<div class="knowledge-card__meta">
								<span><?php echo esc_html( $category ); ?></span>
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 24 ) ); ?></p>
							<a class="knowledge-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Đọc tiếp', 'luxnova' ); ?> <span aria-hidden="true">-&gt;</span></a>
						</div>
					</article>
					<?php
					$index++;
				endwhile;
				?>
			</div>

			<?php
			$pagination = paginate_links(
				array(
					'base'      => trailingslashit( luxnova_knowledge_url() ) . '%_%',
					'format'    => 'page/%#%/',
					'current'   => $paged,
					'total'     => $knowledge_query->max_num_pages,
					'mid_size'  => 1,
					'prev_text' => __( 'Trước', 'luxnova' ),
					'next_text' => __( 'Sau', 'luxnova' ),
				)
			);
			?>
			<?php if ( $pagination ) : ?>
				<nav class="navigation pagination knowledge-pagination" aria-label="<?php esc_attr_e( 'Knowledge pagination', 'luxnova' ); ?>">
					<div class="nav-links"><?php echo wp_kses_post( $pagination ); ?></div>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<div class="knowledge-empty reveal-on-scroll">
				<h2><?php esc_html_e( 'Chưa có bài viết', 'luxnova' ); ?></h2>
				<p><?php esc_html_e( 'Các bài chia sẻ mới sẽ được cập nhật tại đây.', 'luxnova' ); ?></p>
			</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
<?php
get_footer();
