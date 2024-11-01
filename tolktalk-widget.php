<?php
/**
 * Plugin Name: tolktalkCX Contact Widget
 * Plugin URI:
 * Description: Converts any static contact us page into a dynamic call-center like experience, by allowing your website visitors to conveniently connect with your business from any page using the pop-up contact us button.
 * Version: 1.0.1
 * Author: tolktalk
 * Author URI: https://tolktalk.com/
 * Requires at least: 4.4.0
 * Tested up to: 5.7
 *
 * Text Domain: 'tolktalk-widget'
 * Domain Path: /languages/
 *
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package tolktalkCX_Widget
 * @author  tolktalk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Globals constants.
 */
define( 'TOLKTALKCX_WIDGET_MIN_PHP_VER',   '5.6.0' );
define( 'TOLKTALKCX_WIDGET_MIN_WP_VER',    '4.4.0' );
define( 'TOLKTALKCX_WIDGET_VER',           '1.0.0' );
define( 'TOLKTALKCX_WIDGET_ROOT_URL',      plugin_dir_url( __FILE__ ) );
define( 'TOLKTALKCX_WIDGET_ROOT_PATH',     plugin_dir_path( __FILE__ ) );


	/**
	 * The main class.
	 *
	 * @since 1.0.0
	 */
	class tolktalkCX_Widget {

		/**
		 * The singelton instance of tolktalkCX_Widget.
		 *
		 * @since 1.0.0
		 *
		 * @var tolktalkCX_Widget
		 */
		private static $tolktalkCX_instance = null;

		/**
		 * Returns the singelton instance of tolktalkCX_Widget.
		 *
		 * Ensures only one instance of tolktalkCX_Widget is/can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @return tolktalkCX_Widget
		 */
		public static function tolktalkCX_get_instance() {
			if ( null === self::$tolktalkCX_instance ) {
				self::$tolktalkCX_instance = new self();
			}

			return self::$tolktalkCX_instance;
		}

		/**
		 * The constructor.
		 *
		 * Private constructor to make sure it can not be called directly from outside the class.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		private function __construct() {

			$this->tolktalkCX_includes();
			$this->tolktalkCX_hooks();

			/**
			 * The tolktalkCX_Widget_loaded hook.
			 *
			 * @since 1.0.0
			 */
			do_action( 'tolktalkCX_Widget_loaded' );
		}

		/**
		 * Includes the required files.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function tolktalkCX_includes() {
			// Global includes.
            include_once( TOLKTALKCX_WIDGET_ROOT_PATH . 'includes/class-tolktalk-widget.php' );
            // include_once( TOLKTALKCX_WIDGET_ROOT_PATH . 'settings.php' );

			if ( is_admin() ) {
				// Back-end only includes.
				include_once( TOLKTALKCX_WIDGET_ROOT_PATH . 'includes/admin/class-tolktalk-widget-admin-notices.php' );
			}
		}

		/**
		 * Plugin hooks.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function tolktalkCX_hooks() {
			// Actions
			add_action( 'widgets_init', array( $this, 'tolktalkCX_register_widget' ) );
		}

		/**
		 * Register custom widget.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function tolktalkCX_register_widget() {
			register_widget( 'tolktalkCXWP_Widget' );
		}

		/**
		 * On plugin activation.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public static function tolktalkCX_activate() {
			// Nothing To Do for Now.
		}

		/**
		 * On plugin deactivation.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public static function tolktalkCX_deactivate() {
			// Nothing To Do for Now.
		}

		/**
		 * On plugin uninstall.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public static function tolktalkCX_uninstall() {
			include_once( TOLKTALKCX_WIDGET_ROOT_PATH . 'uninstall.php' );
		}
	}


/**
 * The main instance of tolktalkCX_Widget.
 *
 * Returns the main instance of tolktalkCX_Widget.
 *
 * @since 1.0.0
 *
 * @return tolktalkCX_Widget
 */
function tolktalk_widget() {
	return tolktalkCX_Widget::tolktalkCX_get_instance();
}

// Global for backwards compatibility.
$GLOBALS['tolktalk_widget'] = tolktalk_widget();

register_activation_hook( __FILE__, array( 'tolktalkCX_Widget', 'tolktalkCX_activate' ) );
register_deactivation_hook( __FILE__, array( 'tolktalkCX_Widget', 'tolktalkCX_deactivate' ) );
register_uninstall_hook( __FILE__, array( 'tolktalkCX_Widget', 'tolktalkCX_uninstall' ) );
