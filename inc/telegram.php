<?php
/**
 * Consultation form Telegram integration.
 *
 * @package LuxNova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_luxnova_submit_consultation', 'luxnova_submit_consultation' );
add_action( 'wp_ajax_nopriv_luxnova_submit_consultation', 'luxnova_submit_consultation' );

const LUXNOVA_DEFAULT_TELEGRAM_BOT_TOKEN = '8602579156:AAGhq83QK1Z2u4-0zeXtKL3NuvRcfozf-L0';
const LUXNOVA_DEFAULT_TELEGRAM_CHAT_ID = '6616978127';

function luxnova_submit_consultation(): void {
	if ( ! check_ajax_referer( 'luxnova_consultation_form', 'nonce', false ) ) {
		luxnova_consultation_json_error();
	}

	$fields = array(
		'fullname' => sanitize_text_field( wp_unslash( $_POST['fullname'] ?? '' ) ),
		'phone' => sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ),
		'email' => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'project_type' => sanitize_text_field( wp_unslash( $_POST['project_type'] ?? '' ) ),
		'preferred_date' => sanitize_text_field( wp_unslash( $_POST['preferred_date'] ?? '' ) ),
		'budget' => sanitize_text_field( wp_unslash( $_POST['budget'] ?? '' ) ),
		'message' => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
		'page_url' => esc_url_raw( wp_unslash( $_POST['page_url'] ?? '' ) ),
		'ip' => luxnova_get_request_ip(),
		'time' => current_time( 'Y-m-d H:i:s' ),
	);

	$privacy_accepted = ! empty( $_POST['privacy'] );

	if ( '' === $fields['fullname'] || '' === $fields['phone'] || ! $privacy_accepted ) {
		luxnova_consultation_json_error();
	}

	$bot_token = luxnova_get_telegram_bot_token();
	$chat_id   = luxnova_get_telegram_chat_id();

	if ( '' === $bot_token || '' === $chat_id ) {
		error_log( 'LuxNova consultation form: Telegram config missing. Define LUXNOVA_TELEGRAM_BOT_TOKEN and LUXNOVA_TELEGRAM_CHAT_ID in wp-config.php.' );
		luxnova_consultation_json_error();
	}

	$message   = luxnova_build_telegram_message( $fields );
	$response = wp_remote_post(
		esc_url_raw( 'https://api.telegram.org/bot' . $bot_token . '/sendMessage' ),
		array(
			'timeout' => 15,
			'body' => array(
				'chat_id' => $chat_id,
				'text' => $message,
				'parse_mode' => 'HTML',
				'disable_web_page_preview' => true,
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		error_log( 'LuxNova consultation form: Telegram request failed - ' . $response->get_error_message() );
		luxnova_consultation_json_error();
	}

	$status_code = (int) wp_remote_retrieve_response_code( $response );
	$body        = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( 200 !== $status_code || empty( $body['ok'] ) ) {
		error_log( 'LuxNova consultation form: Telegram API returned an error. HTTP status: ' . $status_code );
		luxnova_consultation_json_error();
	}

	wp_send_json(
		array(
			'success' => true,
			'message' => 'Cảm ơn bạn. LuxNova đã nhận được yêu cầu tư vấn và sẽ liên hệ sớm.',
		)
	);
}

function luxnova_get_telegram_bot_token(): string {
	$bot_token = defined( 'LUXNOVA_TELEGRAM_BOT_TOKEN' ) ? LUXNOVA_TELEGRAM_BOT_TOKEN : '';

	if ( '' === $bot_token || 'YOUR_BOT_TOKEN_HERE' === $bot_token ) {
		$bot_token = LUXNOVA_DEFAULT_TELEGRAM_BOT_TOKEN;
	}

	return sanitize_text_field( $bot_token );
}

function luxnova_get_telegram_chat_id(): string {
	$chat_id = defined( 'LUXNOVA_TELEGRAM_CHAT_ID' ) ? LUXNOVA_TELEGRAM_CHAT_ID : '';

	if ( '' === $chat_id || 'YOUR_CHAT_ID_HERE' === $chat_id ) {
		$chat_id = LUXNOVA_DEFAULT_TELEGRAM_CHAT_ID;
	}

	return sanitize_text_field( $chat_id );
}

function luxnova_build_telegram_message( array $fields ): string {
	return implode(
		"\n",
		array(
			'<b>🔔 LuxNova - Yêu cầu tư vấn mới</b>',
			'',
			'<b>Họ tên:</b> ' . esc_html( $fields['fullname'] ),
			'<b>Số điện thoại:</b> ' . esc_html( $fields['phone'] ),
			'<b>Email:</b> ' . esc_html( $fields['email'] ),
			'<b>Loại công trình:</b> ' . esc_html( $fields['project_type'] ),
			'<b>Ngày mong muốn:</b> ' . esc_html( $fields['preferred_date'] ),
			'<b>Ngân sách:</b> ' . esc_html( $fields['budget'] ),
			'<b>Nội dung:</b>',
			esc_html( $fields['message'] ),
			'',
			'<b>Thời gian:</b> ' . esc_html( $fields['time'] ),
			'<b>Trang gửi form:</b> ' . esc_html( $fields['page_url'] ),
			'<b>IP:</b> ' . esc_html( $fields['ip'] ),
		)
	);
}

function luxnova_get_request_ip(): string {
	$ip_keys = array( 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' );

	foreach ( $ip_keys as $key ) {
		if ( empty( $_SERVER[ $key ] ) ) {
			continue;
		}

		$value = sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) );
		$ip    = trim( explode( ',', $value )[0] );

		if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
			return $ip;
		}
	}

	return '';
}

function luxnova_consultation_json_error(): void {
	wp_send_json(
		array(
			'success' => false,
			'message' => 'Không thể gửi yêu cầu lúc này. Vui lòng thử lại sau.',
		)
	);
}
