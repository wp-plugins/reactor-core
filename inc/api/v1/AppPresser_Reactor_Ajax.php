<?php

function reactor_app_login() {
	global $wpdb;

	//check_ajax_referer( 'ajax-login-nonce', 'security' );

	$info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );

	if( is_wp_error( $user_signon ) ) {

		$return = array(
			'message' =>  __('The log in you have entered is not valid.', 'tm')
		);
		wp_send_json_error( $return );

	} else {
	
		$token = $user_signon->ID . '_' . md5( uniqid( rand(), true ) );
		update_user_meta( $user_signon->ID, 'reactor_token', $token );

		$return = array(
			'message' => __('Logged in.', 'tm'),
			'token' => $token,
			'user' => $user_signon->data->user_login
		);
		wp_send_json_success( $return );

	}

}
add_action('wp_ajax_nopriv_reactor_app_login', 'reactor_app_login');
add_action('wp_ajax_reactor_app_login', 'reactor_app_login');


function reactor_app_log_out() {
	global $wpdb;

	//check_ajax_referer( 'ajax-login-nonce', 'security' );

    $user_logout = wp_logout();

	if( is_wp_error( $user_logout ) ) {

		$return = array(
			'message' =>  __('Error logging out.', 'tm')
		);
		wp_send_json_error( $return );

	} else {

		$return = array(
			'message' => __('Logged Out.', 'tm')
		);
		wp_send_json_success( $return );

	}
}
add_action('wp_ajax_nopriv_reactor_app_logout', 'reactor_app_log_out');
add_action( 'wp_ajax_reactor_app_logout', 'reactor_app_log_out' );


function get_app_stylesheet() {
	echo '<link href="' . REACTOR_PLUGIN_URL . 'inc/api/v1/css/ionic.min.css" rel="stylesheet">';
	echo '<script type="text/javascript" src="'. get_site_url() .'/wp-includes/js/jquery/jquery.js?ver=1.7.1"></script>';

	echo '<script type="text/javascript">';
	echo 'var ajaxurl = "'. get_site_url() . '/wp-admin/admin-ajax.php"';
	echo ' </script>';
}
