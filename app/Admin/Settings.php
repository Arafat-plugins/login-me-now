<?php
/**
 * @author  Pluginly
 * @since   1.0.0
 * @version 1.6.2
 */

namespace LoginMeNow\Admin;

use LoginMeNow\Repositories\SettingsRepository;

class Settings {
	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
	}

	public function register_fields( array $fields ) {

		$fields[] = [
			'title'         => 'Enable Login Me Now',
			'description'   => 'Use login features for WordPress native login page.',
			'id'            => 'wp_native_login_enable',
			'previous_data' => SettingsRepository::get( 'wp_native_login_enable', true ),
			'type'          => 'switch',
			'tab'           => 'wp-native-login',
		];

		$fields[] = [
			'title'         => __( 'Select Login Providers', 'login-me-now' ),
			'description'   => __( "Choose what login methods you would like to show.", 'login-me-now' ),
			'id'            => 'wp_native_login_providers',
			'previous_data' => SettingsRepository::get( 'wp_native_login_providers', 'email_magic_link' ),
			'type'          => 'multi-select',
			'options'       => [
				[
					'value' => 'google',
					'label' => 'Google',
				],
				[
					'value' => 'facebook',
					'label' => 'Facebook',
				],
				[
					'value'  => 'email_magic_link',
					'label'  => 'Email Magic Link',
					'is_pro' => true,
				],
			],
			'tab'           => 'wp-native-login',
			'if_has'        => ['google_login', 'google_onetap'],
		];

		$fields[] = [
			'title'         => __( 'Button Position', 'login-me-now' ),
			'description'   => __( "Choose where to show the login buttons", 'login-me-now' ),
			'id'            => 'wp_native_login_button_position',
			'previous_data' => SettingsRepository::get( 'wp_native_login_button_position', 'siteWide' ),
			'type'          => 'multi-select',
			'options'       => [
				[
					'value' => 'before',
					'label' => 'Before the login form',
				],
				[
					'value' => 'after',
					'label' => 'After the login form',
				],
			],
			'tab'           => 'wp-native-login',
			'if_has'        => ['google_login', 'google_onetap'],
		];

		$fields[] = [
			'title'         => 'Enter your license',
			'tooltip'       => 'An active license key is needed to unlock all the pro features and receive automatic plugin updates.',
			'id'            => 'lmn_pro_lic',
			'previous_data' => SettingsRepository::get( 'lmn_pro_lic', '' ),
			'type'          => 'text',
			'tab'           => 'license',
		];

		return $fields;
	}
}