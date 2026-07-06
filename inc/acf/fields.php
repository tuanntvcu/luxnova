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
			'key' => 'group_luxnova_service_details',
			'title' => 'Service Details',
			'fields' => array(
				luxnova_acf_icon_select( 'field_luxnova_service_archive_icon', 'Archive Icon', 'icon', 'design' ),
				luxnova_acf_icon_image( 'field_luxnova_service_archive_icon_image' ),
			),
			'location' => array(
				array(
					array( 'param' => 'post_type', 'operator' => '==', 'value' => 'luxnova_service' ),
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
				array(
					'key' => 'field_luxnova_archive_modal_content_tab',
					'label' => 'Archive & Modal Content',
					'name' => '',
					'type' => 'tab',
					'placement' => 'top',
				),
				luxnova_acf_group( 'field_luxnova_service_archive_content', 'Service Archive Content', 'service_archive_content', luxnova_acf_service_archive_fields() ),
				luxnova_acf_group( 'field_luxnova_project_archive_content', 'Project Archive Content', 'project_archive_content', luxnova_acf_project_archive_fields() ),
				luxnova_acf_group( 'field_luxnova_consultation_modal_content', 'Consultation Modal Content', 'consultation_modal_content', luxnova_acf_consultation_modal_fields() ),
			),
			'location' => array(
				array(
					array( 'param' => 'options_page', 'operator' => '==', 'value' => 'luxnova-theme-settings' ),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_contact_page_content',
			'title' => 'Contact Page Content',
			'fields' => luxnova_acf_contact_page_fields(),
			'location' => array(
				array(
					array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-lien-he.php' ),
				),
				array(
					array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_faq_page_content',
			'title' => 'FAQ Page Content',
			'fields' => luxnova_acf_faq_page_fields(),
			'location' => array(
				array(
					array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-faq.php' ),
				),
				array(
					array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-cau-hoi-thuong-gap.php' ),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_pricing_page_content',
			'title' => 'Pricing Page Content',
			'fields' => luxnova_acf_pricing_page_fields(),
			'location' => array(
				array(
					array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-pricing.php' ),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key' => 'group_luxnova_single_project_content',
			'title' => 'Single Project Fallback Content',
			'fields' => luxnova_acf_single_project_fields(),
			'location' => array(
				array(
					array( 'param' => 'post_type', 'operator' => '==', 'value' => 'luxnova_project' ),
				),
			),
		)
	);
}

function luxnova_acf_text( string $key, string $label, string $name, string $default = '', string $instructions = '' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'text',
		'default_value' => $default,
		'instructions' => $instructions ?: ( '' !== $default ? luxnova_acf_default_instruction( $default ) : '' ),
		'placeholder' => $default,
	);
}

function luxnova_acf_icon_select( string $key, string $label, string $name, string $default = 'home', string $instructions = '' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'select',
		'instructions' => $instructions ?: luxnova_acf_default_instruction( $default ),
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
			'clock' => 'Clock',
			'phone' => 'Phone',
			'mail' => 'Mail',
			'pin' => 'Pin',
			'facebook' => 'Facebook',
		),
		'default_value' => $default,
		'return_format' => 'value',
	);
}

function luxnova_acf_default_instruction( mixed $default ): string {
	if ( is_array( $default ) ) {
		$default = implode( ', ', array_filter( array_map( 'strval', $default ) ) );
	}

	$default = trim( (string) $default );

	return '' === $default
		? 'Nếu bỏ trống, website sẽ dùng fallback mặc định trong theme.'
		: sprintf( 'Nếu bỏ trống, website sẽ dùng mặc định: %s', $default );
}

function luxnova_acf_dynamic_text( string $key, string $label, string $name, string $default = '' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'text',
		'instructions' => luxnova_acf_default_instruction( $default ),
		'placeholder' => $default,
	);
}

function luxnova_acf_dynamic_textarea( string $key, string $label, string $name, string $default = '', int $rows = 3 ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'textarea',
		'rows' => $rows,
		'instructions' => luxnova_acf_default_instruction( $default ),
		'placeholder' => $default,
	);
}

function luxnova_acf_dynamic_image( string $key, string $label, string $name, string $fallback = '' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'image',
		'return_format' => 'id',
		'preview_size' => 'medium',
		'instructions' => luxnova_acf_default_instruction( $fallback ?: 'ảnh fallback của theme' ),
	);
}

