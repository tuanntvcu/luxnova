<?php
/**
 * Front page template.
 *
 * @package LuxNova
 */

get_header();

$section_paths = array(
	'hero' => 'template-parts/hero/hero',
	'statistics' => 'template-parts/statistics/statistics',
	'services' => 'template-parts/services/services',
	'featured_projects' => 'template-parts/projects/featured-projects',
	'home_audit_cta' => 'template-parts/cta/home-audit',
	'work_process' => 'template-parts/process/work-process',
	'testimonials' => 'template-parts/testimonials/testimonials',
	'partner_logos' => 'template-parts/partners/partner-logos',
);

$sections = luxnova_get_homepage_sections();
$count    = count( $sections );

for ( $index = 0; $index < $count; $index++ ) {
	$section = $sections[ $index ];
	$layout = $section['layout'] ?? '';

	if ( 'hero' === $layout && isset( $sections[ $index + 1 ] ) && 'statistics' === ( $sections[ $index + 1 ]['layout'] ?? '' ) ) {
		$section['statistics'] = $sections[ $index + 1 ];
		get_template_part( $section_paths['hero'], null, array( 'section' => $section ) );
		$index++;
		continue;
	}

	if ( isset( $section_paths[ $layout ] ) ) {
		get_template_part( $section_paths[ $layout ], null, array( 'section' => $section ) );
	}
}

get_footer();
