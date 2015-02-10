<!DOCTYPE html>
<html>
	<head>
		<?php get_app_stylesheet(); ?>

		<?php wp_head(); ?>

		<script>
		
			var login = function(event) {
							
				if( event.data.username === null || event.data.password === null ) return;
				
				(function($) {
				
			        $.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: ajaxurl,
			            data: {
			                'action': 'reactor_app_login',
			                'username': event.data.username,
			                'password': event.data.password
			            },
			            success: function(data){
			            	console.log(data);
			                if (data.success == true){
			                    window.parent.postMessage( {
			                    	message: 'Logged In!',
			                     	loggedin: true,
			                     	user: data.data.user,
			                     	token: data.data.token
			                    }, '*' );
			                } else {
				               	window.parent.postMessage( {
			                     	message: 'Error Logging In!',
			                     	loggedin: false
			                    }, '*' ); 
			                }
			            }
			            
			        });
		        

		        }(jQuery));
	        }


		
			function init() {
			
				window.addEventListener('message', function(event) {
			
				    if( event.data.message === 'login' ) {
					   login(event);
					}
			
				});
			
			}



		</script>
	</head>
	<body onLoad="init()"></body>
</html>
