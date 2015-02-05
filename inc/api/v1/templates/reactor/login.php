<!DOCTYPE html>
<html>
	<head>
		<?php get_app_stylesheet(); ?>

		<?php wp_head(); ?>

		<style>
		html {
			margin-top: 0px !important;
		}
		.list-inset {
			background-color: transparent !important;
		}
		.login-form {
			padding: 10px;
		}
		.status {
			text-align: center;
		}
		#loginform input[type="submit"], .login-form button {
			box-shadow: none;
			background-image: none;
			background-color: #dadada;
			border-color: #d7d7d7;
		}
		</style>

		<script>
			function init() {
				window.parent.postMessage( {message: 'login'}, '*' );

				jQuery("#scrollWrap").scrollTop( 0,0 );
			}

		(function( $ ) {
		    "use strict";

		    $(function() {

			    $('form#loginform').on('submit', function(e){
			        $('p.status').show().text('Logging in....');
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: ajaxurl,
			            data: {
			                'action': 'reactor_app_login',
			                'username': $('form#loginform #username').val(),
			                'password': $('form#loginform #password').val(),
			                'security': $('form#loginform #security').val()
			            },
			            success: function(data){
			            	console.log(data);
			                if (data.success == true){
			                    document.location.href = '/?appp=login';
			                } else {
				                $('p.status').show().text('Error Logging in.');
			                }
			            }
			        });
			        e.preventDefault();
			    });


		    });

		}(jQuery));

		</script>
	</head>
	<body onLoad="init()">
		<div id="scrollWrap" style="position: fixed; right: 0; bottom: 0; left: 0;top: 0;-webkit-overflow-scrolling: touch;overflow-y: scroll;">

			<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

			<?php if ( is_user_logged_in() ) : ?>

				<?php global $current_user; get_currentuserinfo(); ?>

				<div class="login-form">

					<div><?php _e('Logged In as:', 'reactor'); ?> <?php echo $current_user->user_login ?></div>



					<button onclick="window.location.href='<?php echo wp_logout_url( '/?appp=login' ); ?>'" class="button button-block button-small button-reactor">
							<?php _e('Logout', 'reactor'); ?>
					</button>

				</div>

			<?php else : ?>

			<div class="list list-inset">
				<form name="loginform" id="loginform" method="post" autocomplete = "off" autocomplete="off">


					<label class="item item-input">
						<input type="text" name="log" id="username" placeholder="Username" />
					</label>
					<label class="item item-input">
						<input type="password" name="pwd" id="password" placeholder="Password" />
					</label>

					<input type="submit" name="wp-submit" id="wp-submit" class="button button-block button-small button-reactor" value="Log In" />
					<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>

				</form>
			</div>

			<p class="status"></p>

			<?php endif; ?>

			<?php wp_footer(); ?>

		</div>
	</body>
</html>