function luxnova_acf_icon_image( string $key, string $label = 'Icon Image', string $name = 'icon_image' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'image',
		'return_format' => 'id',
		'preview_size' => 'thumbnail',
		'instructions' => 'Nếu upload ảnh, website sẽ ưu tiên ảnh này thay cho Icon. Để trống sẽ dùng Icon đã chọn.',
	);
}

function luxnova_acf_group( string $key, string $label, string $name, array $sub_fields, string $instructions = '' ): array {
	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'group',
		'layout' => 'block',
		'instructions' => $instructions,
		'sub_fields' => $sub_fields,
	);
}

function luxnova_acf_dynamic_repeater( string $key, string $label, string $name, array $sub_fields, array $default_items = array(), string $layout = 'block' ): array {
	$summary = array();
	foreach ( $default_items as $item ) {
		if ( ! empty( $item['title'] ) ) {
			$summary[] = $item['title'];
		} elseif ( ! empty( $item['label'] ) ) {
			$summary[] = $item['label'];
		} elseif ( ! empty( $item['question'] ) ) {
			$summary[] = $item['question'];
		}
	}

	return array(
		'key' => $key,
		'label' => $label,
		'name' => $name,
		'type' => 'repeater',
		'layout' => $layout,
		'button_label' => 'Add item',
		'instructions' => empty( $summary )
			? 'Nếu không thêm item nào, website sẽ dùng danh sách mặc định trong theme.'
			: luxnova_acf_default_instruction( $summary ),
		'sub_fields' => $sub_fields,
	);
}

function luxnova_acf_hero_fields( string $prefix, array $defaults, bool $has_suffix = false, bool $has_actions = false ): array {
	$fields = array(
		luxnova_acf_dynamic_text( "{$prefix}_eyebrow", 'Eyebrow', 'eyebrow', $defaults['eyebrow'] ?? '' ),
		luxnova_acf_dynamic_textarea( "{$prefix}_title", 'Title', 'title', $defaults['title'] ?? '', 2 ),
	);

	if ( array_key_exists( 'highlight', $defaults ) ) {
		$fields[] = luxnova_acf_dynamic_text( "{$prefix}_highlight", 'Highlight', 'highlight', $defaults['highlight'] ?? '' );
	}

	if ( $has_suffix || array_key_exists( 'title_suffix', $defaults ) ) {
		$fields[] = luxnova_acf_dynamic_text( "{$prefix}_title_suffix", 'Title Suffix', 'title_suffix', $defaults['title_suffix'] ?? '' );
	}

	$fields[] = luxnova_acf_dynamic_textarea( "{$prefix}_description", 'Description', 'description', $defaults['description'] ?? '', 3 );
	$fields[] = luxnova_acf_dynamic_image( "{$prefix}_image", 'Image', 'image', $defaults['image_fallback'] ?? '' );

	if ( $has_actions ) {
		$fields[] = luxnova_acf_dynamic_text( "{$prefix}_primary_label", 'Primary Button Label', 'primary_label', $defaults['primary_label'] ?? '' );
		$fields[] = luxnova_acf_dynamic_text( "{$prefix}_secondary_label", 'Secondary Button Label', 'secondary_label', $defaults['secondary_label'] ?? '' );
	}

	return $fields;
}

