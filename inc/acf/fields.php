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
			'title' => 'Các khối trang chủ',
			'fields' => array(
				array(
					'key' => 'field_luxnova_homepage_sections',
					'label' => 'Các khối trang chủ',
					'name' => 'homepage_sections',
					'type' => 'flexible_content',
					'instructions' => 'Thêm, sửa hoặc sắp xếp các khối nội dung trên trang chủ. Trường nào bỏ trống sẽ dùng nội dung mặc định của theme.',
					'button_label' => 'Thêm khối',
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
			'title' => 'Thông tin dự án',
			'fields' => array(
				luxnova_acf_text( 'field_luxnova_project_area', 'Diện tích', 'area', '', 'Nhập diện tích hiển thị trên card và trang chi tiết. Ví dụ: 89m², 180m².' ),
				luxnova_acf_text( 'field_luxnova_project_style', 'Phong cách', 'style', '', 'Nhập phong cách thiết kế chính. Ví dụ: Hiện đại, Japandi, Indochine, Tân cổ điển.' ),
				luxnova_acf_text( 'field_luxnova_project_budget', 'Ngân sách', 'budget', '', 'Nhập ngân sách hoặc giá trị tham khảo để hiển thị trên card. Ví dụ: 620 triệu, 1.8 tỷ.' ),
				luxnova_acf_text( 'field_luxnova_project_timeline', 'Thời gian thực hiện', 'timeline', '', 'Nhập thời gian thiết kế/thi công. Ví dụ: 45 ngày, 3 tháng.' ),
				luxnova_acf_text( 'field_luxnova_project_location', 'Địa điểm', 'location', '', 'Nhập khu vực hoặc tên dự án. Ví dụ: Hà Nội, Masteri West Heights.' ),
				luxnova_acf_text( 'field_luxnova_project_completion_year', 'Năm hoàn thành', 'completion_year', '', 'Nhập năm hoàn thành dự án. Ví dụ: 2024.' ),
				luxnova_acf_text( 'field_luxnova_project_scope', 'Hạng mục thực hiện', 'scope', 'Thiết kế & Thi công nội thất', 'Mô tả phạm vi LuxNova thực hiện. Ví dụ: Thiết kế nội thất, Thi công trọn gói.' ),
				luxnova_acf_text( 'field_luxnova_project_architect', 'Đội ngũ phụ trách', 'architect', 'LuxNova Design Team', 'Tên kiến trúc sư, nhóm thiết kế hoặc đội phụ trách dự án.' ),
				array(
					'key' => 'field_luxnova_project_brochure',
					'label' => 'Hồ sơ dự án',
					'name' => 'brochure',
					'type' => 'file',
					'return_format' => 'array',
					'instructions' => 'Tải file PDF/brochure nếu muốn có nút tải hồ sơ trên trang chi tiết. Có thể bỏ trống.',
				),
				array(
					'key' => 'field_luxnova_project_gallery',
					'label' => 'Thư viện ảnh',
					'name' => 'gallery',
					'type' => 'gallery',
					'return_format' => 'id',
					'instructions' => 'Chọn nhiều ảnh cho gallery dự án. Ảnh đại diện chính vẫn dùng Featured Image của WordPress.',
				),
				array(
					'key' => 'field_luxnova_project_gallery_videos',
					'label' => 'Thư viện video',
					'name' => 'gallery_videos',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Thêm video',
					'instructions' => 'Không bắt buộc. Thêm video vào cùng lightbox với thư viện ảnh. Video sẽ hiện nút play và mở bằng trình phát có điều khiển.',
					'sub_fields' => array(
						array(
							'key' => 'field_luxnova_project_gallery_video_file',
							'label' => 'File video',
							'name' => 'video',
							'type' => 'file',
							'return_format' => 'array',
							'mime_types' => 'mp4,webm,mov,m4v,ogg,ogv',
							'instructions' => 'Upload hoặc chọn video dự án. Nên dùng MP4/WebM để trình duyệt phát ổn định.',
						),
						array(
							'key' => 'field_luxnova_project_gallery_video_poster',
							'label' => 'Ảnh đại diện video',
							'name' => 'poster',
							'type' => 'image',
							'return_format' => 'id',
							'preview_size' => 'medium',
							'instructions' => 'Ảnh thumbnail hiển thị trong grid trước khi mở video. Nếu bỏ trống, website sẽ dùng ảnh đại diện chính của project.',
						),
					),
				),
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
			'title' => 'Thông tin dịch vụ',
			'fields' => array(
				luxnova_acf_icon_select( 'field_luxnova_service_archive_icon', 'Icon trang lưu trữ', 'icon', 'design' ),
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
			'title' => 'Thông tin đánh giá',
			'fields' => array(
				array( 'key' => 'field_luxnova_testimonial_rating', 'label' => 'Số sao', 'name' => 'rating', 'type' => 'number', 'min' => 1, 'max' => 5, 'default_value' => 5, 'instructions' => 'Nhập số sao đánh giá từ 1 đến 5.' ),
				array( 'key' => 'field_luxnova_testimonial_quote', 'label' => 'Nội dung đánh giá', 'name' => 'quote', 'type' => 'textarea', 'rows' => 4, 'instructions' => 'Nhập lời nhận xét của khách hàng. Nếu bỏ trống, website sẽ lấy nội dung trong editor chính của bài đánh giá.' ),
				luxnova_acf_text( 'field_luxnova_testimonial_context', 'Bối cảnh dự án', 'project_context', '', 'Ví dụ: Căn hộ 3PN - Masteri West Heights.' ),
				array( 'key' => 'field_luxnova_testimonial_avatar', 'label' => 'Ảnh khách hàng', 'name' => 'avatar', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'instructions' => 'Ảnh đại diện khách hàng. Có thể bỏ trống để dùng ảnh mặc định.' ),
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
			'title' => 'Cài đặt chung của theme',
			'fields' => array(
				array( 'key' => 'field_luxnova_brand_logo_image', 'label' => 'Ảnh logo', 'name' => 'brand_logo_image', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'instructions' => 'Upload logo website dùng ở header và footer. Nên dùng PNG/SVG nền trong suốt. Nếu bỏ trống, website sẽ dùng logo chữ bên dưới.' ),
				luxnova_acf_text( 'field_luxnova_brand_logo_text', 'Tên logo chữ', 'brand_logo_text', 'LUXNOVA' ),
				luxnova_acf_text( 'field_luxnova_brand_tagline', 'Tagline thương hiệu', 'brand_tagline', 'Interior Design & Build' ),
				array( 'key' => 'field_luxnova_header_cta', 'label' => 'Nút CTA trên header', 'name' => 'header_cta', 'type' => 'link', 'return_format' => 'array', 'instructions' => 'Nút kêu gọi hành động ở header, ví dụ Đặt lịch tư vấn.' ),
				array( 'key' => 'field_luxnova_footer_description', 'label' => 'Mô tả footer', 'name' => 'footer_description', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Đoạn giới thiệu ngắn hiển thị ở footer.' ),
				luxnova_acf_text( 'field_luxnova_phone', 'Số điện thoại', 'phone', '0968 888 168' ),
				luxnova_acf_text( 'field_luxnova_email', 'Email', 'email', 'hello@luxnova.vn' ),
				array( 'key' => 'field_luxnova_address', 'label' => 'Địa chỉ', 'name' => 'address', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'Địa chỉ hiển thị ở footer và trang liên hệ.' ),
				array( 'key' => 'field_luxnova_map_iframe', 'label' => 'Iframe Google Maps', 'name' => 'map_iframe', 'type' => 'textarea', 'rows' => 4, 'new_lines' => '', 'instructions' => 'Dán mã iframe Google Maps lấy từ Google Maps > Chia sẻ > Nhúng bản đồ. Nếu bỏ trống, footer sẽ dùng ảnh bản đồ nếu đã có.' ),
				luxnova_acf_dynamic_image( 'field_luxnova_map_image', 'Map Image', 'map_image', 'assets/images/placeholder-map.svg' ),
				array(
					'key' => 'field_luxnova_social_links',
					'label' => 'Liên kết mạng xã hội',
					'name' => 'social_links',
					'type' => 'repeater',
					'layout' => 'table',
					'button_label' => 'Thêm liên kết',
					'sub_fields' => array(
						luxnova_acf_text( 'field_luxnova_social_platform', 'Nền tảng', 'platform' ),
						luxnova_acf_icon_image( 'field_luxnova_social_icon_image' ),
						array( 'key' => 'field_luxnova_social_url', 'label' => 'Đường dẫn', 'name' => 'url', 'type' => 'url', 'instructions' => 'Đường dẫn tới trang mạng xã hội.' ),
					),
				),
				array( 'key' => 'field_luxnova_default_og_image', 'label' => 'Ảnh chia sẻ mặc định', 'name' => 'default_og_image', 'type' => 'image', 'return_format' => 'id', 'instructions' => 'Ảnh mặc định dùng khi chia sẻ link website lên mạng xã hội.' ),
				array(
					'key' => 'field_luxnova_archive_modal_content_tab',
					'label' => 'Nội dung trang lưu trữ & popup',
					'name' => '',
					'type' => 'tab',
					'placement' => 'top',
				),
				luxnova_acf_group( 'field_luxnova_service_archive_content', 'Nội dung trang lưu trữ dịch vụ', 'service_archive_content', luxnova_acf_service_archive_fields() ),
				luxnova_acf_group( 'field_luxnova_project_archive_content', 'Nội dung trang lưu trữ dự án', 'project_archive_content', luxnova_acf_project_archive_fields() ),
				luxnova_acf_group( 'field_luxnova_consultation_modal_content', 'Nội dung popup tư vấn', 'consultation_modal_content', luxnova_acf_consultation_modal_fields() ),
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
			'title' => 'Nội dung trang liên hệ',
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
			'title' => 'Nội dung trang FAQ',
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
			'title' => 'Nội dung trang bảng giá',
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
			'title' => 'Nội dung mặc định cho trang chi tiết dự án',
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
		'label' => luxnova_acf_label( $label ),
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
		'label' => luxnova_acf_label( $label ),
		'name' => $name,
		'type' => 'select',
		'instructions' => $instructions ?: luxnova_acf_default_instruction( $default ),
		'choices' => array(
			'chart' => 'Biểu đồ',
			'users' => 'Khách hàng',
			'shield' => 'Bảo hành',
			'document' => 'Tài liệu',
			'home' => 'Nhà',
			'measure' => 'Đo đạc',
			'design' => 'Thiết kế',
			'quote' => 'Trích dẫn',
			'tools' => 'Thi công',
			'key' => 'Bàn giao',
			'clock' => 'Thời gian',
			'phone' => 'Điện thoại',
			'mail' => 'Email',
			'pin' => 'Vị trí',
			'facebook' => 'Facebook',
			'instagram' => 'Instagram',
			'youtube' => 'YouTube',
			'tiktok' => 'TikTok',
			'linkedin' => 'LinkedIn',
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
		? 'Nếu bỏ trống, website sẽ dùng nội dung mặc định trong theme.'
		: sprintf( 'Nếu bỏ trống, website sẽ dùng mặc định: %s', $default );
}

function luxnova_acf_dynamic_text( string $key, string $label, string $name, string $default = '' ): array {
	return array(
		'key' => $key,
		'label' => luxnova_acf_label( $label ),
		'name' => $name,
		'type' => 'text',
		'instructions' => luxnova_acf_default_instruction( $default ),
		'placeholder' => $default,
	);
}

function luxnova_acf_dynamic_textarea( string $key, string $label, string $name, string $default = '', int $rows = 3 ): array {
	return array(
		'key' => $key,
		'label' => luxnova_acf_label( $label ),
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
		'label' => luxnova_acf_label( $label ),
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
		'label' => luxnova_acf_label( $label ),
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
		'label' => luxnova_acf_label( $label ),
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
		'label' => luxnova_acf_label( $label ),
		'name' => $name,
		'type' => 'repeater',
		'layout' => $layout,
		'button_label' => 'Thêm item',
		'instructions' => empty( $summary )
			? 'Nếu không thêm item nào, website sẽ dùng danh sách mặc định trong theme.'
			: luxnova_acf_default_instruction( $summary ),
		'sub_fields' => $sub_fields,
	);
}

function luxnova_acf_label( string $label ): string {
	$labels = array(
		'Answer' => 'Câu trả lời',
		'Archive Label' => 'Nhãn trang lưu trữ',
		'Area Label' => 'Nhãn diện tích',
		'Architect Label' => 'Nhãn đội ngũ phụ trách',
		'Background Image' => 'Ảnh nền',
		'Brochure Label' => 'Nhãn tải hồ sơ',
		'Consultation Label' => 'Nhãn đặt lịch tư vấn',
		'Eyebrow' => 'Dòng nhãn nhỏ',
		'Gallery Label' => 'Nhãn xem ảnh',
		'Highlight' => 'Dòng nhấn mạnh',
		'Logo' => 'Logo',
		'Price' => 'Giá',
		'Scope Label' => 'Nhãn hạng mục thực hiện',
		'Style Label' => 'Nhãn phong cách',
		'Summary Fallback' => 'Tóm tắt mặc định',
		'Tagline' => 'Tagline',
		'Type Label' => 'Nhãn loại công trình',
		'Year Label' => 'Nhãn năm hoàn thành',
		'Action Labels' => 'Nhãn nút hành động',
		'Archive Link' => 'Link xem tất cả',
		'Area' => 'Diện tích',
		'Avatar' => 'Ảnh đại diện',
		'Benefits' => 'Lợi ích',
		'Benefits Aria Label' => 'Nhãn hỗ trợ truy cập cho lợi ích',
		'Breadcrumb Labels' => 'Nhãn breadcrumb',
		'Brochure' => 'Hồ sơ dự án',
		'Button' => 'Nút bấm',
		'Button Icon' => 'Icon nút bấm',
		'Button Icon Image' => 'Ảnh icon nút bấm',
		'Button Label' => 'Nhãn nút bấm',
		'Button URL' => 'URL nút bấm',
		'Card Link Label' => 'Nhãn link trên card',
		'Closing CTA' => 'CTA cuối trang',
		'Contact Items' => 'Thông tin liên hệ',
		'Contact Page Content' => 'Nội dung trang liên hệ',
		'Content' => 'Nội dung',
		'Cost Factors' => 'Yếu tố ảnh hưởng chi phí',
		'Description' => 'Mô tả',
		'FAQ Heading' => 'Tiêu đề FAQ',
		'FAQ Image' => 'Ảnh FAQ',
		'FAQ Items' => 'Câu hỏi thường gặp',
		'FAQ Page Content' => 'Nội dung trang FAQ',
		'Factors Heading' => 'Tiêu đề yếu tố chi phí',
		'Feature' => 'Ý chính',
		'Feature Cards' => 'Thẻ điểm nổi bật',
		'Featured Plan' => 'Gói nổi bật',
		'Features' => 'Danh sách ý chính',
		'Form Heading' => 'Tiêu đề form',
		'Gallery' => 'Thư viện ảnh',
		'Gallery Heading' => 'Tiêu đề thư viện ảnh',
		'Gallery More Label' => 'Nhãn xem thêm ảnh',
		'Heading' => 'Tiêu đề',
		'Hero' => 'Khối hero',
		'Hero Meta Labels' => 'Nhãn thông tin hero',
		'Hero Trust Items' => 'Cam kết trong hero',
		'Home Label' => 'Nhãn trang chủ',
		'Icon' => 'Icon',
		'Icon Image' => 'Ảnh icon',
		'Image' => 'Ảnh',
		'Info Heading' => 'Tiêu đề thông tin',
		'Info Labels' => 'Nhãn thông tin',
		'Intro' => 'Đoạn giới thiệu',
		'Items' => 'Danh sách',
		'Label' => 'Nhãn',
		'Link' => 'Link',
		'Location' => 'Địa điểm',
		'Location Label' => 'Nhãn địa điểm',
		'Map Block' => 'Khối bản đồ',
		'Map Image' => 'Ảnh bản đồ',
		'Name' => 'Tên',
		'Number' => 'Số',
		'Paragraph' => 'Đoạn văn',
		'Plans Heading' => 'Tiêu đề bảng giá',
		'Plans Note' => 'Ghi chú bảng giá',
		'Pricing FAQs' => 'FAQ bảng giá',
		'Pricing Plans' => 'Gói giá',
		'Pricing Page Content' => 'Nội dung trang bảng giá',
		'Primary Button' => 'Nút chính',
		'Primary Button Label' => 'Nhãn nút chính',
		'Process Heading' => 'Tiêu đề quy trình',
		'Project Context' => 'Bối cảnh dự án',
		'Projects' => 'Dự án',
		'Question' => 'Câu hỏi',
		'Rating' => 'Số sao',
		'Related Heading' => 'Tiêu đề dự án liên quan',
		'Related Link Label' => 'Nhãn link dự án liên quan',
		'Ribbon' => 'Nhãn nổi bật',
		'Secondary Button' => 'Nút phụ',
		'Secondary Button Label' => 'Nhãn nút phụ',
		'Service Archive Content' => 'Nội dung trang lưu trữ dịch vụ',
		'Services Heading' => 'Tiêu đề dịch vụ',
		'Sidebar' => 'Thanh bên',
		'Single Project Fallback Content' => 'Nội dung mặc định cho trang chi tiết dự án',
		'Steps' => 'Các bước',
		'Story Fallback Paragraphs' => 'Đoạn nội dung câu chuyện mặc định',
		'Story Heading' => 'Tiêu đề câu chuyện',
		'Subtitle' => 'Tiêu đề phụ',
		'Suffix' => 'Hậu tố',
		'Testimonials' => 'Đánh giá khách hàng',
		'Timeline' => 'Thời gian thực hiện',
		'Title' => 'Tiêu đề',
		'Title Suffix' => 'Phần sau tiêu đề',
		'Unit' => 'Đơn vị',
		'Why Heading' => 'Tiêu đề lý do chọn',
	);

	return $labels[ $label ] ?? $label;
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
						array( 'key' => 'field_luxnova_contact_item_url', 'label' => 'Đường dẫn', 'name' => 'url', 'type' => 'url', 'instructions' => 'Nếu bỏ trống, item sẽ hiển thị như text thường.' ),
					),
					$defaults['contact_items'] ?? array()
				),
				luxnova_acf_group(
					'field_luxnova_contact_map',
					'Map Block',
					'map',
					array(
						array( 'key' => 'field_luxnova_contact_map_iframe', 'label' => 'Iframe Google Maps', 'name' => 'iframe', 'type' => 'textarea', 'rows' => 4, 'new_lines' => '', 'instructions' => 'Dán mã iframe Google Maps cho block bản đồ trên trang Liên hệ. Nếu bỏ trống, website sẽ dùng iframe trong Cài đặt chung hoặc ảnh bản đồ cũ nếu có.' ),
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
						array( 'key' => 'field_luxnova_faq_sidebar_button_url', 'label' => 'URL nút bấm', 'name' => 'button_url', 'type' => 'url', 'instructions' => luxnova_acf_default_instruction( $defaults['sidebar']['button_url'] ?? home_url( '/lien-he/' ) ), 'placeholder' => $defaults['sidebar']['button_url'] ?? home_url( '/lien-he/' ) ),
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
							'label' => 'Gói nổi bật',
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
			),
			'Nhóm nâng cao: dùng để chỉnh chữ mặc định trên trang chi tiết dự án. Khi chỉ thêm dự án mới, bạn thường chỉ cần nhập tiêu đề, Featured Image, nội dung bài viết và nhóm "Thông tin dự án" phía trên.'
		),
	);
}

function luxnova_acf_homepage_defaults_by_layout(): array {
	$defaults = array();

	foreach ( luxnova_default_homepage_sections() as $section ) {
		if ( ! empty( $section['layout'] ) ) {
			$defaults[ $section['layout'] ] = $section;
		}
	}

	return $defaults;
}

function luxnova_acf_link( string $key, string $label, string $name, array $default = array() ): array {
	$default_title = trim( (string) ( $default['title'] ?? '' ) );
	$default_url   = trim( (string) ( $default['url'] ?? '' ) );
	$summary       = trim( $default_title . ( $default_url ? " ({$default_url})" : '' ) );

	return array(
		'key' => $key,
		'label' => luxnova_acf_label( $label ),
		'name' => $name,
		'type' => 'link',
		'return_format' => 'array',
		'instructions' => $summary
			? luxnova_acf_default_instruction( $summary )
			: 'Nếu bỏ trống, website sẽ dùng link mặc định trong theme.',
	);
}

function luxnova_acf_homepage_relationship( string $key, string $label, string $name, array $post_types, string $instructions ): array {
	return array(
		'key' => $key,
		'label' => luxnova_acf_label( $label ),
		'name' => $name,
		'type' => 'relationship',
		'post_type' => $post_types,
		'return_format' => 'id',
		'instructions' => $instructions,
	);
}

function luxnova_acf_homepage_layouts(): array {
	$defaults     = luxnova_acf_homepage_defaults_by_layout();
	$hero         = $defaults['hero'] ?? array();
	$statistics   = $defaults['statistics'] ?? array();
	$services     = $defaults['services'] ?? array();
	$projects     = $defaults['featured_projects'] ?? array();
	$audit        = $defaults['home_audit_cta'] ?? array();
	$process      = $defaults['work_process'] ?? array();
	$testimonials = $defaults['testimonials'] ?? array();
	$partners     = $defaults['partner_logos'] ?? array();

	return array(
		'layout_luxnova_hero' => array(
			'key' => 'layout_luxnova_hero',
			'name' => 'hero',
			'label' => 'Banner hero',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_textarea( 'field_luxnova_hero_title', 'Title', 'title', $hero['title'] ?? '', 2 ),
				luxnova_acf_dynamic_text( 'field_luxnova_hero_highlight', 'Highlight', 'highlight', $hero['highlight'] ?? '' ),
				luxnova_acf_dynamic_textarea( 'field_luxnova_hero_description', 'Description', 'description', $hero['description'] ?? '', 3 ),
				luxnova_acf_dynamic_image( 'field_luxnova_hero_background', 'Background Image', 'background_image', 'assets/images/placeholder-hero.svg' ),
				luxnova_acf_link( 'field_luxnova_hero_primary_button', 'Primary Button', 'primary_button', $hero['primary_button'] ?? array() ),
				luxnova_acf_link( 'field_luxnova_hero_secondary_button', 'Secondary Button', 'secondary_button', $hero['secondary_button'] ?? array() ),
			),
		),
		'layout_luxnova_statistics' => array(
			'key' => 'layout_luxnova_statistics',
			'name' => 'statistics',
			'label' => 'Thống kê',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_repeater(
					'field_luxnova_statistics_items',
					'Items',
					'items',
					array(
						luxnova_acf_icon_select( 'field_luxnova_stat_icon', 'Icon', 'icon', 'chart' ),
						luxnova_acf_icon_image( 'field_luxnova_stat_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_stat_number', 'Number', 'number' ),
						luxnova_acf_dynamic_text( 'field_luxnova_stat_suffix', 'Suffix', 'suffix' ),
						luxnova_acf_dynamic_text( 'field_luxnova_stat_label', 'Label', 'label' ),
					),
					$statistics['items'] ?? array(),
					'table'
				),
			),
		),
		'layout_luxnova_services' => array(
			'key' => 'layout_luxnova_services',
			'name' => 'services',
			'label' => 'Dịch vụ',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_text( 'field_luxnova_services_heading', 'Heading', 'heading', $services['heading'] ?? '' ),
				luxnova_acf_dynamic_text( 'field_luxnova_services_subtitle', 'Subtitle', 'subtitle', $services['subtitle'] ?? '' ),
				luxnova_acf_link( 'field_luxnova_services_archive_link', 'Archive Link', 'archive_link', $services['archive_link'] ?? array() ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_services_items',
					'Items',
					'items',
					array(
						luxnova_acf_dynamic_text( 'field_luxnova_service_title', 'Title', 'title' ),
						luxnova_acf_dynamic_text( 'field_luxnova_service_tagline', 'Tagline', 'tagline' ),
						luxnova_acf_dynamic_image( 'field_luxnova_service_image', 'Image', 'image', 'assets/images/placeholder-interior.svg' ),
						luxnova_acf_dynamic_repeater(
							'field_luxnova_service_features',
							'Features',
							'features',
							array(
								luxnova_acf_dynamic_text( 'field_luxnova_service_feature_text', 'Feature', 'text' ),
							),
							array(),
							'table'
						),
						luxnova_acf_link( 'field_luxnova_service_link', 'Link', 'link' ),
					),
					$services['items'] ?? array()
				),
			),
		),
		'layout_luxnova_projects' => array(
			'key' => 'layout_luxnova_projects',
			'name' => 'featured_projects',
			'label' => 'Dự án tiêu biểu',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_text( 'field_luxnova_projects_heading', 'Heading', 'heading', $projects['heading'] ?? '' ),
				luxnova_acf_link( 'field_luxnova_projects_archive_link', 'Archive Link', 'archive_link', $projects['archive_link'] ?? array() ),
				luxnova_acf_homepage_relationship( 'field_luxnova_projects_items', 'Projects', 'items', array( 'luxnova_project' ), 'Nếu bỏ trống, website sẽ dùng các card dự án mặc định trong theme.' ),
			),
		),
		'layout_luxnova_home_audit' => array(
			'key' => 'layout_luxnova_home_audit',
			'name' => 'home_audit_cta',
			'label' => 'CTA Home Audit',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_image( 'field_luxnova_audit_image', 'Image', 'image', 'assets/images/placeholder-audit.svg' ),
				luxnova_acf_dynamic_text( 'field_luxnova_audit_label', 'Label', 'label', $audit['label'] ?? '' ),
				luxnova_acf_dynamic_text( 'field_luxnova_audit_heading', 'Heading', 'heading', $audit['heading'] ?? '' ),
				luxnova_acf_dynamic_textarea( 'field_luxnova_audit_description', 'Description', 'description', $audit['description'] ?? '', 3 ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_audit_benefits',
					'Benefits',
					'benefits',
					array(
						luxnova_acf_icon_select( 'field_luxnova_audit_benefit_icon', 'Icon', 'icon', 'document' ),
						luxnova_acf_icon_image( 'field_luxnova_audit_benefit_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_audit_benefit_label', 'Label', 'label' ),
					),
					$audit['benefits'] ?? array(),
					'table'
				),
				luxnova_acf_link( 'field_luxnova_audit_button', 'Button', 'button', $audit['button'] ?? array() ),
			),
		),
		'layout_luxnova_process' => array(
			'key' => 'layout_luxnova_process',
			'name' => 'work_process',
			'label' => 'Quy trình làm việc',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_text( 'field_luxnova_process_heading', 'Heading', 'heading', $process['heading'] ?? '' ),
				luxnova_acf_dynamic_repeater(
					'field_luxnova_process_steps',
					'Steps',
					'steps',
					array(
						luxnova_acf_icon_select( 'field_luxnova_process_icon', 'Icon', 'icon', 'home' ),
						luxnova_acf_icon_image( 'field_luxnova_process_icon_image' ),
						luxnova_acf_dynamic_text( 'field_luxnova_process_number', 'Number', 'number' ),
						luxnova_acf_dynamic_text( 'field_luxnova_process_title', 'Title', 'title' ),
						luxnova_acf_dynamic_text( 'field_luxnova_process_description', 'Description', 'description' ),
					),
					$process['steps'] ?? array()
				),
			),
		),
		'layout_luxnova_testimonials' => array(
			'key' => 'layout_luxnova_testimonials',
			'name' => 'testimonials',
			'label' => 'Đánh giá khách hàng',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_text( 'field_luxnova_testimonials_heading', 'Heading', 'heading', $testimonials['heading'] ?? '' ),
				luxnova_acf_link( 'field_luxnova_testimonials_archive_link', 'Archive Link', 'archive_link', $testimonials['archive_link'] ?? array() ),
				luxnova_acf_homepage_relationship( 'field_luxnova_testimonials_items', 'Testimonials', 'items', array( 'luxnova_testimonial' ), 'Nếu bỏ trống, website sẽ dùng danh sách đánh giá mặc định trong theme.' ),
			),
		),
		'layout_luxnova_partner_logos' => array(
			'key' => 'layout_luxnova_partner_logos',
			'name' => 'partner_logos',
			'label' => 'Logo đối tác',
			'display' => 'block',
			'sub_fields' => array(
				luxnova_acf_dynamic_repeater(
					'field_luxnova_partner_items',
					'Logos',
					'items',
					array(
						luxnova_acf_dynamic_image( 'field_luxnova_partner_logo', 'Logo', 'logo', 'assets/images/placeholder-logo.svg' ),
						luxnova_acf_dynamic_text( 'field_luxnova_partner_name', 'Name', 'name' ),
						array(
							'key' => 'field_luxnova_partner_url',
							'label' => 'Đường dẫn',
							'name' => 'url',
							'type' => 'url',
							'instructions' => 'Không bắt buộc. Bỏ trống nếu logo không cần gắn link.',
						),
					),
					$partners['items'] ?? array(),
					'table'
				),
			),
		),
	);
}
