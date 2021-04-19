<?php
/**
 * Main plugin class.
 *
 * @package ChiliDevs\GravityFormsSms
 * @since 1.0.0
 */

declare(strict_types=1);

namespace ChiliDevs\GravityFormsSms;

use ChiliDevs\GravityFormsSms\Admin\Admin;
use ChiliDevs\GravityFormsSms\Admin\FormSettings;

/**
 * Class Plugin.
 *
 * @package ChiliDevs\GravityFormsSms
 */
class Plugin {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Plugin directory path.
	 *
	 * @var string
	 */
	public $path;

	/**
	 * Plugin's url.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Assets directory path.
	 *
	 * @var string
	 */
	public $assets_dir;

	/**
	 * Fire the plugin initialization step.
	 *
	 * @return void
	 */
	public function run(): void {
		$this->path       = dirname( __FILE__, 2 );
		$this->url        = plugin_dir_url( trailingslashit( dirname( __FILE__, 2 ) ) . 'gravity-forms-sms.php' );
		$this->assets_dir = trailingslashit( $this->url ) . 'assets/';
		require_once $this->path . '/includes/Admin/functions.php';
		new Admin();
		new FormSettings();
	}

	/**
	 * Run the activator from installer
	 *
	 * @return void
	 */
	public function activator(): void {
        // phpcs:ignore;
		// register_activation_hook( dirname( __FILE__, 2 ) . '/gravity-forms-sms.php', [ Installer::class, 'activation' ] );
	}

	/**
	 * Run the deactivator from installer
	 *
	 * @return void
	 */
	public function deactivator(): void {
        // phpcs:ignore;
		// register_deactivation_hook( dirname( __FILE__, 2 ) . '/gravity-forms-sms.php', [ Installer::class, 'activation' ] );
	}
}
