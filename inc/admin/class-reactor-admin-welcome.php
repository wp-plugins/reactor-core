<?php
/**
 * Welcome Page Class
 *
 * Shows a feature overview for the new version (major) and credits.
 *
 * Adapted from code in EDD (Copyright (c) 2012, Pippin Williamson) and WP.
 *
 * @author 		Reactor
 * @category 	Admin
 * @package 	Reactor/Admin
 * @version     0.0.2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Reactor_Admin_Welcome class.
 */
class Reactor_Admin_Welcome {

	private $plugin;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->plugin             = 'reactor-core/reactor-core.php';
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
	}

	/**
	 * Add admin menus/screens
	 *
	 * @access public
	 * @return void
	 */
	public function admin_menus() {
		if ( empty( $_GET['page'] ) ) {
			return;
		}

		$welcome_page_name  = __( 'About reactor', 'reactor' );
		$welcome_page_title = __( 'Welcome to reactor', 'reactor' );

		switch ( $_GET['page'] ) {
			case 'reactor-about' :
				$page = add_dashboard_page( $welcome_page_title, $welcome_page_name, 'manage_options', 'reactor-about', array( $this, 'about_screen' ) );
				add_action( 'admin_print_styles-'. $page, array( $this, 'admin_css' ) );
			break;
		}
	}

	/**
	 * admin_css function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_css() {
		wp_enqueue_style( 'reactor-activation', plugins_url(  '/inc/admin/css/activation.css', REACTOR_PLUGIN_PATH ), array(), REACTOR_CORE_VERSION );
	}

	/**
	 * Add styles just for this page, and remove dashboard page links.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'reactor-about' );
		?>
		<style type="text/css">
			/*<![CDATA[*/

			.reactor-badge {
				position: relative;
				background: #464646;
				background-image: url( <?php echo plugins_url(  '/inc/admin/css/badge.jpg', REACTOR_PLUGIN_PATH ) ?> );
				text-rendering: optimizeLegibility;
				padding-top: 150px;
				height: 52px;
				width: 165px;
				font-weight: 600;
				font-size: 14px;
				text-align: center;
				color: #ffffff;
				margin: 5px 0 0 0;
				-webkit-box-shadow: 0 1px 3px rgba(0,0,0,.2);
				box-shadow: 0 1px 3px rgba(0,0,0,.2);
				border-radius: 5px;
			}
			.about-wrap .reactor-badge {
				position: absolute;
				top: 0;
				<?php echo is_rtl() ? 'left' : 'right'; ?>: 0;
			}
			.about-wrap .reactor-feature {
				overflow: visible !important;
				*zoom:1;
			}
			.about-wrap h3 + .reactor-feature {
				margin-top: 0;
			}
			.about-wrap .reactor-feature:before,
			.about-wrap .reactor-feature:after {
				content: " ";
				display: table;
			}
			.about-wrap .reactor-feature:after {
				clear: both;
			}
			.about-wrap .feature-rest div {
				width: 50% !important;
				padding-<?php echo is_rtl() ? 'left' : 'right'; ?>: 100px;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				margin: 0 !important;
			}
			.about-wrap .feature-rest div.last-feature {
				padding-<?php echo is_rtl() ? 'right' : 'left'; ?>: 100px;
				padding-<?php echo is_rtl() ? 'left' : 'right'; ?>: 0;
			}
			.about-wrap div.icon {
				width: 0 !important;
				padding: 0;
				margin: 0;
			}
			.about-wrap .feature-rest div.icon:before {
				font-family: reactor !important;
				font-weight: normal;
				width: 100%;
				font-size: 170px;
				line-height: 125px;
				color: #9c5d90;
				display: inline-block;
				position: relative;
				text-align: center;
				speak: none;
				margin: <?php echo is_rtl() ? '0 -100px 0 0' : '0 0 0 -100px'; ?>;
				content: "\e01d";
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}
			.about-integrations {
				background: #fff;
				margin: 20px 0;
				padding: 1px 20px 10px;
			}
			.changelog h4 {
				line-height: 1.4;
			}
			.reactor-conf {
				background-color: #3c3c3c;
				background-size: cover;
				padding: 11px 30px 20px;
				color: #fff;
				border-radius: 4px;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}
			.reactor-conf h3 {
				color: #fff;
			}
			.reactor-conf div {
				width: 50%;
			}
			/*]]>*/
		</style>
		<?php
	}

	/**
	 * Into text/links shown on all about pages.
	 *
	 * @access private
	 * @return void
	 */
	private function intro() {

		?>
		<h1><?php _e( 'Reactor: Core', 'reactor' ); ?></h1>

		<div class="about-text reactor-about-text">
			<?php
				if ( ! empty( $_GET['reactor-installed'] ) )
					$message = __( 'Your site is now connected to Reactor!', 'reactor' );
				elseif ( ! empty( $_GET['reactor-updated'] ) )
					$message = __( 'Thank you for updating to the latest version!', 'reactor' );
				else
					$message = __( 'Thanks for installing!', 'reactor' );

				printf( __( '%s', 'reactor' ), $message, REACTOR_CORE_VERSION );
			?>
		</div>

		<div class="reactor-badge"><?php printf( __( 'Version %s', 'reactor' ), REACTOR_CORE_VERSION ); ?></div>

		<p class="reactor-actions">
			<a href="<?php echo esc_url( apply_filters( 'reactor_docs_url', 'http://reactor.helpscoutdocs.com', 'reactor' ) ); ?>" target="_blank" class="docs button button-primary"><?php _e( 'Docs', 'reactor' ); ?></a>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://reactor.apppresser.com" data-text="Build a mobile app for your WordPress based businesses." data-via="AppPresser" data-size="large" data-hashtags="reactor #wordpress">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</p>

		<?php
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<!--<div class="changelog point-releases"></div>-->

			<div class="changelog">
				<div class="reactor-feature feature-rest feature-section col three-col">
					<div>
						<h4><?php _e( 'Getting Started', 'reactor' ); ?></h4>
						<p><?php _e( 'You are ready to start building your app. <a href="http://reactor.apppresser.com/login/" target="_blank">Login here</a> if you already have an account, otherwise you can <a href="http://reactor.apppresser.com/pricing/" target="_blank">sign up here</a>.', 'reactor' ); ?></p>
					</div>
					<div class="last-feature">
						<h4><?php _e( 'Help and Documentation', 'reactor' ); ?></h4>
						<p><?php _e( 'You will find help videos when you <a href="http://reactor.apppresser.com/login/" target="_blank">login to your account</a>, or you can find our <a href="http://reactor.helpscoutdocs.com" target="_blank">documentation here</a>.', 'reactor' ); ?></p>
					</div>
				</div>
			</div>
			<div class="changelog about-integrations">
				<h3><?php _e( 'About Reactor', 'reactor' ); ?></h3>
				<div class="reactor-feature feature-section col three-col">
					<div>
						<img src="<?php echo plugins_url(  '../images/apps-300.png', __FILE__ ); ?>">
						<h4><?php _e( 'Create fast, beautiful apps', 'reactor' ); ?></h4>
						<p><?php _e( 'Performance and features you will love', 'reactor' ); ?></p>
					</div>
					<div>
						<img src="<?php echo plugins_url(  '../images/integrate-wp-300.png', __FILE__ ); ?>">
						<h4><?php _e( 'Integrate your WordPress content with ease', 'reactor' ); ?></h4>
						<p><?php _e( 'Add WordPress posts, pages, products, media and more', 'reactor' ); ?></p>
					</div>
					<div class="last-feature">
						<img src="<?php echo plugins_url(  '../images/push-300.png', __FILE__ ); ?>">
						<h4><?php _e( 'Push Notifications, Social Sharing, Stats, and more', 'reactor' ); ?></h4>
						<p><?php _e( 'Everything you need to make a great mobile app', 'reactor' ); ?></p>
					</div>
				</div>
			</div>

			<?php if ( strtotime( '2014/11/04' ) > current_time( 'timestamp' ) ) { ?>
			<div class="changelog reactor-conf">
				<div>
						<h3><?php _e( 'Title', 'reactor' ); ?></h3>
						<p><?php _e( 'Blah blah text', 'reactor' ); ?></p>
				</div>
			</div>
			<?php } ?>

		</div>
		<?php
	}

}

new Reactor_Admin_Welcome();
