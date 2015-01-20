<!DOCTYPE html>
<html>
	<head>
		<?php reactor_get_stylesheet(); ?>

		<?php wp_head(); ?>

		<style>
		html {
			margin-top: 0px !important;
		}
		
		#reactor-gravity-form input[type=text],
		#reactor-gravity-form input[type=textarea] {
			width: 100% !important;
		}
		
		#reactor-gravity-form input[type=text] {
			border: 1px solid #ccc;
		}
		</style>
		
		<script>
			function init() {
				window.parent.postMessage( {message: 'gform'}, '*' );
				
				jQuery("#scrollWrap").scrollTop( 0,0 );
			}
		</script>
	</head>
	<body onLoad="init()">
	
	<div id="scrollWrap" style="position: fixed; right: 0; bottom: 0; left: 0;top: 0;-webkit-overflow-scrolling: touch;overflow-y: scroll;">

		<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

		 <?php $form_id = $_GET['form_id']; ?>
	
		 <?php if(!$form_id) return; ?>
		 
		 <div id="reactor-gravity-form" style="padding: 10px;">
	
		 	<?php gravity_form($form_id, false, false, false, '', false); ?>
		 
		 </div>
	
		<?php wp_footer(); ?>
	
	</div>
	</body>
</html>
