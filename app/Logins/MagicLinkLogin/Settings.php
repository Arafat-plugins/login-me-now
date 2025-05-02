<?php
/**
 * @author  Pluginly
 * @since   1.8
 * @version 1.8
 */

namespace LoginMeNow\Logins\MagicLinkLogin;

use LoginMeNow\Repositories\SettingsRepository;

class Settings {
	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
	}

	public function register_fields( array $fields ) {
		$fields[] = [
			'title'         => __( 'Enable magic login', 'login-me-now' ),
			'id'            => 'email_magic_link_enable',
			'previous_data' => SettingsRepository::get( 'email_magic_link_enable', false ),
			'type'          => 'switch',
			'tab'           => 'email-magic-link',
		];


		$fields[] = [
			'title'         => __( 'Title', 'login-me-now' ),
			'tooltip'       => __( 'Enter the form title', 'login-me-now' ),
			'id'            => 'email_magic_link_title',
			'placeholder'   => 'e.g., Email Magic Link',
			'previous_data' => SettingsRepository::get( 'email_magic_link_title', 'Email Magic Link' ),
			'type'          => 'text',
			'tab'           => 'email-magic-link',
			'if_has'        => ['email_magic_link_enable'],
		];

		$fields[] = [
			'title'         => __( 'Description', 'login-me-now' ),
			'tooltip'       => __( 'Enter the form description', 'login-me-now' ),
			'id'            => 'email_magic_link_description',
			'placeholder'   => 'e.g., Email Magic Link',
			'previous_data' => SettingsRepository::get( 'email_magic_link_description', 'Enter your registered email address to receive a quick login link directly in your inbox.' ),
			'type'          => 'textarea',
			'tab'           => 'email-magic-link',
			'if_has'        => ['email_magic_link_enable'],
		];
		$fields[] =[
			'title'			=> __( 'Change button text', 'login-me-now' ),
			'id'			=> 'magic_link_login_button_text',
			'tooltip'		=> __('Enter magic button text', 'login-me-now' ),
			'placeholder'	=> 'Continue with magic link',
			'previous_data' => SettingsRepository::get('magic_link_login_button_text', 'Continue with magic link'),
			'type' 			=> 'text',
			'tab'			=> 'email-magic-link',
			'if_has'        => ['email_magic_link_enable'],
		];

		$fields[] = [
			'title'         => __( 'Expiration', 'login-me-now' ),
			'tooltip'       => __( 'Enter the expiration of link in seconds', 'login-me-now' ),
			'id'            => 'email_magic_link_expiration',
			'placeholder'   => 'e.g., 300',
			'previous_data' => SettingsRepository::get( 'email_magic_link_expiration', 300 ),
			'type'          => 'number',
			'tab'           => 'email-magic-link',
			'if_has'        => ['email_magic_link_enable'],
		];

		return $fields;
	}
}