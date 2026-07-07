<?php
/**
 * Pricing page template.
 *
 * Template Name: LuxNova Pricing
 *
 * @package LuxNova
 */

get_header();

$page_data   = luxnova_pricing_page_data();
$hero        = $page_data['hero'] ?? array();
$closing_cta = $page_data['closing_cta'] ?? array();
?>
<section class="pricing-page-hero">
	<div class="pricing-page-hero__media" aria-hidden="true">
		<?php echo luxnova_responsive_image( $hero['image'] ?? '', $hero['mobile_image'] ?? '', 'luxnova-hero', array( 'class' => 'pricing-page-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-service-2.svg' ); ?>
	</div>
	<div class="pricing-page-hero__overlay"></div>
	<div class="container pricing-page-hero__content reveal-on-scroll">
		<?php if ( ! empty( $hero['eyebrow'] ) ) : ?>
			<p class="pricing-page-hero__eyebrow"><?php echo esc_html( $hero['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1><?php echo esc_html( $hero['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $hero['description'] ) ) : ?>
			<p><?php echo esc_html( $hero['description'] ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="pricing-plans">
	<div class="container">
		<header class="service-section-heading">
			<h2><?php echo esc_html( $page_data['plans_heading'] ?? '' ); ?></h2>
		</header>
		<div class="pricing-plans__grid">
			<?php foreach ( luxnova_pricing_plans() as $plan ) : ?>
				<article class="pricing-card <?php echo ! empty( $plan['featured'] ) ? 'is-featured' : ''; ?> reveal-on-scroll">
					<?php if ( ! empty( $plan['featured'] ) ) : ?>
						<span class="pricing-card__ribbon"><?php echo esc_html( $plan['ribbon'] ?? '' ); ?></span>
					<?php endif; ?>
					<p class="pricing-card__label"><?php echo esc_html( $plan['label'] ); ?></p>
					<h2><?php echo esc_html( $plan['title'] ); ?></h2>
					<div class="pricing-card__price">
						<strong><?php echo esc_html( $plan['price'] ); ?></strong>
						<span><?php echo esc_html( $plan['unit'] ); ?></span>
					</div>
					<ul>
						<?php foreach ( $plan['features'] as $feature ) : ?>
							<li><?php echo esc_html( $feature ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a href="#consultation-modal" class="button <?php echo ! empty( $plan['featured'] ) ? 'button--gold' : 'button--outline-dark'; ?> js-consultation-modal"><?php echo esc_html( $plan['button_label'] ?? '' ); ?></a>
				</article>
			<?php endforeach; ?>
		</div>
		<?php if ( ! empty( $page_data['plans_note'] ) ) : ?>
			<p class="pricing-plans__note"><?php echo esc_html( $page_data['plans_note'] ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="cost-factors">
	<div class="container">
		<header class="service-section-heading">
			<h2><?php echo esc_html( $page_data['factors_heading'] ?? '' ); ?></h2>
		</header>
		<div class="cost-factors__grid">
			<?php foreach ( luxnova_cost_factors() as $factor ) : ?>
				<div class="cost-factors__item reveal-on-scroll">
					<?php echo luxnova_icon_media( $factor, 'measure' ); ?>
					<strong><?php echo esc_html( $factor['title'] ); ?></strong>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="pricing-faq">
	<div class="container pricing-faq__grid">
		<div>
			<header class="service-section-heading">
				<h2><?php echo esc_html( $page_data['faq_heading'] ?? '' ); ?></h2>
			</header>
			<div class="pricing-faq__list">
				<?php foreach ( luxnova_pricing_faqs() as $index => $faq ) : ?>
					<details <?php echo 0 === $index ? 'open' : ''; ?>>
						<summary><?php echo esc_html( $faq['question'] ); ?></summary>
						<p><?php echo esc_html( $faq['answer'] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="pricing-faq__image" aria-hidden="true">
			<?php echo luxnova_image( $page_data['faq_image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $page_data['faq_image_fallback'] ?? 'assets/images/placeholder-service-3.svg' ); ?>
		</div>
	</div>
</section>

<section class="pricing-closing-cta">
	<div class="pricing-closing-cta__image" aria-hidden="true">
		<?php echo luxnova_image( $closing_cta['image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $closing_cta['image_fallback'] ?? 'assets/images/placeholder-project-1.svg' ); ?>
	</div>
	<div class="container pricing-closing-cta__inner">
		<div>
			<h2><?php echo esc_html( $closing_cta['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $closing_cta['description'] ) ) : ?>
				<p><?php echo esc_html( $closing_cta['description'] ); ?></p>
			<?php endif; ?>
		</div>
		<a href="#consultation-modal" class="button button--gold js-consultation-modal"><?php echo esc_html( $closing_cta['button_label'] ?? '' ); ?> <span aria-hidden="true">→</span></a>
	</div>
</section>
<?php
get_footer();
