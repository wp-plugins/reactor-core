<?php
/*
Plugin Name: Reactor: Core
Plugin URI: http://reactor.apppresser.com
Description: Core plugin for Reactor App Builder.
Text Domain: reactor
Version: 0.2.2
Author: Reactor Team
Author URI: http://reactor.apppresser.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( 'REACTOR_CORE_VERSION', '0.2.2' );
define( 'REACTOR_API_VERSION', 'v1' );
define( 'REACTOR_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'REACTOR_PLUGIN_URL', trailingslashit( plugins_url( null , __FILE__ ) ) );

class Reactor_Core {

	const VERSION = '0.2.2';
	public static $instance = null;
	public static $dir_path;
	public static $dir_url;
	public static $api_url;
	public static $this_plugin = null;
	public static $plugin_slug = 'reactor_core';
	public static $plugin_name = 'Reactor Core';

	/**
	 * Creates or returns an instance of this class.
	 * @since 1.0.0
	 * @return AppPresser A single instance of this class.
	 */
	public static function get() {
		if ( self::$instance === null )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * Let's start Pressin' Apps!
	 * @since 1.0.0
	 */
	function __construct() {

		self::$this_plugin = plugin_basename( __FILE__ );

		// Define plugin constants
		self::$dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		self::$dir_url = trailingslashit( plugins_url( null , __FILE__ ) );
		self::$api_url = trailingslashit( home_url() . '/wp-json/reactor/v1' );

		include_once( self::$dir_path . 'inc/admin/class-reactor-admin-welcome.php' );

		add_action( 'admin_init', array( $this, 'welcome_redirect' ) );

		// is WP-API plugin active? If not load the api
		if ( !in_array( 'json-rest-api/plugin.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			include_once( self::$dir_path . 'json-rest-api/plugin.php' );
		} else {
			deactivate_plugins('json-rest-api/plugin.php');
		}

		// reactor api
		include_once( self::$dir_path . 'inc/api/' . REACTOR_API_VERSION . '/AppPresser_Reactor_Template_Override.php' );
		include_once( self::$dir_path . 'inc/api/' . REACTOR_API_VERSION . '/AppPresser_Reactor_Media_API.php' );
		include_once( self::$dir_path . 'inc/api/' . REACTOR_API_VERSION . '/AppPresser_Reactor_Ajax.php' );
		include_once( self::$dir_path . 'inc/media/media-uploader.php' );
		include_once( self::$dir_path . 'inc/media/media-sizes.php' );


		// if Woo is active add api endpoints
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			include_once( self::$dir_path . 'inc/api/' . REACTOR_API_VERSION . '/AppPresser_Reactor_Woo_Api.php' );
		}



	}

	/**
	 * api_required function.
	 *
	 * @access public
	 *
	 */
	public function api_required() {
		echo '<div id="message" class="error"><p>'. sprintf( __( '%1$s requires the WP-API plugin to be installed/activated.', 'reactor' ), self::$plugin_name ) .'</p></div>';
	}


	/**
	 * install function.
	 *
	 * @access public
	 * @return void
	 */
	public function install() {
		set_transient( 'reactor_activate', true, 0 );
	}


	/**
	 * welcome_redirect function.
	 *
	 * @access public
	 * @return void
	 */
	public function welcome_redirect() {
		if ( is_admin() && get_transient( 'reactor_activate' ) === '1' ) {
			delete_transient( 'reactor_activate' );
			// TODO: fill in welcome page content
			wp_redirect( admin_url( 'index.php?page=reactor-about&reactor-installed=true' ) );
			exit;
		}
	}

}

Reactor_Core::get();


register_activation_hook( __FILE__, array( 'Reactor_Core', 'install' ) );
