<?php
/**
 * @author  Pluginly
 * @since   1.7.0
 * @version 1.7.0
 */

namespace LoginMeNow\Logins\FacebookLogin;
use LoginMeNow\Repositories\SettingsRepository;
use LoginMeNow\Utils\Helper;

class Settings {
	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
		add_filter( 'login_me_now_admin_settings_datatypes', [$this, 'register_types_legacy'] );
		add_filter( 'login_me_now_dashboard_rest_options', [$this, 'register_options_legacy'] );
	}
	public function register_fields( array $fields ) {

		$roles_options = [];

		foreach( Helper::get_user_roles() as $key => $role ) {

			$roles_options [] = [
				'value' => $key ,
				'label' => $role				
			];
		}

		$fields[] = [
			'title'         => 'Enable facebook login',
			'tooltip'		=> 'Enbale facebook login',
			'id'            => 'facebook_login',
			'previous_data' => SettingsRepository::get( 'facebook_login', false ),
			'type'          => 'switch',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => 'Enter facebook App ID',
			'tooltip'		=> 'Enbale facebook login',
			'id'            => 'facebook_app_id',
			'previous_data' => SettingsRepository::get( 'facebook_app_id', '' ),
			'type'          => 'text',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => 'Enter Facebook App Secret',
			'tooltip'		=> 'Enter Facebook App Secret',
			'id'            => 'facebook_app_secret',
			'previous_data' => SettingsRepository::get( 'facebook_app_secret', '' ),
			'type'          => 'text',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => 'Show in native login page',
			'tooltip'		=> 'Show in native login page',
			'id'            => 'facebook_native_login',
			'previous_data' => SettingsRepository::get( 'facebook_native_login', true ),
			'type'          => 'switch',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => 'User role permission level',
			'tooltip'		=> 'Show in native login page',
			'id'            => 'facebook_pro_default_user_role',
			'previous_data' => SettingsRepository::get( 'facebook_pro_default_user_role', []),
			'type'          => 'select',
			'options'		=> $roles_options,
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => 'Update existing user name',
			'tooltip'		=> 'Update existing user name',
			'id'            => 'facebook_update_existing_user_data',
			'previous_data' => SettingsRepository::get( 'facebook_update_existing_user_data', []),
			'type'          => 'switch',
			'tab'           => 'facebook',
		];

		return $fields;
	}

	public function register_types_legacy( array $options ) {
		$options['enable_sign_in_facebook']            = 'bool';

		$options['facebook_login']                     = 'bool';
		$options['facebook_app_id']                    = 'string';
		$options['facebook_app_secret']                = 'string';
		$options['facebook_native_login']              = 'bool';
		$options['facebook_update_existing_user_data'] = 'bool';
		$options['facebook_pro_user_avatar']           = 'bool';

		return $options;
	}

	public function register_options_legacy( array $options ) {
		$options['enable_sign_in_facebook']            = false;
		
		$options['facebook_login']                     = false;
		$options['facebook_app_id']                    = '';
		$options['facebook_app_secret']                = '';
		$options['facebook_native_login']              = true;
		$options['facebook_update_existing_user_data'] = false;
		$options['facebook_pro_user_avatar']           = false;

		return $options;
	}
}