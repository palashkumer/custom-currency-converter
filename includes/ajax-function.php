<?php
function convert_currency() {
	$amount        = isset( $_POST['amount'] ) ? floatval( $_POST['amount'] ) : 0;
	$from_currency = isset( $_POST['fromCurrency'] ) ? sanitize_text_field( $_POST['fromCurrency'] ) : '';
	$to_currency   = isset( $_POST['toCurrency'] ) ? sanitize_text_field( $_POST['toCurrency'] ) : '';

	// Fetch latest exchange rates from Open Exchange Rates API.
	$api_key = 'YOUR_OPEN_EXCHANGE_RATES_API_KEY';
	$api_url = "https://open.er-api.com/v6/latest?base={$from_currency}&symbols={$to_currency}&apikey={$api_key}";

	$response = wp_remote_get( $api_url );

	if ( is_wp_error( $response ) ) {
		wp_send_json_error( 'Error fetching exchange rates.' );
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! $data || empty( $data['rates'] ) || ! isset( $data['rates'][ $to_currency ] ) ) {
		wp_send_json_error( 'Error retrieving exchange rates.' );
	}

	$conversion_rate  = $data['rates'][ $to_currency ];
	$converted_amount = $amount * $conversion_rate;

	wp_send_json_success( $converted_amount );
}
