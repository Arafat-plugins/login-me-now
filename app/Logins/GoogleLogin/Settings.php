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
			'title'         => 'Enable google login',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_login',
			'previous_data' => SettingsRepository::get( 'google_login', false ),
			'type'          => 'switch',
			'tab'           => 'google',
		];

		$fields[] = [
			'title'         => 'Enter Google Client ID',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_client_id',
			'placeholder'   => 'ex: **********--**********.apps.googleusercontent.com',
			'previous_data' => SettingsRepository::get( 'google_client_id', '' ),
			'type'          => 'text',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => 'Enter Google Client Secret',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_client_secret',
			'placeholder'   => 'e.g., Email Magic Link',
			'previous_data' => SettingsRepository::get( 'google_client_secret', '' ),
			'type'          => 'text',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
			'class'         => 'lmn-settings-separator',
		];

		$fields[] = [
			'title'         => 'Enable one tap login',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_onetap',
			'previous_data' => SettingsRepository::get( 'google_onetap', false ),
			'type'          => 'switch',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => 'Select location',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_onetap_display_location',
			'previous_data' => SettingsRepository::get( 'google_onetap_display_location', 'siteWide' ),
			'type'          => 'select',
			'options'       => [
				[
					'value' => 'login_screen',
					'label' => 'Only on login screen',
				],
				[
					'value' => 'site_wide',
					'label' => 'Site wide',
				],
				[
					'label'  => 'Specific page (pro)',
					'is_pro' => true,
					'value'  => 'selected_pages',
				],
			],
			'tab'           => 'google',
			'if_has'        => ['google_login', 'google_onetap'],
		];
		$fields[] = [
			'title'         => 'Select page',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_pro_selected_pages',
			'previous_data' => SettingsRepository::get( 'google_pro_selected_pages', [] ),
			'type'          => 'multi-select',
			'options'       => $page_options,
			'tab'           => 'google',
			'if_has'        => ['google_login', 'google_onetap'], // Have to add another logic for google_onetap_display_location === selected_pages
			'class'         => 'lmn-settings-separator',
		];

		$fields[] = [
			'title'         => 'Enable One Tap Prompt Behavior',
			'description'   => 'Enable automatic closing on outside clicks',
			'id'            => 'google_cancel_on_tap_outside',
			'previous_data' => SettingsRepository::get( 'google_cancel_on_tap_outside', false ),
			'type'          => 'switch',
			'if_has'        => ['google_login', 'google_onetap'],
		];
		$fields[] = [
			'title'         => 'User Role Permission Level',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_pro_default_user_role',
			'previous_data' => SettingsRepository::get( 'google_pro_default_user_role', '' ),
			'type'          => 'select',
			'options'       => $roles_options,
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => 'Update existing user name',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_update_existing_user_data',
			'previous_data' => SettingsRepository::get( 'google_update_existing_user_data', false ),
			'type'          => 'switch',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => 'Add user profile picture',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_pro_user_avatar',
			'previous_data' => SettingsRepository::get( 'google_pro_user_avatar', false ),
			'type'          => 'switch',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
		];
		$fields[] = [
			'title'         => 'Redirect after successful login and registration',
			'description'   => "Automatically retrieve the profile picture as avatar from users' google account upon login or register using gmail",
			'id'            => 'google_pro_redirect_url',
			'previous_data' => SettingsRepository::get( 'google_pro_redirect_url', '' ),
			'type'          => 'text',
			'tab'           => 'google',
			'if_has'        => ['google_login'],
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
		$options['google_onetap_display_location']   = 'siteWide';

		return $options;
	}
}