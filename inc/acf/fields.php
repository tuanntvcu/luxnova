<?php
/**
 * ACF local field groups.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'luxnova_register_acf_fields' );
function luxnova_register_acf_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_homepage',
			'title' => 'Homepage Sections',
			'fields' => array(
				array(
					'key' => 'field_luxnova_homepage_sections',
					'label' => 'Homepage Sections',
					'name' => 'homepage_sections',
					'type' => 'flexible_content',
					'button_label' => 'Add Section',
					'layouts' => luxnova_acf_homepage_layouts(),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'page_type',
						'operator' => '==',
						'value' => 'front_page',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_project_details',
			'title' => 'Project Details',
			'fields' => array(
				luxnova_acf_text( 'field_luxnova_project_area', 'Area', 'area' ),
				luxnova_acf_text( 'field_luxnova_project_style', 'Style', 'style' ),
				luxnova_acf_text( 'field_luxnova_project_budget', 'Budget', 'budget' ),
				luxnova_acf_text( 'field_luxnova_project_timeline', 'Timeline', 'timeline' ),
				luxnova_acf_text( 'field_luxnova_project_location', 'Location', 'location' ),
				luxnova_acf_text( 'field_luxnova_project_completion_year', 'Completion Year', 'completion_year' ),
				luxnova_acf_text( 'field_luxnova_project_scope', 'Scope', 'scope', 'Thiết kế & Thi công nội thất' ),
				luxnova_acf_text( 'field_luxnova_project_architect', 'Architect', 'architect', 'LuxNova Design Team' ),
				array( 'key' => 'field_luxnova_project_brochure', 'label' => 'Brochure', 'name' => 'brochure', 'type' => 'file', 'return_format' => 'array' ),
				array( 'key' => 'field_luxnova_project_gallery', 'label' => 'Gallery', 'name' => 'gallery', 'type' => 'gallery', 'return_format' => 'id' ),
			),
			'location' => array(
				array(
					array( 'param' => 'post_type', 'operator' => '==', 'value' => 'luxnova_project' ),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_testimonial_details',
			'title' => 'Testimonial Details',
			'fields' => array(
				array( 'key' => 'field_luxnova_testimonial_rating', 'label' => 'Rating', 'name' => 'rating', 'type' => 'number', 'min' => 1, 'max' => 5, 'default_value' => 5 ),
				luxnova_acf_text( 'field_luxnova_testimonial_context', 'Project Context', 'project_context' ),
				array( 'key' => 'field_luxnova_testimonial_avatar', 'label' => 'Avatar', 'name' => 'avatar', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail' ),
			),
			'location' => array(
				array(
					array( 'param' => 'post_type', 'operator' => '==', 'value' => 'luxnova_testimonial' ),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_options',
			'title' => 'Global Theme Settings',
			'fields' => array(
				luxnova_acf_text( 'field_luxnova_brand_logo_text', 'Brand Logo Text', 'brand_logo_text', 'LUXNOVA' ),
				luxnova_acf_text( 'field_luxnova_brand_tagline', 'Brand Tagline', 'brand_tagline', 'Interior Design & Build' ),
				array( 'key' => 'field_luxnova_header_cta', 'label' => 'Header CTA', 'name' => 'header_cta', 'type' => 'link', 'return_format' => 'array' ),
				array( 'key' => 'field_luxnova_footer_description', 'label' => 'Footer Description', 'name' => 'footer_description', 'type' => 'textarea', 'rows' => 3 ),
				luxnova_acf_text( 'field_luxnova_phone', 'Phone', 'phone', '0968 888 168' ),
				luxnova_acf_text( 'field_luxnova_email', 'Email', 'email', 'hello@luxnova.vn' ),
				array( 'key' => 'field_luxnova_address', 'label' => 'Address', 'name' => 'address', 'type' => 'textarea', 'rows' => 2 ),
				array( 'key' => 'field_luxnova_map_image', 'label' => 'Map Image', 'name' => 'map_image', 'type' => 'image', 'return_format' => 'id' ),
				array( 'key' => 'field_luxnova_social_links', 'label' => 'Social Links', 'name' => 'social_links', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Add Social Link', 'sub_fields' => array( luxnova_acf_text( 'field_luxnova_social_platform', 'Platform', 'platform' ), array( 'key' => 'field_luxnova_social_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url' ) ) ),
				array( 'key' => 'field_luxnova_default_og_image', 'label' => 'Default OG Image', 'name' => 'default_og_image', 'type' => 'image', 'return_format' => 'id' ),
			),
			'location' => array(
				array(
					array( 'param' => 'options_page', 'operator' => '==', 'value' => 'luxnova-theme-settings' ),
				),
			),
		)
	);
}

function luxnova_acf_text( string $key, string $label, string $name, string $default = '' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'text',
		'default_value' => $default,
	);
}

function luxnova_acf_icon_select( string $key, string $label, string $name, string $default = 'home' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'select',
		'choices' => array(
			'chart' => 'Chart',
			'users' => 'Users',
			'shield' => 'Shield',
			'document' => 'Document',
			'home' => 'Home',
			'measure' => 'Measure',
			'design' => 'Design',
			'quote' => 'Quote',
			'tools' => 'Tools',
			'key' => 'Key',
		),
		'default_value' => $default,
		'return_format' => 'value',
	);
}

function luxnova_acf_homepage_layouts(): array {
	return array(
		'layout_luxnova_hero' => array(
			'key' => 'layout_luxnova_hero',
			'name' => 'hero',
			'label' => 'Hero',
			'display' => 'block',
			'sub_fields' => array(
				array( 'key' => 'field_luxnova_hero_title', 'label' => 'Title', 'name' => 'title', 'type' => 'textarea', 'rows' => 2 ),
				luxnova_acf_text( 'field_luxnova_hero_highlight', 'Highlight', 'highlight' ),
				array( 'key' => 'field_luxnova_hero_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_luxnova_hero_background', 'label' => 'Background Image', 'name' => 'background_image', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium' ),
				array( 'key' => 'field_luxnova_hero_primary_button', 'label' => 'Primary Button', 'name' => 'primary_button', 'type' => 'link', 'return_format' => 'array' ),
				array( 'key' => 'field_luxnova_hero_secondary_button', 'label' => 'Secondary Button', 'name' => 'secondary_button', 'type' => 'link', 'return_format' => 'array' ),
			),
		),
		'layout_luxnova_statistics' => array(
			'key' => 'layout_luxnova_statistics',
			'name' => 'statistics',
			'label' => 'Statistics',
			'display' => 'block',
			'sub_fields' => array(
				array( 'key' => 'field_luxnova_statistics_items', 'label' => 'Items', 'name' => 'items', 'type' => 'repeater', 'min' => 1, 'layout' => 'table', 'sub_fields' => array( luxnova_acf_icon_select( 'field_luxnova_stat_icon', 'Icon', 'icon', 'chart' ), luxnova_acf_text( 'field_luxnova_stat_number', 'Number', 'number' ), luxnova_acf_text( 'field_luxnova_stat_suffix', 'Suffix', 'suffix' ), luxnova_acf_text( 'field_luxnova_stat_label', 'Label', 'label' ) ) ),
			),
		),
		'layout_luxnova_services' => array(
			'key' => 'layout_luxnova_services',
			'name' => 'services',
			'label' => 'Services',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_text( 'field_luxnova_services_heading', 'Heading', 'heading' ),
				luxnova_acf_text( 'field_luxnova_services_subtitle', 'Subtitle', 'subtitle' ),
				array( 'key' => 'field_luxnova_services_archive_link', 'label' => 'Archive Link', 'name' => 'archive_link', 'type' => 'link', 'return_format' => 'array' ),
				array( 'key' => 'field_luxnova_services_items', 'label' => 'Items', 'name' => 'items', 'type' => 'repeater', 'layout' => 'block', 'sub_fields' => array( luxnova_acf_text( 'field_luxnova_service_title', 'Title', 'title' ), luxnova_acf_text( 'field_luxnova_service_tagline', 'Tagline', 'tagline' ), array( 'key' => 'field_luxnova_service_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'id' ), array( 'key' => 'field_luxnova_service_features', 'label' => 'Features', 'name' => 'features', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => array( luxnova_acf_text( 'field_luxnova_service_feature_text', 'Feature', 'text' ) ) ), array( 'key' => 'field_luxnova_service_link', 'label' => 'Link', 'name' => 'link', 'type' => 'link', 'return_format' => 'array' ) ) ),
			),
		),
		'layout_luxnova_projects' => array(
			'key' => 'layout_luxnova_projects',
			'name' => 'featured_projects',
			'label' => 'Featured Projects',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_text( 'field_luxnova_projects_heading', 'Heading', 'heading' ),
				array( 'key' => 'field_luxnova_projects_archive_link', 'label' => 'Archive Link', 'name' => 'archive_link', 'type' => 'link', 'return_format' => 'array' ),
				array( 'key' => 'field_luxnova_projects_items', 'label' => 'Projects', 'name' => 'items', 'type' => 'relationship', 'post_type' => array( 'luxnova_project' ), 'return_format' => 'id' ),
			),
		),
		'layout_luxnova_home_audit' => array(
			'key' => 'layout_luxnova_home_audit',
			'name' => 'home_audit_cta',
			'label' => 'Home Audit CTA',
			'display' => 'block',
			'sub_fields' => array(
				array( 'key' => 'field_luxnova_audit_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'id' ),
				luxnova_acf_text( 'field_luxnova_audit_label', 'Label', 'label' ),
				luxnova_acf_text( 'field_luxnova_audit_heading', 'Heading', 'heading' ),
				array( 'key' => 'field_luxnova_audit_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3 ),
				array( 'key' => 'field_luxnova_audit_benefits', 'label' => 'Benefits', 'name' => 'benefits', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => array( luxnova_acf_icon_select( 'field_luxnova_audit_benefit_icon', 'Icon', 'icon', 'document' ), luxnova_acf_text( 'field_luxnova_audit_benefit_label', 'Label', 'label' ) ) ),
				array( 'key' => 'field_luxnova_audit_button', 'label' => 'Button', 'name' => 'button', 'type' => 'link', 'return_format' => 'array' ),
			),
		),
		'layout_luxnova_process' => array(
			'key' => 'layout_luxnova_process',
			'name' => 'work_process',
			'label' => 'Work Process',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_text( 'field_luxnova_process_heading', 'Heading', 'heading' ),
				array( 'key' => 'field_luxnova_process_steps', 'label' => 'Steps', 'name' => 'steps', 'type' => 'repeater', 'layout' => 'block', 'sub_fields' => array( luxnova_acf_icon_select( 'field_luxnova_process_icon', 'Icon', 'icon', 'home' ), luxnova_acf_text( 'field_luxnova_process_number', 'Number', 'number' ), luxnova_acf_text( 'field_luxnova_process_title', 'Title', 'title' ), luxnova_acf_text( 'field_luxnova_process_description', 'Description', 'description' ) ) ),
			),
		),
		'layout_luxnova_testimonials' => array(
			'key' => 'layout_luxnova_testimonials',
			'name' => 'testimonials',
			'label' => 'Testimonials',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_text( 'field_luxnova_testimonials_heading', 'Heading', 'heading' ),
				array( 'key' => 'field_luxnova_testimonials_archive_link', 'label' => 'Archive Link', 'name' => 'archive_link', 'type' => 'link', 'return_format' => 'array' ),
				array( 'key' => 'field_luxnova_testimonials_items', 'label' => 'Testimonials', 'name' => 'items', 'type' => 'relationship', 'post_type' => array( 'luxnova_testimonial' ), 'return_format' => 'id' ),
			),
		),
		'layout_luxnova_partner_logos' => array(
			'key' => 'layout_luxnova_partner_logos',
			'name' => 'partner_logos',
			'label' => 'Partner Logos',
			'display' => 'block',
			'sub_fields' => array(
				array( 'key' => 'field_luxnova_partner_items', 'label' => 'Logos', 'name' => 'items', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => array( array( 'key' => 'field_luxnova_partner_logo', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'id' ), luxnova_acf_text( 'field_luxnova_partner_name', 'Name', 'name' ), array( 'key' => 'field_luxnova_partner_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url' ) ) ),
			),
		),
	);
}
