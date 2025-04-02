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
			'title'         => 'Enable magic link login',
			'id'            => 'email_magic_link_enable_x',
			'previous_data' => SettingsRepository::get( 'email_magic_link_enable_x', false ),
			'type'          => 'switch',
			'tab'           => 'email-magic-link',
		];

		$fields[] = [
			'title'         => 'Title',
			'tooltip'       => 'Enter the form title',
			'id'            => 'email_magic_link_title',
			'placeholder'   => 'e.g., Email Magic Link',
			'previous_data' => SettingsRepository::get( 'email_magic_link_title', 'Email Magic Link' ),
			'type'          => 'text',
			'tab'           => 'email-magic-link',
		];

		$fields[] = [
			'title'         => 'Description',
			'tooltip'       => 'Enter the form description',
			'id'            => 'email_magic_link_description',
			'placeholder'   => 'e.g., Email Magic Link',
			'previous_data' => SettingsRepository::get( 'email_magic_link_description', 'Enter your registered email address to receive a quick login link directly in your inbox.' ),
			'type'          => 'textarea',
			'tab'           => 'email-magic-link',
		];

		$fields[] = [
			'title'         => 'Expiration',
			'tooltip'       => 'Enter the expiration of link in seconds',
			'id'            => 'email_magic_link_expiration',
			'placeholder'   => 'e.g., 300',
			'previous_data' => SettingsRepository::get( 'email_magic_link_expiration', 300 ),
			'type'          => 'number',
			'tab'           => 'email-magic-link',
		];

		return $fields;
	}
}