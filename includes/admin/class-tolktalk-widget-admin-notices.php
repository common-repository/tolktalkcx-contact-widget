<?php
/**
 * The tolktalkCX_Widget_Admin_Notices class.
 *
 * @package tolktalkCX_Widget/Admin
 * @author  tolktalk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

	/**
	 * Admin notices.
	 *
	 * Handles admin notices.
	 *
	 * @since 1.0.0
	 */
	class tolktalkCX_Widget_Admin_Notices {
		/**
		 * Notices array.
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * The constructor.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'tolktalkCX_admin_notices' ) );
			add_action( 'wp_loaded', array( $this, 'tolktalkCX_hide_notices' ) );
		}

		/**
		 * Adds slug keyed notices (to avoid duplication).
		 *
		 * @since 1.0.0
		 *
		 * @param string $slug        Notice slug.
		 * @param string $class       CSS class.
		 * @param string $message     Notice body.
		 * @param bool   $dismissible Optional. Allow/disallow dismissing the notice. Default false.
		 *
		 * @return void
		 */
		public function tolktalkCX_add_admin_notice( $slug, $class, $message, $dismissible = false ) {
			$this->notices[ $slug ] = array(
				'class'       => $class,
				'message'     => $message,
				'dismissible' => $dismissible,
			);
		}

		/**
		 * Displays the notices.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function tolktalkCX_admin_notices() {
			// Exit if user has no privilges.
			if ( ! current_user_can( 'administrator' ) ) {
				return;
			}

			// Basic checks.
			$this->tolktalkCX_check_environment();

			// Display the notices collected so far.
			foreach ( (array) $this->notices as $notice_key => $notice ) {
				echo '<div class="' . esc_attr( $notice['class'] ) . '" style="position:relative;">';

				if ( $notice['dismissible'] ) {
					echo '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'tolktalk-widget-hide-notice', $notice_key ), 'tolktalk-widget_hide_notices_nonce', '_tolktalk-widget_notice_nonce' ) ) . '" class="woocommerce-message-close notice-dismiss" style="position:absolute;right:1px;padding:9px;text-decoration:none;"></a>';
				}

				echo '<p>' . wp_kses( $notice['message'], array( 'a' => array( 'href' => array() ) ) ) . '</p>';

				echo '</div>';
			}
		}

		/**
		 * Handles all the basic checks.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function tolktalkCX_check_environment() {
			$show_phpver_notice = get_option( 'tolktalk-widget_show_phpver_notice' );
			$show_wpver_notice  = get_option( 'tolktalk-widget_show_wpver_notice' );

			if ( empty( $show_phpver_notice ) ) {
				if ( version_compare( phpversion(), TOLKTALKCX_WIDGET_MIN_PHP_VER, '<' ) ) {
					/* translators: 1) int version 2) int version */
					$message = __( 'tolktalk Widget - The minimum PHP version required for this plugin is %1$s. You are running %2$s.', 'tolktalk-widget' );
					$this->tolktalkCX_add_admin_notice( 'phpver', 'error', sprintf( $message, TOLKTALKCX_WIDGET_MIN_PHP_VER, phpversion() ), true );
				}
			}

			if ( empty( $show_wpver_notice ) ) {
				global $wp_version;

				if ( version_compare( $wp_version, TOLKTALKCX_WIDGET_MIN_WP_VER, '<' ) ) {
					/* translators: 1) int version 2) int version */
					$message = __( 'tolktalk Widget - The minimum WordPress version required for this plugin is %1$s. You are running %2$s.', 'tolktalk-widget' );
					$this->tolktalkCX_add_admin_notice( 'wpver', 'notice notice-warning', sprintf( $message, TOLKTALKCX_WIDGET_MIN_WP_VER, WC_VERSION ), true );
				}
			}

		}

		/**
		 * Hides any admin notices.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function tolktalkCX_hide_notices() {
			if ( isset( $_GET['tolktalk-widget-hide-notice'] ) && isset( $_GET['_tolktalk-widget_notice_nonce'] ) ) {
				if ( ! wp_verify_nonce( $_GET['_tolktalk-widget_notice_nonce'], 'tolktalk-widget_hide_notices_nonce' ) ) {
					wp_die( __( 'Action failed. Please refresh the page and retry.', 'tolktalk-widget' ) );
				}

				if ( ! current_user_can( 'administrator' ) ) {
					wp_die( __( 'Cheatin&#8217; huh?', 'tolktalk-widget' ) );
				}

				$notice = wc_clean( $_GET['tolktalk-widget-hide-notice'] );

				switch ( $notice ) {
					case 'phpver' :
						update_option( 'tolktalk-widget_show_phpver_notice', 'no' );
						break;
					case 'wpver' :
						update_option( 'tolktalk-widget_show_wpver_notice', 'no' );
						break;
				}
			}
		}
	}

	new tolktalkCX_Widget_Admin_Notices();
