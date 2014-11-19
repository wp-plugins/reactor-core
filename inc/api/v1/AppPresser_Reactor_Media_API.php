<?php
/**
 * Reactor Media API
 *
 * @package AppPresser Reactor
 * @subpackage WP API
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 */

 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists('Reactor_Media_API')) {


	/**
	 * reactor_api_init function.
	 *
	 * @access public
	 * @return void
	 */
	function reactor_media_api_init() {
		global $api;

		$api = new Reactor_Media_API();
		add_filter( 'json_endpoints', array( $api, 'register_routes' ) );
	}
	add_action( 'wp_json_server_before_serve', 'reactor_media_api_init' );



	class Reactor_Media_API {


		/**
		 * register_routes function.
		 *
		 * @access public
		 * @param mixed $routes
		 * @return $routes
		 */
		public function register_routes( $routes ) {
			$routes['/reactor/media'] = array(
				array( array( $this, 'get_all_media'), WP_JSON_Server::READABLE )
			);
			$routes['/reactor/media/(?P<id>\d+)'] = array(
				array( array( $this, 'get_media'), WP_JSON_Server::READABLE )
			);
			$routes['/reactor/media/upload'] = array(
				array( array( $this, 'add_media'), WP_JSON_Server::READABLE )
			);
			return $routes;
		}



		/**
		 * get_all_media function.
		 *
		 * @access public
		 * @param mixed $id
		 * @return $media
		 */
		public function get_all_media() {

			$filter = isset( $_GET['filter'] ) ? $_GET['filter'] : '';

			// get attachments aka media uploads
			$args = array(
				   'post_type' => 'attachment',
				   'post_status' => null,
				   'numberposts' => -1
			);
			$media = get_posts( $args );


			if( !is_wp_error($media) ) {

				//loop through and remove anything not an image file
				foreach ( $media as $key => $post) {

					if ( $media[$key]->post_mime_type !== 'image/png' && $media[$key]->post_mime_type !== 'image/jpeg' && $media[$key]->post_mime_type !== 'image/gif' ) {
						unset( $media[$key] );
					}

				}
				$media = array_values( $media );

				// loop through and get the meta for each image file and attach it to array
				foreach ( $media as $key => $post) {

					$media[$key]->taxonomy = get_post_meta( $media[$key]->ID, "_app_image_category", true );
					$media[$key]->meta = wp_get_attachment_metadata( $media[$key]->ID );
					$img_url_basename = wp_basename( $media[$key]->guid );

					if( !empty( $media[$key]->meta['sizes'] ) ) {

						foreach ( $media[$key]->meta['sizes'] as $size => &$size_data ) {
							$size_data['url'] = str_replace( $img_url_basename, $size_data['file'], $media[$key]->guid );
						}

					}

				}

				// filter out anything
				if( isset( $_GET['filter'] ) ) {
					foreach ( $media as $key => $post) {

						if ( $media[$key]->taxonomy !== $filter ) {
							unset( $media[$key] );
						}

					}
					$media = array_values( $media );
				}
				
			} else {
			
				$media = 'no media';
			}
			
			$response   = new WP_JSON_Response();
			$response->header( 'Content-Type', 'application/javascript' );
			$response->set_data( $media );
			return $response;

		}

		/**
		 * get_media function.
		 *
		 * @access public
		 * @param mixed $id
		 * @return $media
		 */
		public function get_media( $id ) {

			$args = array(
				   'post_type' => 'attachment',
				   'include' => $id,
				   'numberposts' => 1,
				   'post_status' => null
			);
			$media = get_posts( $args );
			
			if( !is_wp_error($media) ) {

				// loop through and get the meta for each image file and attach it to array
				foreach ( $media as $key => $post) {
	
					$media[$key]->taxonomy = get_post_meta(	 $media[$key]->ID, "_app_image_category", true );;
					$media[$key]->meta = wp_get_attachment_metadata( $media[$key]->ID );
					$img_url_basename = wp_basename( $media[$key]->guid );

					if( !empty( $media[$key]->meta['sizes'] ) ) {

						foreach ( $media[$key]->meta['sizes'] as $size => &$size_data ) {
							$size_data['url'] = str_replace( $img_url_basename, $size_data['file'], $media[$key]->guid );
						}
					
					}
	
				}
				
			
			} else {
			
				$media = 'no media';
			}
			
			$response   = new WP_JSON_Response();
			$response->header( 'Content-Type', 'application/javascript' );
			$response->set_data( $media );
			return $response;
			
		}

		/**
		 * add_media function.
		 *
		 * @access public
		 * @param mixed $id
		 * @return $media
		 */
		public function add_media() {

			$media = $_GET['file'];

			header('Content-Type: application/javascript');
			return $media;
		}

	}
}
