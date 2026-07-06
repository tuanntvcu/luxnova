<?php
/**
 * FAQ page template.
 *
 * Template Name: LuxNova FAQ
 *
 * @package LuxNova
 */

get_header();

$page_data   = luxnova_faq_page_data();
$hero        = $page_data['hero'] ?? array();
$sidebar     = $page_data['sidebar'] ?? array();
$faq_items   = $page_data['items'] ?? array();
$closing_cta = $page_data['closing_cta'] ?? array();
?>
<section class="faq-hero">
	<div class="faq-hero__media" aria-hidden="true">
		<?php echo luxnova_image( $hero['image'] ?? '', 'luxnova-hero', array( 'class' => 'faq-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-service-2.svg' ); ?>
	</div>
	<div class="faq-hero__overlay"></div>
	<div class="container faq-hero__content reveal-on-scroll">
		<?php if ( ! empty( $hero['eyebrow'] ) ) : ?>
			<p class="faq-hero__eyebrow"><?php echo esc_html( $hero['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1>
			<?php echo esc_html( $hero['title'] ?? '' ); ?>
			<?php if ( ! empty( $hero['highlight'] ) ) : ?>
				<span><?php echo esc_html( $hero['highlight'] ); ?></span>
			<?php endif; ?>
		</h1>
		<?php if ( ! empty( $hero['description'] ) ) : ?>
			<p><?php echo esc_html( $hero['description'] ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="faq-section">
	<div class="container faq-section__grid">
		<aside class="faq-sidebar reveal-on-scroll">
			<header class="service-section-heading">
				<h2><?php echo esc_html( $sidebar['heading'] ?? '' ); ?></h2>
			</header>
			<?php if ( ! empty( $sidebar['description'] ) ) : ?>
				<p><?php echo esc_html( $sidebar['description'] ); ?></p>
			<?php endif; ?>
			<a class="button button--outline-dark" href="<?php echo esc_url( $sidebar['button_url'] ?? home_url( '/lien-he/' ) ); ?>"><?php echo luxnova_icon_media( array( 'icon' => $sidebar['button_icon'] ?? 'mail', 'icon_image' => $sidebar['button_icon_image'] ?? '' ), 'mail' ); ?> <?php echo esc_html( $sidebar['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
		</aside>

		<div class="faq-list reveal-on-scroll">
			<?php foreach ( $faq_items as $index => $item ) : ?>
				<details class="faq-item" <?php echo 0 === $index ? 'open' : ''; ?>>
					<summary>
						<span><?php echo esc_html( (string) ( $index + 1 ) . '. ' . ( $item['question'] ?? '' ) ); ?></span>
					</summary>
					<div class="faq-item__answer">
						<p><?php echo esc_html( $item['answer'] ?? '' ); ?></p>
					</div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="faq-closing-cta">
	<div class="faq-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( $closing_cta['image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $closing_cta['image_fallback'] ?? 'assets/images/placeholder-interior.svg' ); ?>
	</div>
	<div class="container faq-closing-cta__inner">
		<div>
			<?php if ( ! empty( $closing_cta['eyebrow'] ) ) : ?>
				<p><?php echo esc_html( $closing_cta['eyebrow'] ); ?></p>
			<?php endif; ?>
			<h2><?php echo esc_html( $closing_cta['title'] ?? '' ); ?></h2>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $closing_cta['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
