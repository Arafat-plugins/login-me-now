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
			'title'         => __( 'Enable facebook login','login-me-now' ),
			'tooltip'		=> __('Enbale facebook login','login-me-now' ),
			'id'            => 'facebook_login',
			'previous_data' => SettingsRepository::get( 'facebook_login', false ),
			'type'          => 'switch',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => __( 'Enter <a href="https://developers.facebook.com/apps/">facebook App ID</a>','login-me-now' ),
			'tooltip'		=> __( 'Enbale facebook login','login-me-now' ),
			'id'            => 'facebook_app_id',
			'previous_data' => SettingsRepository::get( 'facebook_app_id', '' ),
			'type'          => 'text',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => __( 'Enter Facebook App Secret','login-me-now' ),
			'tooltip'		=> __( 'Enter Facebook App Secret','login-me-now' ),
			'id'            => 'facebook_app_secret',
			'previous_data' => SettingsRepository::get( 'facebook_app_secret', '' ),
			'type'          => 'text',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => __( 'Show in native login page','login-me-now' ),
			'tooltip'		=> __( 'Show in native login page','login-me-now' ),
			'description'	=>__( 'Check, what would it look like! See <a href="https://try.loginmenow.com/wp-admin/"><strong>demo</strong></a>','login-me-now' ),
			'id'            => 'facebook_native_login',
			'previous_data' => SettingsRepository::get( 'facebook_native_login', true ),
			'type'          => 'switch',
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => __( 'User role permission level','login-me-now' ),
			'tooltip'		=> __( 'Show in native login page','login-me-now' ),
			'description'   => __( 'Select the role that will be assigned to new users who sign up', 'login-me-now' ),
			'id'            => 'facebook_pro_default_user_role',
			'previous_data' => SettingsRepository::get( 'facebook_pro_default_user_role', []),
			'type'          => 'select',
			'options'		=> $roles_options,
			'tab'           => 'facebook',
		];
		$fields[] = [
			'title'         => __( 'Update existing user name','login-me-now' ),
			'tooltip'		=> __( 'Update existing user name','login-me-now' ),
			'description'	=> __( 'Automatically retrieve the existing user first, last, nick & display name from facebook account upon login using facebook','login-me-now' ),
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