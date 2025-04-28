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