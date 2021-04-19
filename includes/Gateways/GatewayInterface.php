<?php
/**
 * GatewayInterface Interface
 *
 * Manage  Getway related functionality on Wp Form
 *
 * @package ChiliDevs\GravityFormsSms
 */

declare(strict_types=1);

namespace ChiliDevs\GravityFormsSms\Gateways;

use WP_Error;

/**
 * GatewayInterface Interface.
 *
 * @package ChiliDevs\GravityFormsSms\Gateways
 */
interface GatewayInterface {
	/**
	 * Send SMS via gateways
	 *
	 * @param array $form_data Hold form data.
	 * @param array $options Keep all gateway settings.
	 *
	 * @return array
	 */
	public function send( $form_data, $options );
}
