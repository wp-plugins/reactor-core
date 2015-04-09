<!DOCTYPE html>
<html>
	<head>
		<?php reactor_get_stylesheet(); ?>

		<?php wp_head(); ?>

		<style>
		html {
			margin-top: 0px !important;
		}
		#reactor-add-to-cart .quantity.buttons_added {
			margin: 0 0 10px 0;
		}
		#reactor-add-to-cart input.input-text.qty.text {
			max-width: 58%;
			display: inline;
			padding: 10px;
			-webkit-appearance: none;
			border: 1px solid #efefef;
		}

		#reactor-add-to-cart input[type=number]::-webkit-inner-spin-button,
		#reactor-add-to-cart input[type=number]::-webkit-outer-spin-button {
		  -webkit-appearance: none;
		  margin: 0;
		}

		#reactor-add-to-cart .variations {
			margin: 0 0 10px 0;
		}

		#reactor-add-to-cart .variations label {
			margin: 0 10px 0 0;
		}

		#reactor-add-to-cart .variations select {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			padding: 5px 28px 5px 5px;
			max-width: 65%;
			border: 1px solid #efefef ;
			background: #fff;
			color: #333;
			text-indent: 0.01px;
			text-overflow: '';
			white-space: nowrap;
			font-size: 14px;
			cursor: pointer;
		}

		.reactor-woo-message .woocommerce-message {
			margin: 0 0 10px 0 !important;
			padding: 4px !important;
			-webkit-border-radius: 3px !important;
			background-color: rgba(0,0,0,0.1) !important;
			-webkit-box-shadow: none !important;
			box-shadow: none !important;
			background-image: none !important;
			border: none !important;
			text-shadow: none !important;
		}

		.reactor-woo-message .woocommerce-message:before, .reactor-woo-message .woocommerce-error:before, .reactor-woo-message .woocommerce-info:before {
			content: '';
			display: none !important;
		}

		#reactor-add-to-cart input[type="button"] {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			background-image: none;
			box-shadow: none;
			padding: 9px 12px !important;
		}
		</style>

	</head>
	<body>

	<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	 ?>

	 		<?php $product_id = $_GET['product_id']; ?>

	 		<?php if(!$product_id) return; ?>

			<?php $loop = new WP_Query( array( 'post_type' => 'product', 'p' => $product_id ) ); ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<div class="reactor-woo-message">

			<?php
				/**
				 * woocommerce_before_single_product hook
				 *
				 * @hooked wc_print_notices - 10
				 */
				 do_action( 'woocommerce_before_single_product' );

				 if ( post_password_required() ) {
				 	echo get_the_password_form();
				 	return;
				 }
			?>

			</div>

			<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>


				<div id="reactor-add-to-cart" class="summary entry-summary">

					<?php //woo_api_add_to_cart();
							woocommerce_template_single_add_to_cart(); ?>

				</div><!-- .summary -->

			</div>


			<?php endwhile; // end of the loop. ?>

	<?php wp_footer(); ?>
	</body>
</html>