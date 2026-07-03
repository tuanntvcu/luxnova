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

	register_taxonomy(
		'luxnova_project_type',
		array( 'luxnova_project' ),
		array(
			'labels' => array(
				'name' => esc_html__( 'Project Types', 'luxnova' ),
				'singular_name' => esc_html__( 'Project Type', 'luxnova' ),
			),
			'public' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'du-an/loai' ),
			'show_admin_column' => true,
			'show_in_rest' => true,
		)
	);
}

add_action( 'pre_get_posts', 'luxnova_project_archive_query' );
function luxnova_project_archive_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'luxnova_project' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 12 );

	$sort = sanitize_key( wp_unslash( $_GET['project_sort'] ?? 'newest' ) );
	if ( 'oldest' === $sort ) {
		$query->set( 'order', 'ASC' );
	} elseif ( 'title' === $sort ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
	} else {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
	}

	$type = sanitize_title( wp_unslash( $_GET['project_type'] ?? '' ) );
	if ( '' !== $type ) {
		$query->set(
			'tax_query',
			array(
				array(
					'taxonomy' => 'luxnova_project_type',
					'field' => 'slug',
					'terms' => $type,
				),
			)
		);
	}
}
