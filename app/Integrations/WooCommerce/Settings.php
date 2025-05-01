<?php
/**
 * @author 	Pluginly
 * @since	1.9
 * @version 1.9
 */

namespace LoginMeNow\Integrations\WooCommerce;

use LoginMeNow\Common\Singleton;
use LoginMeNow\Repositories\SettingsRepository;

class Settings {
	use Singleton;

	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
	}

	public function register_fields( array $fields ) {
		$fields[] = [
			'title'         => 'Enable WooCommerce Integration',
			'description'   => 'Use login features for WooCommerce users.',
			'id'            => 'woocommerce_integration_login_enable',
			'previous_data' => SettingsRepository::get( 'woocommerce_integration_login_enable', true ),
			'type'          => 'switch',
			'tab'           => 'woocommerce',
		];

		$fields[] = [
			'type' => 'separator',
			'tab'  => 'wp-native-login',
		];

		$fields[] = [
			'title'         => __( 'Select Login Providers', 'login-me-now' ),
			'description'   => __( "Choose what login methods you would like to show.", 'login-me-now' ),
			'id'            => 'woocommerce_integration_login_providers',
			'previous_data' => SettingsRepository::get( 'woocommerce_integration_login_providers', 'email_magic_link' ),
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
			'tab'           => 'woocommerce',
			'if_has'        => ['woocommerce_integration_login_enable'],
		];

		return $fields;
	}
}