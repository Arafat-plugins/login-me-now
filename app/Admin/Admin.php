<?php
/**
 * @author  Pluginly
 * @since   1.0
 * @version 1.9
 */

namespace LoginMeNow\Admin;

class Admin {
	public function __construct() {
		( new Ajax() );
		( new Enqueuer() );
		( new Menu() );
		( new Route() );
		( new Settings() );

		add_filter( 'admin_footer_text', [$this, 'admin_footer_link'], 99 );

		$this->init_appsero();
	}

	public function admin_footer_link() {
		if ( isset( $_GET['page'] ) && 'login-me-now' === $_GET['page'] ) {
			return '<span id="footer-thankyou"> Thank you for using <span class="focus:text-astra-hover active:text-astra-hover hover:text-lmn-hover"> ' . esc_attr( __( 'Login Me Now', 'login-me-now' ) ) . '.</span></span>';
		}
	}

	/**
	 * Initialize appsero tracking.
	 *
	 * Removed custom plugins meta data field in 7.0.5.4
	 * since Appsero made this builtin.
	 *
	 * @see https://github.com/Appsero/client
	 *
	 * @return void
	 */
	public function init_appsero() {
		$client = new \LoginMeNow\Admin\Appsero\Client(
			'2392dfad-bb20-4342-bab1-2b2cf6734e97',
			'Login Me Now',
			LOGIN_ME_NOW_FILE
		);

		// Active insights
		$client->set_textdomain( 'login-me-now' );
		$client->insights()->init();
	}
}