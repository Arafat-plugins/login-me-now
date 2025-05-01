<?php
/**
 * @author 	Pluginly
 * @since	1.9
 * @version 1.9
 */

namespace LoginMeNow\Integrations\Directorist;

use LoginMeNow\Common\Singleton;
use LoginMeNow\Repositories\SettingsRepository;

class Settings {
	use Singleton;

	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
	}

	public function register_fields( array $fields ) {
		$fields[] = [
			'title'         => 'Enable Directorist Integration',
			'description'   => 'Use login features for Directorist users.',
			'id'            => 'directorist_integration_enable',
			'previous_data' => SettingsRepository::get( 'directorist_integration_enable', true ),
			'type'          => 'switch',
			'tab'           => 'directorist',
		];

		$fields[] = [
			'type'   => 'separator',
			'tab'    => 'directorist',
			'if_has' => ['directorist_integration_enable'],
		];

		$fields[] = [
			'title'         => __( 'Select Login Providers', 'login-me-now' ),
			'description'   => __( "Choose what login methods you would like to show.", 'login-me-now' ),
			'id'            => 'directorist_integration_login_providers',
			'previous_data' => SettingsRepository::get( 'directorist_integration_login_providers', 'email_magic_link' ),
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
			'tab'           => 'directorist',
			'if_has'        => ['directorist_integration_enable'],
		];

		$fields[] = [
			'type'   => 'separator',
			'tab'    => 'directorist',
			'if_has' => ['directorist_integration_enable'],
		];

		return $fields;
	}
}