<?php
/*
 * Plugin Name: FB Like & Share button for Jetpack
 * Plugin URI: http://wordpress.org/plugins/jetpack/
 * Description: Add a FB Like & Share button to the Jetpack Sharing module.
 * Author: Jeremy Herve
 * Version: 1.0
 * Author URI: http://jeremy.hu
 * License: GPL2+
 * Text Domain: jeherve_fb_like_jetpack
 */

class Fb_Like_Share_Button {
	private static $instance;

	static function get_instance() {
		if ( ! self::$instance )
			self::$instance = new Fb_Like_Share_Button;

		return self::$instance;
	}

	private function __construct() {
		// Check if Jetpack and the sharing module is active.
		if ( class_exists( 'Jetpack' ) && Jetpack::init()->is_module_active( 'sharedaddy' ) ) {
			add_action( 'plugins_loaded', array( $this, 'setup' ) );
		} else {
			add_action( 'admin_notices',  array( $this, 'install_jetpack' ) );
		}
	}

	public function setup() {
		add_filter( 'sharing_services', array( $this, 'inject_service' ) );
	}

	// Add the Like Button to the list of services in Sharedaddy
	public function inject_service ( $services ) {
		include_once 'class.like-share-facebook.php';
		if ( class_exists( 'Fb_Like_Share' ) ) {
			$services['fb-like-share'] = 'Fb_Like_Share';
		}
		return $services;
	}

	// Prompt to install Jetpack
	public function install_jetpack() {
		echo '<div class="error"><p>';
		printf( __( 'To use the FB Like & Share button for Jetpack, you\'ll need to install and activate <a href="%1$s">Jetpack</a> first, and <a href="%2$s">activate the Sharing module</a>.', 'jeherve_fb_like_jetpack' ),
		'plugin-install.php?tab=search&s=jetpack&plugin-search-input=Search+Plugins',
		'admin.php?page=jetpack_modules'
		);
		echo '</p></div>';
	}
}
// And boom.
Fb_Like_Share_Button::get_instance();
