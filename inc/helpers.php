<?php
/**
 * Template helpers and default content.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function luxnova_asset( string $path ): string {
	return LUXNOVA_URI . ltrim( $path, '/' );
}

function luxnova_get_option( string $key, mixed $default = '' ): mixed {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, 'option' );
		if ( null !== $value && false !== $value && '' !== $value ) {
			return $value;
		}
	}

	return $default;
}

function luxnova_image_url( mixed $image, string $size = 'large', string $fallback = 'assets/images/placeholder-interior.svg' ): string {
	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, $size );
		return $url ? $url : luxnova_asset( $fallback );
	}

	if ( is_array( $image ) ) {
		if ( ! empty( $image['ID'] ) ) {
			$url = wp_get_attachment_image_url( (int) $image['ID'], $size );
			return $url ? $url : luxnova_asset( $fallback );
		}

		if ( ! empty( $image['url'] ) ) {
			return esc_url_raw( $image['url'] );
		}
	}

	if ( is_string( $image ) && '' !== $image ) {
		return esc_url_raw( $image );
	}

	return luxnova_asset( $fallback );
}

function luxnova_image( mixed $image, string $size, array $attrs = array(), string $fallback = 'assets/images/placeholder-interior.svg' ): string {
	$attrs = wp_parse_args(
		$attrs,
		array(
			'alt' => '',
			'loading' => 'lazy',
			'decoding' => 'async',
		)
	);

	if ( is_numeric( $image ) ) {
		return wp_get_attachment_image( (int) $image, $size, false, $attrs );
	}

	if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
		return wp_get_attachment_image( (int) $image['ID'], $size, false, $attrs );
	}

	$attr_html = '';
	foreach ( $attrs as $name => $value ) {
		if ( false === $value || null === $value ) {
			continue;
		}
		$attr_html .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( (string) $value ) );
	}

	return sprintf( '<img src="%s"%s>', esc_url( luxnova_image_url( $image, $size, $fallback ) ), $attr_html );
}

function luxnova_link( mixed $link, string $class = '', string $fallback_title = '' ): string {
	if ( ! is_array( $link ) ) {
		return '';
	}

	$url    = $link['url'] ?? '';
	$title  = $link['title'] ?? $fallback_title;
	$target = $link['target'] ?? '';

	if ( '' === $url || '' === $title ) {
		return '';
	}

	$target_attr = $target ? sprintf( ' target="%s"', esc_attr( $target ) ) : '';
	$rel         = '_blank' === $target ? ' rel="noopener noreferrer"' : '';

	return sprintf(
		'<a class="%1$s" href="%2$s"%3$s%4$s>%5$s <span aria-hidden="true">→</span></a>',
		esc_attr( $class ),
		esc_url( $url ),
		$target_attr,
		$rel,
		esc_html( $title )
	);
}

function luxnova_icon( string $name ): string {
	$icons = array(
		'chart' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M7 16V8m5 8V5m5 11v-6"/></svg>',
		'users' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 19c0-2.2-1.8-4-4-4s-4 1.8-4 4M12 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6 7c0-1.6-.9-3-2.2-3.7M18 10.5a2.5 2.5 0 0 0-1.6-4.7M6 18c0-1.6.9-3 2.2-3.7M6 10.5a2.5 2.5 0 0 1 1.6-4.7"/></svg>',
		'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 19 6v5c0 4.6-2.9 8.4-7 10-4.1-1.6-7-5.4-7-10V6l7-3Zm-3 9 2 2 4-5"/></svg>',
		'document' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h7l4 4v14H7V3Zm7 0v5h4M9 12h6M9 16h6"/></svg>',
		'home' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 11 8-7 8 7v9H6v-9Zm5 9v-6h6v6"/></svg>',
		'measure' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 17 17 4l3 3L7 20H4v-3Zm11-11 3 3M7 14l3 3"/></svg>',
		'design' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20h16M7 16l7-11 3 7-10 4Zm7-11 6 6"/></svg>',
		'quote' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17h4V9H6v5h2c0 1.7-.7 2.7-2 3m10 0h4V9h-5v5h2c0 1.7-.7 2.7-2 3"/></svg>',
		'tools' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m14 7 3-3 3 3-3 3M4 20l8-8M7 4l13 13-3 3L4 7V4h3Z"/></svg>',
		'key' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 10a5 5 0 1 1-2.2-4.1L21 15v3h-3v3h-3l-5.1-5.1A5 5 0 0 1 14 10ZM7 10h.01"/></svg>',
		'clock' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7v5l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>',
		'phone' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 4h4l1 5-2.5 1.5a12 12 0 0 0 5 5L15 13l5 1v4c0 1.1-.9 2-2 2A14 14 0 0 1 4 6c0-1.1.9-2 2-2Z"/></svg>',
		'mail' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v12H4V6Zm0 0 8 7 8-7"/></svg>',
		'pin' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Zm0-8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>',
		'facebook' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 8h2V4h-2c-3 0-5 2-5 5v2H7v4h3v5h4v-5h3l1-4h-4V9c0-.6.4-1 1-1Z"/></svg>',
		'menu' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>',
	);

	return $icons[ $name ] ?? $icons['home'];
}

function luxnova_default_homepage_sections(): array {
	return array(
		array(
			'layout' => 'hero',
			'title' => 'Thiết kế & Thi công nội thất cao cấp',
			'highlight' => 'Đẹp • Đúng ngân sách • Đúng tiến độ',
			'description' => 'LuxNova mang đến không gian sống tinh tế, tối ưu công năng và thể hiện phong cách riêng của bạn.',
			'background_image' => luxnova_asset( 'assets/images/placeholder-hero.svg' ),
			'primary_button' => array( 'url' => '#lien-he', 'title' => 'Đặt lịch tư vấn', 'target' => '' ),
			'secondary_button' => array( 'url' => '#du-an', 'title' => 'Xem dự án', 'target' => '' ),
		),
		array(
			'layout' => 'statistics',
			'items' => array(
				array( 'icon' => 'chart', 'number' => '150', 'suffix' => '+', 'label' => 'Dự án hoàn thành' ),
				array( 'icon' => 'users', 'number' => '98', 'suffix' => '%', 'label' => 'Khách hàng hài lòng' ),
				array( 'icon' => 'shield', 'number' => '5', 'suffix' => ' năm', 'label' => 'Bảo hành' ),
				array( 'icon' => 'document', 'number' => '100', 'suffix' => '%', 'label' => 'Báo giá minh bạch' ),
			),
		),
		array(
			'layout' => 'services',
			'heading' => 'Giải pháp nội thất toàn diện',
			'subtitle' => 'Từ căn hộ đến biệt thự, từ ý tưởng đến hiện thực',
			'archive_link' => array( 'url' => get_post_type_archive_link( 'luxnova_service' ) ?: '#', 'title' => 'Xem tất cả dịch vụ', 'target' => '' ),
			'items' => array(
				array(
					'title' => 'Essential™',
					'tagline' => 'Tối ưu công năng - Chi phí hợp lý',
					'image' => luxnova_asset( 'assets/images/placeholder-service-1.svg' ),
					'features' => array( 'Phù hợp căn hộ 1 - 2PN', 'Thiết kế hiện đại', 'Thi công trọn gói', 'Bảo hành 2 năm' ),
					'link' => array( 'url' => '#', 'title' => 'Tìm hiểu thêm', 'target' => '' ),
				),
				array(
					'title' => 'Signature™',
					'tagline' => 'Cá nhân hóa - Đẳng cấp',
					'image' => luxnova_asset( 'assets/images/placeholder-service-2.svg' ),
					'features' => array( 'Phù hợp căn hộ 2 - 3PN', 'Thiết kế cá nhân hóa', 'Vật liệu cao cấp', 'Bảo hành 5 năm' ),
					'link' => array( 'url' => '#', 'title' => 'Tìm hiểu thêm', 'target' => '' ),
				),
				array(
					'title' => 'Prestige™',
					'tagline' => 'Độc bản - Tinh tế - Khác biệt',
					'image' => luxnova_asset( 'assets/images/placeholder-service-3.svg' ),
					'features' => array( 'Biệt thự, nhà phố, Penthouse', 'Thiết kế độc bản', 'Vật liệu hạng sang', 'Bảo hành 5 năm' ),
					'link' => array( 'url' => '#', 'title' => 'Tìm hiểu thêm', 'target' => '' ),
				),
			),
		),
		array(
			'layout' => 'featured_projects',
			'heading' => 'Dự án tiêu biểu',
			'archive_link' => array( 'url' => get_post_type_archive_link( 'luxnova_project' ) ?: '#', 'title' => 'Xem tất cả dự án', 'target' => '' ),
			'items' => luxnova_default_project_cards(),
		),
		array(
			'layout' => 'home_audit_cta',
			'image' => luxnova_asset( 'assets/images/placeholder-audit.svg' ),
			'label' => 'LuxNova Home Audit™',
			'heading' => 'Chưa biết bắt đầu từ đâu?',
			'description' => 'Đăng ký ngay để nhận tư vấn miễn phí và bộ tài liệu hữu ích.',
			'benefits' => array(
				array( 'icon' => 'document', 'label' => 'Phân tích nhu cầu' ),
				array( 'icon' => 'chart', 'label' => 'Dự toán ngân sách' ),
				array( 'icon' => 'design', 'label' => 'Gợi ý phong cách' ),
				array( 'icon' => 'tools', 'label' => 'Kế hoạch triển khai' ),
			),
			'button' => array( 'url' => '#lien-he', 'title' => 'Đăng ký ngay', 'target' => '' ),
		),
		array(
			'layout' => 'work_process',
			'heading' => 'Quy trình làm việc',
			'steps' => array(
				array( 'icon' => 'measure', 'number' => '01', 'title' => 'Đăng ký', 'description' => 'Tiếp nhận thông tin và nhu cầu của bạn' ),
				array( 'icon' => 'quote', 'number' => '02', 'title' => 'Khảo sát', 'description' => 'Khảo sát hiện trạng và tư vấn sơ bộ' ),
				array( 'icon' => 'design', 'number' => '03', 'title' => 'Thiết kế', 'description' => 'Lên concept, mặt bằng và phối cảnh 3D' ),
				array( 'icon' => 'document', 'number' => '04', 'title' => 'Báo giá', 'description' => 'Báo giá chi tiết minh bạch' ),
				array( 'icon' => 'tools', 'number' => '05', 'title' => 'Thi công', 'description' => 'Thi công đúng tiến độ, đảm bảo chất lượng' ),
				array( 'icon' => 'key', 'number' => '06', 'title' => 'Bàn giao', 'description' => 'Nghiệm thu, bàn giao và bảo hành' ),
			),
		),
		array(
			'layout' => 'testimonials',
			'heading' => 'Khách hàng nói gì về chúng tôi',
			'archive_link' => array( 'url' => '#', 'title' => 'Xem tất cả đánh giá', 'target' => '' ),
			'items' => luxnova_default_testimonials(),
		),
		array(
			'layout' => 'partner_logos',
			'items' => array( 'An Cường', 'Häfele', 'Blum', 'Modulex', 'Vicostone', 'TOTO' ),
		),
	);
}

function luxnova_default_project_cards(): array {
	return array(
		array( 'title' => 'Căn hộ 72m² - Vinhomes D’Capitale', 'image' => luxnova_asset( 'assets/images/placeholder-project-1.svg' ), 'area' => '72m²', 'style' => 'Modern', 'budget' => '480 triệu', 'timeline' => '45 ngày' ),
		array( 'title' => 'Căn hộ 89m² - Masteri West Heights', 'image' => luxnova_asset( 'assets/images/placeholder-project-2.svg' ), 'area' => '89m²', 'style' => 'Japandi', 'budget' => '620 triệu', 'timeline' => '50 ngày' ),
		array( 'title' => 'Nhà phố 3 tầng - Hà Đông', 'image' => luxnova_asset( 'assets/images/placeholder-project-3.svg' ), 'area' => '180m²', 'style' => 'Modern', 'budget' => '1.8 tỷ', 'timeline' => '90 ngày' ),
		array( 'title' => 'Spa 200m² - Cầu Giấy, Hà Nội', 'image' => luxnova_asset( 'assets/images/placeholder-project-4.svg' ), 'area' => '200m²', 'style' => 'Luxury', 'budget' => '2.2 tỷ', 'timeline' => '60 ngày' ),
	);
}

function luxnova_default_archive_project_cards(): array {
	return array(
		array( 'title' => 'Villa The Manor Central Park', 'type' => 'Biệt thự', 'type_slug' => 'biet-thu', 'location' => 'Hà Nội', 'area' => '320m²', 'style' => 'Hiện đại', 'year' => '2024', 'image' => luxnova_asset( 'assets/images/placeholder-project-1.svg' ) ),
		array( 'title' => 'Penthouse Vinhomes Landmark 81', 'type' => 'Penthouse', 'type_slug' => 'penthouse', 'location' => 'TP. Hồ Chí Minh', 'area' => '450m²', 'style' => 'Luxury', 'year' => '2024', 'image' => luxnova_asset( 'assets/images/placeholder-project-2.svg' ) ),
		array( 'title' => 'Masteri West Heights', 'type' => 'Căn hộ', 'type_slug' => 'can-ho', 'location' => 'Hà Nội', 'area' => '89m²', 'style' => 'Hiện đại', 'year' => '2024', 'image' => luxnova_asset( 'assets/images/placeholder-project-1.svg' ) ),
		array( 'title' => 'Nhà phố Hà Đông', 'type' => 'Nhà phố', 'type_slug' => 'nha-pho', 'location' => 'Hà Nội', 'area' => '180m²', 'style' => 'Tân cổ điển', 'year' => '2024', 'image' => luxnova_asset( 'assets/images/placeholder-project-3.svg' ) ),
		array( 'title' => 'Villa Ecopark Grand', 'type' => 'Biệt thự', 'type_slug' => 'biet-thu', 'location' => 'Hưng Yên', 'area' => '350m²', 'style' => 'Hiện đại', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-project-2.svg' ) ),
		array( 'title' => 'Vinhomes Ocean Park', 'type' => 'Căn hộ', 'type_slug' => 'can-ho', 'location' => 'Hà Nội', 'area' => '72m²', 'style' => 'Hiện đại', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-project-1.svg' ) ),
		array( 'title' => 'Sunshine City Penthouse', 'type' => 'Penthouse', 'type_slug' => 'penthouse', 'location' => 'Hà Nội', 'area' => '380m²', 'style' => 'Luxury', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-project-2.svg' ) ),
		array( 'title' => 'Văn phòng Techcombank', 'type' => 'Văn phòng', 'type_slug' => 'van-phong', 'location' => 'Hà Nội', 'area' => '1200m²', 'style' => 'Hiện đại', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-interior.svg' ) ),
		array( 'title' => 'Nhà phố Bắc Từ Liêm', 'type' => 'Nhà phố', 'type_slug' => 'nha-pho', 'location' => 'Hà Nội', 'area' => '150m²', 'style' => 'Tối giản', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-project-3.svg' ) ),
		array( 'title' => 'Villa FLC Sầm Sơn', 'type' => 'Biệt thự', 'type_slug' => 'biet-thu', 'location' => 'Thanh Hóa', 'area' => '420m²', 'style' => 'Hiện đại', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-project-3.svg' ) ),
		array( 'title' => "Vinhomes D'Capitale", 'type' => 'Căn hộ', 'type_slug' => 'can-ho', 'location' => 'Hà Nội', 'area' => '98m²', 'style' => 'Hiện đại', 'year' => '2023', 'image' => luxnova_asset( 'assets/images/placeholder-project-4.svg' ) ),
		array( 'title' => 'Khách sạn Boutique Đà Nẵng', 'type' => 'Khách sạn', 'type_slug' => 'khach-san', 'location' => 'Đà Nẵng', 'area' => '2500m²', 'style' => 'Indochine', 'year' => '2022', 'image' => luxnova_asset( 'assets/images/placeholder-service-3.svg' ) ),
	);
}

function luxnova_project_archive_tabs(): array {
	$archive_url = get_post_type_archive_link( 'luxnova_project' ) ?: home_url( '/du-an/' );
	$tabs        = array( array( 'label' => 'Tất cả dự án', 'url' => $archive_url, 'slug' => '' ) );
	$terms       = get_terms( array( 'taxonomy' => 'luxnova_project_type', 'hide_empty' => true ) );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$tabs[] = array( 'label' => $term->name, 'url' => add_query_arg( 'project_type', $term->slug, $archive_url ), 'slug' => $term->slug );
		}

		return $tabs;
	}

	foreach ( array( 'nha-pho' => 'Nhà phố', 'can-ho' => 'Căn hộ', 'biet-thu' => 'Biệt thự', 'penthouse' => 'Penthouse', 'van-phong' => 'Văn phòng', 'khach-san' => 'Khách sạn' ) as $slug => $label ) {
		$tabs[] = array( 'label' => $label, 'url' => add_query_arg( 'project_type', $slug, $archive_url ), 'slug' => $slug );
	}

	return $tabs;
}

function luxnova_project_brochure_url( mixed $file ): string {
	if ( is_array( $file ) && ! empty( $file['url'] ) ) {
		return esc_url_raw( $file['url'] );
	}

	if ( is_numeric( $file ) ) {
		$url = wp_get_attachment_url( (int) $file );
		return $url ? $url : '#project-info';
	}

	if ( is_string( $file ) && '' !== $file ) {
		return esc_url_raw( $file );
	}

	return '#project-info';
}

function luxnova_render_project_listing_card( array $card ): void {
	?>
	<article class="project-listing-card reveal-on-scroll">
		<a class="project-listing-card__image-wrap" href="<?php echo esc_url( $card['url'] ?? '#' ); ?>" aria-label="<?php echo esc_attr( $card['title'] ?? '' ); ?>">
			<?php echo luxnova_image( $card['image'] ?? '', 'luxnova-project', array( 'class' => 'project-listing-card__image', 'alt' => esc_attr( $card['title'] ?? '' ) ), 'assets/images/placeholder-project-1.svg' ); ?>
			<span class="project-listing-card__tag"><?php echo esc_html( $card['type'] ?? 'Dự án' ); ?></span>
			<span class="project-listing-card__arrow" aria-hidden="true">↗</span>
		</a>
		<div class="project-listing-card__body">
			<h2><a href="<?php echo esc_url( $card['url'] ?? '#' ); ?>"><?php echo esc_html( $card['title'] ?? '' ); ?></a></h2>
			<p><?php echo luxnova_icon( 'pin' ); ?><?php echo esc_html( $card['location'] ?? '' ); ?></p>
			<ul>
				<li><?php echo luxnova_icon( 'measure' ); ?><?php echo esc_html( $card['area'] ?? '' ); ?></li>
				<li><?php echo luxnova_icon( 'clock' ); ?><?php echo esc_html( $card['style'] ?? '' ); ?></li>
				<li><?php echo luxnova_icon( 'document' ); ?><?php echo esc_html( $card['year'] ?? '' ); ?></li>
			</ul>
		</div>
	</article>
	<?php
}

function luxnova_default_service_cards(): array {
	return array(
		array(
			'title' => 'Thiết kế nội thất',
			'description' => 'Tư duy sáng tạo, giải pháp thiết kế cá nhân hóa, tối ưu công năng và thẩm mỹ cho từng không gian.',
			'image' => luxnova_asset( 'assets/images/placeholder-service-1.svg' ),
			'icon' => 'design',
			'url' => '#service-process',
		),
		array(
			'title' => 'Thi công nội thất',
			'description' => 'Thi công chuẩn xác, kiểm soát chất lượng chặt chẽ, đảm bảo tiến độ và độ hoàn thiện cao nhất.',
			'image' => luxnova_asset( 'assets/images/placeholder-service-2.svg' ),
			'icon' => 'tools',
			'url' => '#service-process',
		),
		array(
			'title' => 'Nội thất trọn gói',
			'description' => 'Giải pháp trọn gói từ A-Z, đồng hành cùng bạn kiến tạo không gian sống hoàn hảo và bền vững.',
			'image' => luxnova_asset( 'assets/images/placeholder-service-3.svg' ),
			'icon' => 'home',
			'url' => '#service-process',
		),
	);
}

function luxnova_service_process_steps(): array {
	return array(
		array( 'number' => '01', 'title' => 'Tiếp nhận yêu cầu', 'description' => 'Lắng nghe nhu cầu, khảo sát hiện trạng', 'icon' => 'phone' ),
		array( 'number' => '02', 'title' => 'Tư vấn định hướng', 'description' => 'Đề xuất giải pháp phù hợp với ngân sách', 'icon' => 'quote' ),
		array( 'number' => '03', 'title' => 'Thiết kế', 'description' => 'Triển khai ý tưởng, lên bản vẽ 2D, 3D', 'icon' => 'design' ),
		array( 'number' => '04', 'title' => 'Báo giá & ký hợp đồng', 'description' => 'Báo giá chi tiết, thống nhất hạng mục', 'icon' => 'document' ),
		array( 'number' => '05', 'title' => 'Thi công', 'description' => 'Sản xuất & thi công theo thiết kế', 'icon' => 'tools' ),
		array( 'number' => '06', 'title' => 'Bàn giao & bảo hành', 'description' => 'Nghiệm thu, bàn giao và bảo hành dài hạn', 'icon' => 'key' ),
	);
}

function luxnova_why_choose_items(): array {
	return array(
		array( 'title' => 'Kinh nghiệm', 'description' => '8+ năm trong lĩnh vực thiết kế & thi công nội thất', 'icon' => 'document' ),
		array( 'title' => 'Đội ngũ chuyên nghiệp', 'description' => 'Kiến trúc sư và kỹ sư giàu kinh nghiệm, sáng tạo', 'icon' => 'users' ),
		array( 'title' => 'Chất lượng vượt trội', 'description' => 'Vật liệu cao cấp, thi công chuẩn mực đến từng chi tiết', 'icon' => 'shield' ),
		array( 'title' => 'Minh bạch & uy tín', 'description' => 'Báo giá rõ ràng, cam kết tiến độ và chất lượng', 'icon' => 'quote' ),
		array( 'title' => 'Bảo hành dài hạn', 'description' => 'Bảo hành lên đến 5 năm, hỗ trợ nhanh chóng', 'icon' => 'key' ),
	);
}

function luxnova_pricing_plans(): array {
	return array(
		array(
			'label' => 'Gói Basic',
			'title' => 'Thiết kế nội thất',
			'price' => '250.000',
			'unit' => 'VND/m²',
			'features' => array( 'Khảo sát hiện trạng', 'Mặt bằng bố trí công năng 2D', 'Phối cảnh 3D cơ bản', 'Hồ sơ kỹ thuật thi công', 'Tư vấn vật liệu & màu sắc' ),
			'featured' => false,
		),
		array(
			'label' => 'Gói Standard',
			'title' => 'Thiết kế & thi công',
			'price' => '4.500.000',
			'unit' => 'VND/m²',
			'features' => array( 'Tất cả hạng mục gói Basic', 'Phối cảnh 3D chi tiết', 'Hồ sơ kỹ thuật thi công đầy đủ', 'Thi công hoàn thiện', 'Bảo hành 2 năm' ),
			'featured' => true,
		),
		array(
			'label' => 'Gói Premium',
			'title' => 'Nội thất trọn gói',
			'price' => '6.800.000',
			'unit' => 'VND/m²',
			'features' => array( 'Tất cả hạng mục gói Standard', 'Vật liệu cao cấp', 'Sản xuất nội thất tại xưởng', 'Giám sát tác quyền', 'Bảo hành 5 năm' ),
			'featured' => false,
		),
	);
}

function luxnova_cost_factors(): array {
	return array(
		array( 'title' => 'Diện tích & quy mô dự án', 'icon' => 'measure' ),
		array( 'title' => 'Phong cách thiết kế', 'icon' => 'design' ),
		array( 'title' => 'Vật liệu & thiết bị', 'icon' => 'tools' ),
		array( 'title' => 'Độ phức tạp trong thi công', 'icon' => 'home' ),
		array( 'title' => 'Yêu cầu cá nhân hóa', 'icon' => 'quote' ),
	);
}

function luxnova_pricing_faqs(): array {
	return array(
		array( 'question' => 'Giá trên đã bao gồm VAT chưa?', 'answer' => 'Bảng giá mang tính tham khảo và chưa bao gồm VAT. LuxNova sẽ báo giá chi tiết theo hồ sơ thực tế của từng dự án.' ),
		array( 'question' => 'Chi phí thiết kế có được hoàn lại khi thi công không?', 'answer' => 'Tùy gói dịch vụ và phạm vi thi công, chi phí thiết kế có thể được khấu trừ một phần khi ký hợp đồng thi công trọn gói.' ),
		array( 'question' => 'Thời gian thiết kế và thi công mất bao lâu?', 'answer' => 'Thông thường thiết kế mất 10-25 ngày làm việc, thi công từ 30-90 ngày tùy diện tích, mức độ phức tạp và tiến độ sản xuất.' ),
		array( 'question' => 'LuxNova có thanh toán theo tiến độ không?', 'answer' => 'Có. Tiến độ thanh toán được chia theo các mốc rõ ràng như ký hợp đồng, duyệt thiết kế, sản xuất, thi công và bàn giao.' ),
	);
}

function luxnova_default_testimonials(): array {
	return array(
		array( 'name' => 'Anh Minh', 'context' => 'Căn hộ 2PN - Vinhomes Ocean Park', 'quote' => 'LuxNova làm việc rất chuyên nghiệp, đúng tiến độ và không phát sinh thêm chi phí. Căn hộ đẹp hơn mong đợi!', 'rating' => 5, 'avatar' => luxnova_asset( 'assets/images/placeholder-avatar-1.svg' ) ),
		array( 'name' => 'Chị Hương', 'context' => 'Căn hộ 3PN - Masteri West Heights', 'quote' => 'Mình ưng nhất cách tư vấn và thiết kế của LuxNova, rất tinh tế và phù hợp với nhu cầu gia đình.', 'rating' => 5, 'avatar' => luxnova_asset( 'assets/images/placeholder-avatar-2.svg' ) ),
		array( 'name' => 'Anh Tuấn', 'context' => 'Nhà phố - Hà Đông', 'quote' => 'Đội thi công cẩn thận, tỉ mỉ. Bàn giao xong mọi thứ đều hoàn hảo. Sẽ giới thiệu cho bạn bè!', 'rating' => 5, 'avatar' => luxnova_asset( 'assets/images/placeholder-avatar-3.svg' ) ),
	);
}

function luxnova_get_homepage_sections(): array {
	if ( ! function_exists( 'have_rows' ) || ! have_rows( 'homepage_sections' ) ) {
		return luxnova_default_homepage_sections();
	}

	$sections = array();

	while ( have_rows( 'homepage_sections' ) ) {
		the_row();
		$layout = get_row_layout();

		switch ( $layout ) {
			case 'hero':
				$sections[] = array(
					'layout' => 'hero',
					'title' => get_sub_field( 'title' ),
					'highlight' => get_sub_field( 'highlight' ),
					'description' => get_sub_field( 'description' ),
					'background_image' => get_sub_field( 'background_image' ),
					'primary_button' => get_sub_field( 'primary_button' ),
					'secondary_button' => get_sub_field( 'secondary_button' ),
				);
				break;
			case 'statistics':
			case 'services':
			case 'featured_projects':
			case 'home_audit_cta':
			case 'work_process':
			case 'testimonials':
			case 'partner_logos':
				$sections[] = array_merge( array( 'layout' => $layout ), luxnova_acf_sub_fields() );
				break;
		}
	}

	return $sections ?: luxnova_default_homepage_sections();
}

function luxnova_acf_sub_fields(): array {
	$data = array();
	foreach ( get_row( true ) as $key => $value ) {
		if ( 'acf_fc_layout' !== $key ) {
			$data[ $key ] = $value;
		}
	}

	return $data;
}

function luxnova_stars( int $rating ): string {
	$rating = max( 1, min( 5, $rating ) );
	return str_repeat( '<span aria-hidden="true">★</span>', $rating );
}
