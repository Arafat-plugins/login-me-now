<?php
/**
 * @author  Pluginly
 * @since   1.9
 * @version 1.9
 */

namespace LoginMeNow\Integrations\SimpleHistory;

use LoginMeNow\Common\Singleton;
use LoginMeNow\Repositories\SettingsRepository;

class Settings {
	use Singleton;

	public function __construct() {
		add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
	}

	public function register_fields( array $fields ) {
		$fields[] = [
			'title'         => __( 'Simple History Integration', 'login-me-now' ),
			'description'   => __( "Keep an activity log of everything that occurs when a user logs in to the dashboard using the tokenized login link.", 'login-me-now' ),
			'id'            => 'activity_logs',
			'previous_data' => SettingsRepository::get( 'activity_logs', true ),
			'type'          => 'switch',
			'tab'           => 'activity-logs',
		];

		return $fields;
	}
}