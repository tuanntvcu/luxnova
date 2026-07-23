<?php
/**
 * Design styles parent page template.
 *
 * Template Name: LuxNova Design Styles
 *
 * @package LuxNova
 */

get_header();

$page_id    = (int) get_queried_object_id();
$page_data  = luxnova_design_styles_page_data( $page_id );
$hero       = $page_data['hero'] ?? array();
$quiz_cta   = $page_data['quiz_cta'] ?? array();
$quiz_modal = $page_data['quiz_modal'] ?? array();
$questions  = array(
	array(
		'name' => 'buildingType',
		'title' => 'Bạn đang thiết kế loại công trình nào?',
		'answers' => array(
			'apartment' => 'Chung cư',
			'townhouse' => 'Nhà phố',
			'villa' => 'Biệt thự',
			'penthouse' => 'Penthouse',
			'office' => 'Văn phòng',
		),
	),
	array(
		'name' => 'area',
		'title' => 'Diện tích khoảng bao nhiêu?',
		'answers' => array(
			'under70' => 'Dưới 70m²',
			'70_100' => '70-100m²',
			'100_200' => '100-200m²',
			'over200' => 'Trên 200m²',
		),
	),
	array(
		'name' => 'atmosphere',
		'title' => 'Bạn thích không gian như thế nào?',
		'answers' => array(
			'minimal' => 'Tối giản, gọn gàng',
			'cozy' => 'Ấm cúng',
			'luxury' => 'Sang trọng',
			'nature' => 'Gần gũi thiên nhiên',
			'unique' => 'Cá tính, độc đáo',
		),
	),
	array(
		'name' => 'color',
		'title' => 'Gam màu bạn yêu thích là?',
		'answers' => array(
			'whiteCream' => 'Trắng - Kem',
			'naturalWood' => 'Gỗ tự nhiên',
			'blackGrey' => 'Đen - Xám',
			'neutral' => 'Màu trung tính',
			'unknown' => 'Tôi chưa biết',
		),
	),
	array(
		'name' => 'budget',
		'title' => 'Ngân sách đầu tư dự kiến?',
		'answers' => array(
			'under300' => 'Dưới 300 triệu',
			'300_600' => '300-600 triệu',
			'600_1b' => '600 triệu - 1 tỷ',
			'over1b' => 'Trên 1 tỷ',
		),
	),
	array(
		'name' => 'family',
		'title' => 'Gia đình bạn gồm?',
		'answers' => array(
			'single' => 'Người độc thân',
			'youngCouple' => 'Vợ chồng trẻ',
			'kids' => 'Gia đình có con nhỏ',
			'multiGen' => 'Gia đình nhiều thế hệ',
		),
	),
	array(
		'name' => 'priority',
		'title' => 'Điều bạn ưu tiên nhất khi làm nội thất là gì?',
		'answers' => array(
			'aesthetic' => 'Đẹp và thẩm mỹ',
			'function' => 'Tối ưu công năng',
			'budget' => 'Tiết kiệm chi phí',
			'durable' => 'Bền, dễ sử dụng',
			'status' => 'Sang trọng để thể hiện đẳng cấp',
		),
	),
);
?>
<section class="design-styles-hero">
	<div class="design-styles-hero__media" aria-hidden="true">
		<?php echo luxnova_responsive_image( $hero['image'] ?? '', $hero['mobile_image'] ?? '', 'luxnova-hero', array( 'class' => 'design-styles-hero__image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ), $hero['image_fallback'] ?? 'assets/images/placeholder-hero.svg' ); ?>
	</div>
	<div class="design-styles-hero__overlay"></div>
	<div class="container design-styles-hero__content reveal-on-scroll">
		<?php if ( ! empty( $hero['eyebrow'] ) ) : ?>
			<p class="design-styles-hero__eyebrow"><?php echo esc_html( $hero['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1><?php echo esc_html( $hero['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $hero['description'] ) ) : ?>
			<p><?php echo esc_html( $hero['description'] ); ?></p>
		<?php endif; ?>
		<div class="design-styles-hero__actions">
			<button type="button" class="button button--gold" data-design-style-quiz-open><?php echo esc_html( $hero['button_label'] ?? 'Khám phá ngay' ); ?></button>
		</div>
	</div>
</section>

<section class="design-style-listing">
	<div class="container">
		<header class="service-section-heading design-style-listing__heading">
			<h2><?php echo esc_html( $page_data['styles_heading'] ?? '' ); ?></h2>
		</header>
		<div class="design-style-grid">
			<?php foreach ( (array) ( $page_data['styles'] ?? array() ) as $style ) : ?>
				<?php
				$title = trim( (string) ( $style['title'] ?? '' ) );
				if ( '' === $title ) {
					continue;
				}
				$link = is_array( $style['link'] ?? null ) ? $style['link'] : array();
				if ( empty( $link['url'] ) ) {
					$slug = sanitize_title( (string) ( $style['slug'] ?? $title ) );
					$link = array(
						'url' => trailingslashit( luxnova_design_styles_url() ) . $slug . '/',
						'title' => $page_data['card_link_label'] ?? 'Xem chi tiết',
						'target' => '',
					);
				}
				?>
				<article class="design-style-card reveal-on-scroll">
					<a class="design-style-card__link" href="<?php echo esc_url( $link['url'] ); ?>" <?php echo ! empty( $link['target'] ) ? 'target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>
						<?php echo luxnova_image( $style['image'] ?? '', 'luxnova-card', array( 'class' => 'design-style-card__image', 'alt' => esc_attr( $title ) ), $style['image_fallback'] ?? 'assets/images/placeholder-interior.svg' ); ?>
						<span class="design-style-card__shade"></span>
						<span class="design-style-card__content">
							<strong><?php echo esc_html( $title ); ?></strong>
							<?php if ( ! empty( $style['tagline'] ) ) : ?>
								<em><?php echo esc_html( $style['tagline'] ); ?></em>
							<?php endif; ?>
							<span><?php echo esc_html( $link['title'] ?? ( $page_data['card_link_label'] ?? 'Xem chi tiết' ) ); ?> <span aria-hidden="true">-&gt;</span></span>
						</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="design-style-quiz-cta">
	<div class="container design-style-quiz-cta__inner reveal-on-scroll">
		<div class="design-style-quiz-cta__image" aria-hidden="true">
			<?php echo luxnova_image( $quiz_cta['image'] ?? '', 'luxnova-card', array( 'alt' => '' ), $quiz_cta['image_fallback'] ?? 'assets/images/placeholder-project-1.svg' ); ?>
		</div>
		<div class="design-style-quiz-cta__copy">
			<h2><?php echo esc_html( $quiz_cta['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $quiz_cta['description'] ) ) : ?>
				<p><?php echo esc_html( $quiz_cta['description'] ); ?></p>
			<?php endif; ?>
			<button type="button" class="button button--gold" data-design-style-quiz-open><?php echo esc_html( $quiz_cta['button_label'] ?? 'Khám phá ngay' ); ?></button>
		</div>
	</div>
</section>

<div class="design-quiz-modal" data-design-style-quiz hidden aria-hidden="true">
	<div class="design-quiz-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="design-quiz-title" tabindex="-1">
		<button type="button" class="design-quiz-modal__close" aria-label="<?php esc_attr_e( 'Đóng', 'luxnova' ); ?>" data-design-style-quiz-close>×</button>
		<div class="design-quiz-modal__intro">
			<?php if ( ! empty( $quiz_modal['eyebrow'] ) ) : ?>
				<p><?php echo esc_html( $quiz_modal['eyebrow'] ); ?></p>
			<?php endif; ?>
			<h2 id="design-quiz-title"><?php echo esc_html( $quiz_modal['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $quiz_modal['intro'] ) ) : ?>
				<span><?php echo esc_html( $quiz_modal['intro'] ); ?></span>
			<?php endif; ?>
		</div>
		<form class="design-quiz-form" data-design-style-quiz-form>
			<div class="design-quiz-form__progress" data-design-style-quiz-progress>1 / 7</div>
			<?php foreach ( $questions as $index => $question ) : ?>
				<fieldset class="design-quiz-step" data-design-style-quiz-step <?php echo 0 === $index ? '' : 'hidden aria-hidden="true"'; ?>>
					<legend>
						<span><?php echo esc_html( 'Câu ' . ( $index + 1 ) ); ?></span>
						<?php echo esc_html( $question['title'] ); ?>
					</legend>
					<div class="design-quiz-options">
						<?php foreach ( $question['answers'] as $value => $label ) : ?>
							<label>
								<input type="radio" name="<?php echo esc_attr( $question['name'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
								<span><?php echo esc_html( $label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
					<p class="design-quiz-form__error" data-design-style-quiz-error hidden><?php esc_html_e( 'Vui lòng chọn một câu trả lời để tiếp tục.', 'luxnova' ); ?></p>
				</fieldset>
			<?php endforeach; ?>

			<section class="design-quiz-result" data-design-style-quiz-result hidden>
				<p class="design-quiz-result__eyebrow">🎉 Phong cách phù hợp nhất với bạn là:</p>
				<h3><span data-design-style-primary-name></span> <em>(<span data-design-style-primary-percent></span>)</em></h3>
				<div class="design-quiz-result__alt">
					<p>Ngoài ra bạn cũng có thể tham khảo:</p>
					<ul data-design-style-alternatives></ul>
				</div>
				<div class="design-quiz-result__reasons">
					<h4 data-design-style-reason-title></h4>
					<ul data-design-style-reasons></ul>
				</div>
				<div class="design-quiz-result__actions">
					<a class="button button--gold js-consultation-modal" href="#consultation-modal"><?php echo esc_html( $quiz_modal['cta_label'] ?? 'Nhận tư vấn miễn phí' ); ?></a>
					<button type="button" class="button button--outline-dark" data-design-style-quiz-restart><?php esc_html_e( 'Làm lại quiz', 'luxnova' ); ?></button>
				</div>
			</section>

			<div class="design-quiz-form__actions">
				<button type="button" class="button button--outline-dark" data-design-style-quiz-prev disabled><?php esc_html_e( 'Trước', 'luxnova' ); ?></button>
				<button type="button" class="button button--gold" data-design-style-quiz-next><?php esc_html_e( 'Tiếp tục', 'luxnova' ); ?></button>
				<button type="submit" class="button button--gold" data-design-style-quiz-submit hidden><?php esc_html_e( 'Xem kết quả', 'luxnova' ); ?></button>
			</div>
		</form>
	</div>
</div>
<?php
get_footer();
