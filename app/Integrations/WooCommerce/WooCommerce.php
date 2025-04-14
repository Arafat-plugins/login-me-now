<?php
/**
 * @author 	Pluginly
 * @since	1.6.0
 * @version 1.7.2
 */

namespace LoginMeNow\Integrations\WooCommerce;

use LoginMeNow\Common\IntegrationBase;
use LoginMeNow\Providers\LoginFormsServiceProvider;

class WooCommerce extends IntegrationBase {
	public function boot(): void {
		add_action( 'woocommerce_login_form_start', [$this, 'add_form'] );

		if ( class_exists( 'WC_Emails' ) ) {
			remove_action( 'register_new_user', 'wp_send_new_user_notifications' );

			// Hook into user registration to send WooCommerce email
			add_action( 'login_me_now_after_registration', [$this, 'send_wc_new_account_email'], 10, 2 );
		}
	}

	public function add_form() {
		( new LoginFormsServiceProvider() )->login_buttons();
	}

	/**
	 * Send WooCommerce new account email on user registration
	 *
	 * @param int $user_id The ID of the newly registered user.
	 * @param object $userDataDTO Data object containing user details.
	 */
	public function send_wc_new_account_email( $user_id, $userDataDTO ) {
		$wc_emails = WC()->mailer()->get_emails();
		if ( isset( $wc_emails['WC_Email_Customer_New_Account'] ) ) {
			$new_account_email = $wc_emails['WC_Email_Customer_New_Account'];

			// WooCommerce automatically handles password generation or uses the provided one
			$new_account_email->trigger( $user_id, '' ); // Empty password argument
		}
	}
}