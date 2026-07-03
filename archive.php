<?php
/**
 * Archive template.
 *
 * @package LuxNova
 */

get_header();
?>
<section class="content-section content-section--top">
	<div class="container">
		<header class="archive-header">
			<h1><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<div class="archive-header__description">', '</div>' ); ?>
		</header>
		<div class="archive-grid">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'entry-card reveal-on-scroll' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="entry-card__image"><?php the_post_thumbnail( 'luxnova-card' ); ?></a>
						<?php endif; ?>
						<h2 class="entry-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry-card__excerpt"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No posts found.', 'luxnova' ); ?></p>
			<?php endif; ?>
		</div>
		<?php the_posts_pagination(); ?>
	</div>
</section>
<?php
get_footer();
