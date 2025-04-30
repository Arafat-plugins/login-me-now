<?php
/**
 * @author  Pluginly
 * @since   1.7.0
 * @version 1.7.0
 */

namespace LoginMeNow\Logins\GoogleLogin;

use LoginMeNow\Repositories\SettingsRepository;
use LoginMeNow\Utils\Helper;

class Settings {
	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
		add_filter( 'login_me_now_admin_settings_datatypes', [$this, 'register_types_legacy'] );
		add_filter( 'login_me_now_dashboard_rest_options', [$this, 'register_options_legacy'] );
	}

	public function register_fields( array $fields ) {

		$page_options = [];
		foreach ( Helper::get_pages() as $page ) {

			$page_options[] = [
				'value' => $page['id'],
				'label' => $page['name'],
			];
		}

		$roles_options = [];

		foreach ( Helper::get_user_roles() as $key => $role ) {

			$roles_options[] = [
				'value' => $key,
				'label' => $role,
			];
		}

		$fields[] = [
			'title'         => __( 'Enable google login', 'login-me-now' ),
			'description'   => __( "Enable google login", 'login-me-now' ),
			'id'            => 'google_login',
			'previous_data' => SettingsRepository::get( 'google_login', false ),
			'type'          => 'switch',
			'tab'           => 'google',
		];

		$fields[] = [
			'title'         => __( 'Enter <a href="https://developers.google.com/identity/gsi/web/guides/get-google-api-clientid">Google Client ID</a>', 'login-me-now' ),
			'description'   => __( "Enter your google Client ID here.", 'login-me-now' ),
			'id'            => 'google_client_id',
			'placeholder'   => 'ex: **********--**********.apps.googleusercontent.com',
			'previous_data' => SettingsRepository::get( 'google_client_id', '' ),
			'type'          => 'text',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => __( 'Enter Google Client Secret', 'login-me-now' ),
			'description'   => __( "Enter your Client Secret key here.", 'login-me-now' ),
			'id'            => 'google_client_secret',
			'placeholder'   => 'e.g., Email Magic Link',
			'previous_data' => SettingsRepository::get( 'google_client_secret', '' ),
			'type'          => 'text',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
			'class'         => 'lmn-settings-separator',
		];

		$fields[] = [
			'title'         => __( 'Enable One Tap', 'login-me-now' ),
			'description'   => __( "Enable google one tap login", 'login-me-now' ),
			'id'            => 'google_onetap',
			'previous_data' => SettingsRepository::get( 'google_onetap', false ),
			'type'          => 'switch',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => __( 'Select location', 'login-me-now' ),
			'description'   => __( "Choose a location.", 'login-me-now' ),
			'id'            => 'google_onetap_display_location',
			'previous_data' => SettingsRepository::get( 'google_onetap_display_location', 'side_wide' ),
			'type'          => 'select',
			'options'       => [
				[
					'value' => 'login_screen',
					'label' => 'Only on login screen',
				],
				[
					'value' => 'side_wide',
					'label' => 'Site wide',
				],
				[
					'label'  => 'Specific page (PRO)',
					'value'  => 'selected_pages',
					'is_pro' => true,
				],
			],
			'tab'           => 'google',
			'if_has'        => ['google_login', 'google_onetap'],
		];
		$fields[] = [
			'title'         => __( 'Select pages', 'login-me-now' ),
			'description'   => __( "Select specific pages.", 'login-me-now' ),
			'id'            => 'google_pro_selected_pages',
			'previous_data' => SettingsRepository::get( 'google_pro_selected_pages', [] ),
			'type'          => 'multi-select',
			'options'       => $page_options,
			'tab'           => 'google',
			'if_has'        => ['google_login', 'google_onetap'], // Have to add another logic for google_onetap_display_location === selected_pages
			'if_selected'   => [
				'google_onetap_display_location' => 'selected_pages',
			],
			'class'         => 'lmn-settings-separator',
			'is_pro'        => true,
		];

		$fields[] = [
			'title'         => __( 'Enable One Tap Prompt Behavior', 'login-me-now' ),
			'description'   => __( 'Enable automatic closing on outside clicks.', 'login-me-now' ),
			'id'            => 'google_cancel_on_tap_outside',
			'previous_data' => SettingsRepository::get( 'google_cancel_on_tap_outside', false ),
			'type'          => 'switch',
			'if_has'        => ['google_login', 'google_onetap'],
		];
		$fields[] = [
			'title'         => __( 'User Role Permission Level', 'login-me-now' ),
			'description'   => __( "Select a permission option for users.", 'login-me-now' ),
			'id'            => 'google_pro_default_user_role',
			'previous_data' => SettingsRepository::get( 'google_pro_default_user_role', '' ),
			'type'          => 'select',
			'options'       => $roles_options,
			'tab'           => 'google',
			'if_has'        => ['google_login'],
			'is_pro'        => true,
		];
		$fields[] = [
			'title'         => __( 'Update existing user name', 'login-me-now' ),
			'description'   => __( "Automatically retrieve the existing user first, last, nick & display name from google account upon login using gmail ", 'login-me-now' ),
			'id'            => 'google_update_existing_user_data',
			'previous_data' => SettingsRepository::get( 'google_update_existing_user_data', false ),
			'type'          => 'switch',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
			'is_pro'        => true,
		];
		$fields[] = [
			'title'         => __( 'Add user profile picture', 'login-me-now' ),
			'description'   => __( "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail", 'login-me-now' ),
			'id'            => 'google_pro_user_avatar',
			'previous_data' => SettingsRepository::get( 'google_pro_user_avatar', false ),
			'type'          => 'switch',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
			'is_pro'        => true,
		];
		$fields[] = [
			'title'         => __( 'Redirect after successful login and registration', 'login-me-now' ),
			// 'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_pro_redirect_url',
			'previous_data' => SettingsRepository::get( 'google_pro_redirect_url', '' ),
			'type'          => 'text',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
			'is_pro'        => true,
		];

		return $fields;
	}

	public function register_types_legacy( array $options ) {
		$options['google_login']                   = 'bool';
		$options['google_client_id']               = 'string';
		$options['google_client_secret']           = 'string';
		$options['google_native_login']            = 'bool';
		$options['google_onetap']                  = 'bool';
		$options['google_cancel_on_tap_outside']   = 'bool';
		$options['google_onetap_display_location'] = 'string';

		return $options;
	}

	public function register_options_legacy( array $options ) {
		$options['google_login']                     = false;
		$options['google_client_id']                 = '';
		$options['google_client_secret']             = '';
		$options['google_native_login']              = true;
		$options['google_update_existing_user_data'] = false;
		$options['google_pro_user_avatar']           = false;
		$options['google_cancel_on_tap_outside']     = false;
		$options['google_onetap_display_location']   = 'side_wide';

		return $options;
	}
}