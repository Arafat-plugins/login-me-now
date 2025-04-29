<?php
/**
 * @author 	Pluginly
 * @since	1.6.0
 * @version 1.7.2
 */

namespace LoginMeNow\Integrations\EasyDigitalDownloads;

use LoginMeNow\Common\Singleton;
use LoginMeNow\Repositories\SettingsRepository;

class Settings {
	use Singleton;

	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
	}

	public function register_fields( array $fields ) {
		$fields[] = [
			'title'         => 'Enable Easy Digital Downloads Integration',
			'description'   => 'Use login features for Easy Digital Downloads users.',
			'id'            => 'easy_digital_downloads_integration',
			'previous_data' => SettingsRepository::get( 'easy_digital_downloads_integration', true ),
			'type'          => 'switch',
			'tab'           => 'easy-digital-downloads',
		];

		return $fields;
	}
}