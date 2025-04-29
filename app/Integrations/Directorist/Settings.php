<?php
/**
 * @author 	Pluginly
 * @since	1.6.0
 * @version 1.7.2
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
			'id'            => 'directorist_integration',
			'previous_data' => SettingsRepository::get( 'directorist_integration', true ),
			'type'          => 'switch',
			'tab'           => 'directorist',
		];

		return $fields;
	}
}