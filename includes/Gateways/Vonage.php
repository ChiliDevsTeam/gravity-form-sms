<?php
/**
 * Vonage class
 *
 * Manage  Vonage related functionality on Wp Form
 *
 * @package ChiliDevs\GravityFormsSms
 */

declare(strict_types=1);

namespace ChiliDevs\GravityFormsSms\Gateways;

use WP_Error;

/**
 *  Vonage Class.
 *
 * @package ChiliDevs\GravityFormsSms\Gateways
 */
class Vonage implements GatewayInterface {
	/**
	 * Send SMS via gateways
	 *
	 * @param array $form_data Hold form data.
	 * @param array $options Keep all gateway settings.
	 *
	 * @return array|WP_Error
	 */
	public function send( $form_data, $options ) {
		$api_key    = ! empty( $options['nexmo_api'] ) ? $options['nexmo_api'] : '';
		$api_secret = ! empty( $options['nexmo_api_secret'] ) ? $options['nexmo_api_secret'] : '';
		$from_name  = ! empty( $options['nexmo_from_name'] ) ? $options['nexmo_from_name'] : 'VONAGE';

		if ( '' === $api_key || '' === $api_secret ) {
			return new WP_Error( 'no-gateway-settings', __( 'No API key or Secret found', 'gravity-forms-sms' ), [ 'status' => 401 ] );
		}

		if ( empty( $form_data['number'] ) ) {
			return new WP_Error( 'no-number-found', __( 'No number found for sending SMS', 'gravity-forms-sms' ), [ 'status' => 401 ] );
		}

		$basic  = new \Vonage\Client\Credentials\Basic( $api_key, $api_secret );
		$client = new \Vonage\Client( $basic );

		$response = $client->sms()->send(
			new \Vonage\SMS\Message\SMS( $form_data['number'], $from_name, $form_data['body'] )
		);

		$message = $response->current();

		if ( $message->getStatus() == 0 ) {
			$response = [
				'message'  => __( 'SMS sent successfully', 'gravity-forms-sms' ),
				'response' => $message,
			];
			return $response;
		} else {
			$response = [
				'message'  => __( 'The message failed with status:', 'gravity-forms-sms' ) . $message->getStatus(),
				'response' => $message,
			];
			return $response;
		}
	}
}
