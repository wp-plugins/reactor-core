<?php
// adds image sizes to be used in app
if ( function_exists ('add_image_size') ) {
	function reactor_image_sizes() {
		add_image_size( 'reactor-320', 320 );
		add_image_size( 'reactor-640', 640 );
		add_image_size( 'reactor-1280', 1280 );
	}
	add_action( 'init', 'reactor_image_sizes' );
}