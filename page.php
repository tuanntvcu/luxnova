<?php
/**
 * Page template.
 *
 * @package LuxNova
 */

get_header();
?>
<section class="content-section content-section--top">
	<div class="container content-layout content-layout--narrow">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'entry-content' ); ?>>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php
get_footer();