function luxnova_acf_cta_fields( string $prefix, array $defaults, bool $has_eyebrow = false ): array {
	$fields = array(
		luxnova_acf_dynamic_image( "{$prefix}_image", 'Image', 'image', $defaults['image_fallback'] ?? '' ),
	);

	if ( $has_eyebrow || array_key_exists( 'eyebrow', $defaults ) ) {
		$fields[] = luxnova_acf_dynamic_text( "{$prefix}_eyebrow", 'Eyebrow', 'eyebrow', $defaults['eyebrow'] ?? '' );
	}

	$fields[] = luxnova_acf_dynamic_textarea( "{$prefix}_title", 'Title', 'title', $defaults['title'] ?? '', 2 );

	if ( array_key_exists( 'description', $defaults ) ) {
		$fields[] = luxnova_acf_dynamic_textarea( "{$prefix}_description", 'Description', 'description', $defaults['description'] ?? '', 3 );
	}

	$fields[] = luxnova_acf_dynamic_text( "{$prefix}_button_label", 'Button Label', 'button_label', $defaults['button_label'] ?? '' );

	return $fields;
}

function luxnova_acf_contact_page_fields(): array {
	$defaults = luxnova_contact_page_data();

	return array(
		luxnova_acf_group(
			'field_luxnova_contact_page_content',
			'Contact Page Content',
			'contact_page_content',
			array(
				luxnova_acf_group( 'field_luxnova_contact_hero', 'Hero', 'hero', luxnova_acf_hero_fields( 'field_luxnova_contact_hero', $defaults['hero'] ?? array(), true ) ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_contact_trust_items',
					'Hero Trust Items',
					'trust_items',
					array(
						luxnova_acf_icon_select( 'field_luxnova_contact_trust_icon', 'Icon', 'icon', 'clock', luxnova_acf_default_instruction( 'clock' ) ),
						luxnova_acf_icon_image( 'field_luxnova_contact_trust_icon_image' ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_contact_trust_label', 'Label', 'label', '', 2 ),
					),
					$defaults['trust_items'] ?? array(),
					'table'
				),
				luxnova_acf_dynamic_text( 'field_luxnova_contact_form_heading', 'Form Heading', 'form_heading', $defaults['form_heading'] ?? '' ),
				luxnova_acf_dynamic_text( 'field_luxnova_contact_info_heading', 'Info Heading', 'info_heading', $defaults['info_heading'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_contact_items',
					'Contact Items',
					'contact_items',
					array(
						luxnova_acf_icon_select( 'field_luxnova_contact_item_icon', 'Icon', 'icon', 'pin', luxnova_acf_default_instruction( 'pin' ) ),
						luxnova_acf_icon_image( 'field_luxnova_contact_item_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_contact_item_title', 'Title', 'title' ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_contact_item_content', 'Content', 'content', '', 2 ),
						array( 'key' => 'field_luxnova_contact_item_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url', 'instructions' => 'Nếu bỏ trống, item sẽ hiển thị như text thường.' ),
					),
					$defaults['contact_items'] ?? array()
				),
				luxnova_acf_group(
					'field_luxnova_contact_map',
					'Map Block',
					'map',
					array(
						luxnova_acf_dynamic_image( 'field_luxnova_contact_map_image', 'Map Image', 'image', 'assets/images/placeholder-map.svg' ),
						luxnova_acf_dynamic_text( 'field_luxnova_contact_map_label', 'Label', 'label', $defaults['map']['label'] ?? '' ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_contact_map_description', 'Description', 'description', $defaults['map']['description'] ?? '', 3 ),
						luxnova_acf_dynamic_text( 'field_luxnova_contact_map_button_label', 'Button Label', 'button_label', $defaults['map']['button_label'] ?? '' ),
					)
				),
				luxnova_acf_group( 'field_luxnova_contact_closing_cta', 'Closing CTA', 'closing_cta', luxnova_acf_cta_fields( 'field_luxnova_contact_closing_cta', $defaults['closing_cta'] ?? array(), true ) ),
			)
		),
	);
}

function luxnova_acf_faq_page_fields(): array {
	$defaults = luxnova_faq_page_data();

	return array(
		luxnova_acf_group(
			'field_luxnova_faq_page_content',
			'FAQ Page Content',
			'faq_page_content',
			array(
				luxnova_acf_group( 'field_luxnova_faq_hero', 'Hero', 'hero', luxnova_acf_hero_fields( 'field_luxnova_faq_hero', $defaults['hero'] ?? array() ) ),
				luxnova_acf_group(
					'field_luxnova_faq_sidebar',
					'Sidebar',
					'sidebar',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_faq_sidebar_heading', 'Heading', 'heading', $defaults['sidebar']['heading'] ?? '' ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_faq_sidebar_description', 'Description', 'description', $defaults['sidebar']['description'] ?? '', 3 ),
						luxnova_acf_dynamic_text( 'field_luxnova_faq_sidebar_button_label', 'Button Label', 'button_label', $defaults['sidebar']['button_label'] ?? '' ),
						luxnova_acf_icon_select( 'field_luxnova_faq_sidebar_button_icon', 'Button Icon', 'button_icon', $defaults['sidebar']['button_icon'] ?? 'mail', luxnova_acf_default_instruction( $defaults['sidebar']['button_icon'] ?? 'mail' ) ),
						luxnova_acf_icon_image( 'field_luxnova_faq_sidebar_button_icon_image', 'Button Icon Image', 'button_icon_image' ),
						array( 'key' => 'field_luxnova_faq_sidebar_button_url', 'label' => 'Button URL', 'name' => 'button_url', 'type' => 'url', 'instructions' => luxnova_acf_default_instruction( $defaults['sidebar']['button_url'] ?? home_url( '/lien-he/' ) ), 'placeholder' => $defaults['sidebar']['button_url'] ?? home_url( '/lien-he/' ) ),
					)
				),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_faq_items',
					'FAQ Items',
					'items',
					array(
						luxnova_acf_dynamic_textarea( 'field_luxnova_faq_item_question', 'Question', 'question', '', 2 ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_faq_item_answer', 'Answer', 'answer', '', 4 ),
					),
					$defaults['items'] ?? array()
				),
				luxnova_acf_group( 'field_luxnova_faq_closing_cta', 'Closing CTA', 'closing_cta', luxnova_acf_cta_fields( 'field_luxnova_faq_closing_cta', $defaults['closing_cta'] ?? array(), true ) ),
			)
		),
	);
}

function luxnova_acf_pricing_page_fields(): array {
	$defaults = luxnova_pricing_page_data();

	return array(
		luxnova_acf_group(
			'field_luxnova_pricing_page_content',
			'Pricing Page Content',
			'pricing_page_content',
			array(
				luxnova_acf_group( 'field_luxnova_pricing_hero', 'Hero', 'hero', luxnova_acf_hero_fields( 'field_luxnova_pricing_hero', $defaults['hero'] ?? array() ) ),
				luxnova_acf_dynamic_text( 'field_luxnova_pricing_plans_heading', 'Plans Heading', 'plans_heading', $defaults['plans_heading'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_pricing_plans',
					'Pricing Plans',
					'pricing_plans',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_label', 'Label', 'label' ),
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_title', 'Title', 'title' ),
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_price', 'Price', 'price' ),
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_unit', 'Unit', 'unit' ),
						luxnova_acf_dynamic_repeater(
							'field_luxnova_pricing_plan_features',
							'Features',
							'features',
							array(
								luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_feature_text', 'Feature', 'text' ),
							),
							array(),
							'table'
						),
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_button_label', 'Button Label', 'button_label' ),
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_plan_ribbon', 'Ribbon', 'ribbon' ),
						array(
							'key' => 'field_luxnova_pricing_plan_featured',
							'label' => 'Featured Plan',
							'name' => 'featured',
							'type' => 'true_false',
							'ui' => 1,
							'instructions' => 'Bật nếu muốn gói này dùng style nổi bật.',
						),
					),
					luxnova_default_pricing_plans()
				),
				luxnova_acf_dynamic_textarea( 'field_luxnova_pricing_plans_note', 'Plans Note', 'plans_note', $defaults['plans_note'] ?? '', 2 ),
				luxnova_acf_dynamic_text( 'field_luxnova_pricing_factors_heading', 'Factors Heading', 'factors_heading', $defaults['factors_heading'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_pricing_cost_factors',
					'Cost Factors',
					'pricing_cost_factors',
					array(
						luxnova_acf_icon_select( 'field_luxnova_pricing_cost_factor_icon', 'Icon', 'icon', 'measure', luxnova_acf_default_instruction( 'measure' ) ),
						luxnova_acf_icon_image( 'field_luxnova_pricing_cost_factor_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_pricing_cost_factor_title', 'Title', 'title' ),
					),
					luxnova_default_cost_factors(),
					'table'
				),
				luxnova_acf_dynamic_text( 'field_luxnova_pricing_faq_heading', 'FAQ Heading', 'faq_heading', $defaults['faq_heading'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_pricing_faqs',
					'Pricing FAQs',
					'pricing_faqs',
					array(
						luxnova_acf_dynamic_textarea( 'field_luxnova_pricing_faq_question', 'Question', 'question', '', 2 ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_pricing_faq_answer', 'Answer', 'answer', '', 4 ),
					),
					luxnova_default_pricing_faqs()
				),
				luxnova_acf_dynamic_image( 'field_luxnova_pricing_faq_image', 'FAQ Image', 'faq_image', $defaults['faq_image_fallback'] ?? '' ),
				luxnova_acf_group( 'field_luxnova_pricing_closing_cta', 'Closing CTA', 'closing_cta', luxnova_acf_cta_fields( 'field_luxnova_pricing_closing_cta', $defaults['closing_cta'] ?? array() ) ),
			)
		),
	);
}

function luxnova_acf_service_archive_fields(): array {
	$defaults = luxnova_service_archive_data();

	return array(
		luxnova_acf_group( 'field_luxnova_service_archive_hero', 'Hero', 'hero', luxnova_acf_hero_fields( 'field_luxnova_service_archive_hero', $defaults['hero'] ?? array(), false, true ) ),
		luxnova_acf_dynamic_text( 'field_luxnova_service_archive_services_heading', 'Services Heading', 'services_heading', $defaults['services_heading'] ?? '' ),
		luxnova_acf_dynamic_text( 'field_luxnova_service_archive_card_link_label', 'Card Link Label', 'card_link_label', $defaults['card_link_label'] ?? '' ),
		luxnova_acf_dynamic_text( 'field_luxnova_service_archive_process_heading', 'Process Heading', 'process_heading', $defaults['process_heading'] ?? '' ),
		luxnova_acf_dynamic_text( 'field_luxnova_service_archive_why_heading', 'Why Heading', 'why_heading', $defaults['why_heading'] ?? '' ),
		luxnova_acf_group( 'field_luxnova_service_archive_closing_cta', 'Closing CTA', 'closing_cta', luxnova_acf_cta_fields( 'field_luxnova_service_archive_closing_cta', $defaults['closing_cta'] ?? array() ) ),
	);
}

function luxnova_acf_project_archive_fields(): array {
	$defaults = luxnova_project_archive_data();

	return array(
		luxnova_acf_group( 'field_luxnova_project_archive_hero', 'Hero', 'hero', luxnova_acf_hero_fields( 'field_luxnova_project_archive_hero', $defaults['hero'] ?? array() ) ),
		luxnova_acf_group( 'field_luxnova_project_archive_closing_cta', 'Closing CTA', 'closing_cta', luxnova_acf_cta_fields( 'field_luxnova_project_archive_closing_cta', $defaults['closing_cta'] ?? array() ) ),
	);
}

function luxnova_acf_consultation_modal_fields(): array {
	$defaults = luxnova_consultation_modal_data();

	return array(
		luxnova_acf_dynamic_text( 'field_luxnova_consultation_modal_eyebrow', 'Eyebrow', 'eyebrow', $defaults['eyebrow'] ?? '' ),
		luxnova_acf_dynamic_textarea( 'field_luxnova_consultation_modal_title', 'Title', 'title', $defaults['title'] ?? '', 2 ),
		luxnova_acf_dynamic_textarea( 'field_luxnova_consultation_modal_intro', 'Intro', 'intro', $defaults['intro'] ?? '', 3 ),
		luxnova_acf_dynamic_image( 'field_luxnova_consultation_modal_image', 'Image', 'image', $defaults['image_fallback'] ?? '' ),
		luxnova_acf_dynamic_repeater(
			'field_luxnova_consultation_modal_benefits',
			'Benefits',
			'benefits',
			array(
				luxnova_acf_icon_select( 'field_luxnova_consultation_modal_benefit_icon', 'Icon', 'icon', 'clock', luxnova_acf_default_instruction( 'clock' ) ),
				luxnova_acf_icon_image( 'field_luxnova_consultation_modal_benefit_icon_image' ),
				luxnova_acf_dynamic_text( 'field_luxnova_consultation_modal_benefit_title', 'Title', 'title' ),
				luxnova_acf_dynamic_textarea( 'field_luxnova_consultation_modal_benefit_description', 'Description', 'description', '', 2 ),
			),
			$defaults['benefits'] ?? array(),
			'table'
		),
	);
}

function luxnova_acf_single_project_fields(): array {
	$defaults = luxnova_single_project_page_data();

	return array(
		luxnova_acf_group(
			'field_luxnova_single_project_content',
			'Single Project Fallback Content',
			'single_project_content',
			array(
				luxnova_acf_group(
					'field_luxnova_single_project_breadcrumb',
					'Breadcrumb Labels',
					'breadcrumb',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_breadcrumb_home', 'Home Label', 'home_label', $defaults['breadcrumb']['home_label'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_breadcrumb_archive', 'Archive Label', 'archive_label', $defaults['breadcrumb']['archive_label'] ?? '' ),
					)
				),
				luxnova_acf_dynamic_textarea( 'field_luxnova_single_project_summary_fallback', 'Summary Fallback', 'summary_fallback', $defaults['summary_fallback'] ?? '', 3 ),
				luxnova_acf_group(
					'field_luxnova_single_project_meta_labels',
					'Hero Meta Labels',
					'meta_labels',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_meta_location', 'Location Label', 'location', $defaults['meta_labels']['location'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_meta_area', 'Area Label', 'area', $defaults['meta_labels']['area'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_meta_style', 'Style Label', 'style', $defaults['meta_labels']['style'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_meta_year', 'Year Label', 'year', $defaults['meta_labels']['year'] ?? '' ),
					)
				),
				luxnova_acf_group(
					'field_luxnova_single_project_actions',
					'Action Labels',
					'actions',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_action_consultation', 'Consultation Label', 'consultation_label', $defaults['actions']['consultation_label'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_action_brochure', 'Brochure Label', 'brochure_label', $defaults['actions']['brochure_label'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_action_gallery', 'Gallery Label', 'gallery_label', $defaults['actions']['gallery_label'] ?? '' ),
					)
				),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_story_heading', 'Story Heading', 'story_heading', $defaults['story_heading'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_single_project_story_fallback',
					'Story Fallback Paragraphs',
					'story_fallback',
					array(
						luxnova_acf_dynamic_textarea( 'field_luxnova_single_project_story_paragraph', 'Paragraph', 'paragraph', '', 3 ),
					),
					array_map(
						static fn( string $paragraph ): array => array( 'label' => $paragraph ),
						(array) ( $defaults['story_fallback'] ?? array() )
					)
				),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_single_project_features',
					'Feature Cards',
					'features',
					array(
						luxnova_acf_icon_select( 'field_luxnova_single_project_feature_icon', 'Icon', 'icon', 'home', luxnova_acf_default_instruction( 'home' ) ),
						luxnova_acf_icon_image( 'field_luxnova_single_project_feature_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_feature_title', 'Title', 'title' ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_single_project_feature_description', 'Description', 'description', '', 2 ),
					),
					$defaults['features'] ?? array()
				),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_heading', 'Info Heading', 'info_heading', $defaults['info_heading'] ?? '' ),
				luxnova_acf_group(
					'field_luxnova_single_project_info_labels',
					'Info Labels',
					'info_labels',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_type', 'Type Label', 'type', $defaults['info_labels']['type'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_location', 'Location Label', 'location', $defaults['info_labels']['location'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_area', 'Area Label', 'area', $defaults['info_labels']['area'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_style', 'Style Label', 'style', $defaults['info_labels']['style'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_year', 'Year Label', 'year', $defaults['info_labels']['year'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_scope', 'Scope Label', 'scope', $defaults['info_labels']['scope'] ?? '' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_info_architect', 'Architect Label', 'architect', $defaults['info_labels']['architect'] ?? '' ),
					)
				),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_gallery_heading', 'Gallery Heading', 'gallery_heading', $defaults['gallery_heading'] ?? '' ),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_gallery_more_label', 'Gallery More Label', 'gallery_more_label', $defaults['gallery_more_label'] ?? '' ),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_benefits_label', 'Benefits Aria Label', 'benefits_label', $defaults['benefits_label'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_single_project_benefits',
					'Benefits',
					'benefits',
					array(
						luxnova_acf_icon_select( 'field_luxnova_single_project_benefit_icon', 'Icon', 'icon', 'users', luxnova_acf_default_instruction( 'users' ) ),
						luxnova_acf_icon_image( 'field_luxnova_single_project_benefit_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_single_project_benefit_title', 'Title', 'title' ),
						luxnova_acf_dynamic_textarea( 'field_luxnova_single_project_benefit_description', 'Description', 'description', '', 2 ),
					),
					$defaults['benefits'] ?? array(),
					'table'
				),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_related_heading', 'Related Heading', 'related_heading', $defaults['related_heading'] ?? '' ),
				luxnova_acf_dynamic_text( 'field_luxnova_single_project_related_link_label', 'Related Link Label', 'related_link_label', $defaults['related_link_label'] ?? '' ),
				luxnova_acf_group( 'field_luxnova_single_project_closing_cta', 'Closing CTA', 'closing_cta', luxnova_acf_cta_fields( 'field_luxnova_single_project_closing_cta', $defaults['closing_cta'] ?? array() ) ),
			)
		),
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
				array( 'key' => 'field_luxnova_statistics_items', 'label' => 'Items', 'name' => 'items', 'type' => 'repeater', 'min' => 1, 'layout' => 'table', 'sub_fields' => array( luxnova_acf_icon_select( 'field_luxnova_stat_icon', 'Icon', 'icon', 'chart' ), luxnova_acf_icon_image( 'field_luxnova_stat_icon_image' ), luxnova_acf_text( 'field_luxnova_stat_number', 'Number', 'number' ), luxnova_acf_text( 'field_luxnova_stat_suffix', 'Suffix', 'suffix' ), luxnova_acf_text( 'field_luxnova_stat_label', 'Label', 'label' ) ) ),
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
				array( 'key' => 'field_luxnova_audit_benefits', 'label' => 'Benefits', 'name' => 'benefits', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => array( luxnova_acf_icon_select( 'field_luxnova_audit_benefit_icon', 'Icon', 'icon', 'document' ), luxnova_acf_icon_image( 'field_luxnova_audit_benefit_icon_image' ), luxnova_acf_text( 'field_luxnova_audit_benefit_label', 'Label', 'label' ) ) ),
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
				array( 'key' => 'field_luxnova_process_steps', 'label' => 'Steps', 'name' => 'steps', 'type' => 'repeater', 'layout' => 'block', 'sub_fields' => array( luxnova_acf_icon_select( 'field_luxnova_process_icon', 'Icon', 'icon', 'home' ), luxnova_acf_icon_image( 'field_luxnova_process_icon_image' ), luxnova_acf_text( 'field_luxnova_process_number', 'Number', 'number' ), luxnova_acf_text( 'field_luxnova_process_title', 'Title', 'title' ), luxnova_acf_text( 'field_luxnova_process_description', 'Description', 'description' ) ) ),
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
