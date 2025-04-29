<?php



namespace LoginMeNow\Logins\LinkLogin;

use LoginMeNow\Common\Singleton;
use LoginMeNow\Repositories\SettingsRepository;
use LoginMeNow\Utils\Helper;

class Settings{
    use Singleton;

    public function __construct() {

        add_filter( 'login_me_now_settings_fields', [$this, 'register_fields'] );
    }
    public function register_fields( array $fields ) {
 
        $fields[] = [
			'title'         => __( 'Link Login', 'login-me-now' ),
			'description'   => __( "If frequent logins to the dashboard are necessary throughout the day, the browser extension comes in handy.It just takes 1 click to login to dashboard.", 'login-me-now' ),
			'id'            => 'temporary_login',
			'previous_data' => SettingsRepository::get( 'temporary_login', false ),
			'type'          => 'switch',
			'tab'           => 'delegate-access'
		];

        return $fields;
    }
}