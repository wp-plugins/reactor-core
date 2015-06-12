<?php
/**
 * Reactor Woo API
 *
 * Adds woo meta to Product CPT
 *
 * @package AppPresser Reactor
 * @subpackage WP API
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 */

 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists('Reactor_Woo_API')) {

	class Reactor_Woo_API {

		public static $instance = null;

		public static function run() {
			if ( self::$instance === null )
				self::$instance = new self();
			return self::$instance;
		}

		/**
		 * Let's start Pressin' data!
		 * @since 1.0.0
		 */
		public function __construct() {
			// filters json posts data and adds extra meta
			add_filter( 'json_prepare_post', array( $this, 'product_meta' ), 10, 3 );
		}


		/**
		 * product_meta function.
		 *
		 * @access public
		 * @param mixed $post_response
		 * @param mixed $post
		 * @param mixed $context
		 * @return JSON
		 */
		public function product_meta( $post_response, $post, $context ) {
			global $woocommerce;

			if ( 'product' == get_post_type( $post['ID'] ) ) {


			    $meta = get_post_meta( $post['ID'] );
			    $product_attributes = unserialize( $meta['_product_attributes'][0] );
			    $product_image_id = explode( ',', $meta['_product_image_gallery'][0] );
			    $variation_data = array();
			    $items = array();


			    $args = array(
                     'post_type'     => 'product_variation',
                     'post_status'   => array( 'private', 'publish' ),
                     'numberposts'   => -1,
                     'orderby'       => 'menu_order',
                     'order'         => 'asc',
                     'post_parent'   => $post['ID']
                );
                $variations = get_posts( $args );
				
				if( $variations ) {

	                foreach( $variations as $variation ) {
	
		                foreach( $product_attributes as $attr => $value ){
			                $terms[$attr] = get_the_terms( $post['ID'], $attr );
		                }
	
						$arry['ID'] = absint( $variation->ID );
						$arry['variation'] = get_post_meta( $variation->ID );
	
						$variation_data['terms'] = $terms;
						$variation_data['items'][] = $arry;
	
				    }
			    
			    }
				
				if( $product_image_id ) {

				    foreach( $product_image_id as $item ) {
					    $img_src = wp_get_attachment_image_src( $item, 'medium' );
					    $items[]['url'] = $img_src[0];
				    }
				    
			    }

			    $product_images['images'] = $items;

			    $product_meta = array(
				   'price' =>  $meta['_regular_price'][0],
				   'sale_price' =>  $meta['_sale_price'][0],
				   'stock_status' =>  $meta['_stock_status'][0],
				   'sku' =>  $meta['_sku'][0],
				   'purchase_note' =>  $meta['_purchase_note'][0],
				   'image_gallery' => $product_images,
				   'attributes' =>  $product_attributes,
				   'variations' =>  $variation_data,
				   'currency_symbol' => get_woocommerce_currency_symbol(),
				   'checkout_url' => $woocommerce->cart->get_checkout_url(),
				   'cart_url' => $woocommerce->cart->get_cart_url()

			    );

			    $post_response['meta_fields']['woo'] = $product_meta;
		    }

		    return $post_response;
		}


	}
}
Reactor_Woo_API::run();


function woo_api_add_to_cart() {
	global $product;
	reactor_get_template('/templates/woo/add-to-cart/' . $product->product_type . '.php');
}


function woo_cart_messages( $message ) {
	global $woocommerce;

	if ( isset( $_GET['appp'] ) && $_GET['appp'] === 'woo'  ) {

		$replacemessage = ' ';

		$message = preg_replace('/\<a([^>]*)\>([^<]*)\<\/a\>/i', $replacemessage, $message);

	}

	return $message;

}
add_filter( 'wc_add_to_cart_message', 'woo_cart_messages');