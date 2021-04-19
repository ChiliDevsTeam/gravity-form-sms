<?php
/**
 * ClickSend class
 *
 * Manage  ClickSend related functionality on Wp Form
 *
 * @package ChiliDevs\GravityFormsSms
 */

declare(strict_types=1);

namespace ChiliDevs\GravityFormsSms\Gateways;

use WP_Error;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use ClickSend\Api\SMSApi as ClickSendSMSApi;
use ClickSend\Configuration as ClickSendConfig;
use ClickSend\Model\SmsMessage as ClickSendSMSMessage;
use ClickSend\Model\SmsMessageCollection as ClickSendSMSMessageCollection;

/**
 *  ClickSend Class.
 *
 * @package ChiliDevs\GravityFormsSms\Gateways
 */
class ClickSend implements GatewayInterface {
	/**
	 * Send SMS via gateways
	 *
	 * @param array $form_data Hold form data.
	 * @param array $options Keep all gateway settings.
	 *
	 * @return array|WP_Error
	 */
	public function send( $form_data, $options ) {
		$clicksend_username = ! empty( $options['clicksend_username'] ) ? $options['clicksend_username'] : '';
		$clicksend_api_key  = ! empty( $options['clicksend_api'] ) ? $options['clicksend_api'] : '';

		if ( '' === $clicksend_username || '' === $clicksend_api_key ) {
			return new WP_Error( 'no-gateway-settings', __( 'No Username or API key', 'gravity-forms-sms' ), [ 'status' => 401 ] );
		}

		if ( empty( $form_data['number'] ) ) {
			return new WP_Error( 'no-number-found', __( 'No number found for sending SMS', 'gravity-forms-sms' ), [ 'status' => 401 ] );
		}

		$config = ClickSendConfig::getDefaultConfiguration()
		->setUsername( $clicksend_username )
		->setPassword( $clicksend_api_key );

		$api_instance = new ClickSendSMSApi( new GuzzleClient(), $config );
		$msg          = new ClickSendSMSMessage();

		$msg->setBody( $form_data['body'] );
		$msg->setTo( $form_data['number'] );
		$msg->setSource( 'sdk' );

		$sms_messages = new ClickSendSMSMessageCollection();
		$sms_messages->setMessages( [ $msg ] );

		try {
			$result = $api_instance->smsSendPost( $sms_messages );

			$response = [
				'message'  => __( 'SMS sent successfully', 'gravity-forms-sms' ),
				'response' => $result,
			];
			return $response;

		} catch ( Exception $e ) {
			$response = [
				'message'  => __( 'The message failed with status:', 'gravity-forms-sms' ) . $e->getMessage(),
				'response' => $e,
			];
			return $response;
		}
	}
}
