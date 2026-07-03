<?php
/**
 * Custom post types.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'luxnova_register_post_types' );
function luxnova_register_post_types(): void {
	register_post_type(
		'luxnova_project',
		array(
			'labels' => array(
				'name' => esc_html__( 'Projects', 'luxnova' ),
				'singular_name' => esc_html__( 'Project', 'luxnova' ),
			),
			'public' => true,
			'menu_icon' => 'dashicons-building',
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'du-an' ),
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
		)
	);

	register_post_type(
		'luxnova_service',
		array(
			'labels' => array(
				'name' => esc_html__( 'Services', 'luxnova' ),
				'singular_name' => esc_html__( 'Service', 'luxnova' ),
			),
			'public' => true,
			'menu_icon' => 'dashicons-admin-home',
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'dich-vu' ),
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
		)
	);

	register_post_type(
		'luxnova_testimonial',
		array(
			'labels' => array(
				'name' => esc_html__( 'Testimonials', 'luxnova' ),
				'singular_name' => esc_html__( 'Testimonial', 'luxnova' ),
			),
			'public' => true,
			'menu_icon' => 'dashicons-format-quote',
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'danh-gia' ),
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest' => true,
		)
	);
}
