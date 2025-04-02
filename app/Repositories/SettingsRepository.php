<?php
/**
 * @author  Pluginly
 * @since  	1.6.0
 * @version 1.6.0
 */

namespace LoginMeNow\Repositories;

use LoginMeNow\Utils\Helper;

class SettingsRepository {
	private static string $option_name = 'login_me_now_admin_settings';
	private static array $settings;
	private static $instance;

	public function __construct() {
		self::$settings = get_option( self::$option_name, [] );
	}

	public static function init(): object {
		$class = get_called_class();
		if ( ! isset( self::$instance ) ) {
			self::$instance = new $class();
		}

		return self::$instance;
	}

	public function all(): array {
		$db_option = get_option( self::$option_name, [] );

		$defaults = apply_filters(
			'login_me_now_dashboard_rest_options',
			[
				'logs'            => true,

				'activity_logs'   => false,
				'social_login'    => true,
				'temporary_login' => true,

				'user_switching'  => true,

				'get_user_roles'  => Helper::get_user_roles(),
				'get_pages'       => Helper::get_pages(), // #Improvement Needed
			]
		);

		$updated_option = wp_parse_args( $db_option, $defaults );

		return $updated_option;
	}

	public static function get( string $key, $default = null ) {
		self::$settings = get_option( self::$option_name, [] );

		return self::$settings[$key] ?? $default;
	}

	public static function update( string $key, $value ): void {
		self::$settings       = get_option( self::$option_name, [] );
		self::$settings[$key] = $value;
		update_option( self::$option_name, self::$settings );
	}

	public function get_fields(): array {
		$fields = [
			[
				'title'         => 'Site Title',
				'description'   => 'Enter the title of your site.',
				'id'            => 'site_title',
				'placeholder'   => 'e.g., My Awesome Website',
				'previous_data' => self::get( 'site_title', 'hello world' ),
				'type'          => 'text',
				'tab'           => 'general',
			],
			[
				'title'         => 'Admin Email',
				'description'   => 'The email address for admin notifications.',
				'id'            => 'admin_email',
				'placeholder'   => 'e.g., admin@example.com',
				'previous_data' => self::get( 'admin_email', 'mehedi.2800@gmail.com' ),
				'type'          => 'email',
				'tab'           => 'advanced',
			],
			// [
			// 	'title'         => 'Background Color',
			// 	'id'            => 'background_color',
			// 	'previous_data' => get_option( 'background_color', '#ffffff' ),
			// 	'type'          => 'color',
			// ],
			// [
			// 	'title'         => 'Enable Feature',
			// 	'id'            => 'enable_feature',
			// 	'previous_data' => get_option( 'enable_feature', false ),
			// 	'type'          => 'switch',
			// ],
			// [
			// 	'title'         => 'Upload Logo',
			// 	'id'            => 'site_logo',
			// 	'previous_data' => get_option( 'site_logo', '' ),
			// 	'type'          => 'file',
			// ],
			// [
			// 	'title'         => 'Select Option',
			// 	'id'            => 'select_option',
			// 	'placeholder'   => 'Choose an option',
			// 	'previous_data' => get_option( 'select_option', '' ),
			// 	'type'          => 'select',
			// 	'options'       => [
			// 		['label' => 'Option 1', 'value' => 'option_1'],
			// 		['label' => 'Option 2', 'value' => 'option_2'],
			// 		['label' => 'Option 3', 'value' => 'option_3'],
			// 	],
			// ],
		];

		return apply_filters( 'login_me_now_settings_fields', $fields );
	}

	public static function save( string $key, $value ) {

		error_log( ' $key : ' . print_r( $value, true ) );

		self::$settings       = get_option( self::$option_name, [] );
		self::$settings[$key] = $value;
		update_option( self::$option_name, self::$settings );
	}
}