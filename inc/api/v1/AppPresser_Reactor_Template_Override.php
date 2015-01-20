<?php

function reactor_process_query( $template ) {
	global $wp;


	if ( isset( $_GET['appp'] ) && $_GET['appp'] === 'woo'  ) {
		add_filter('show_admin_bar', '__return_false');
  		$template  = REACTOR_PLUGIN_PATH . '/inc/api/v1/templates/woo/add-to-cart.php';
  	}

	if ( isset( $_GET['appp'] ) && $_GET['appp'] === 'gform'  ) {
		add_filter('show_admin_bar', '__return_false');
  		$template  = REACTOR_PLUGIN_PATH . '/inc/api/v1/templates/gravity-forms/form.php';
  	}

	if ( isset( $_GET['appp'] ) && $_GET['appp'] === 'login'  ) {
		add_filter('show_admin_bar', '__return_false');
  		$template  = REACTOR_PLUGIN_PATH . '/inc/api/v1/templates/reactor/login.php';
  	}

  	return  $template ;

}
add_filter( 'template_include', 'reactor_process_query', 0 );




function reactor_get_stylesheet() {
	echo '<link href="' . REACTOR_PLUGIN_URL . 'inc/api/v1/css/ionic.min.css" rel="stylesheet">';
}


function reactor_get_template( $slug ) {
	load_template( dirname( __FILE__ ) . $slug );
}