<?php
/**
 * @author 	Pluginly
 * @since	1.7
 * @version 1.9
 */

namespace LoginMeNow\Integrations\EasyDigitalDownloads;

use LoginMeNow\Common\IntegrationBase;
use LoginMeNow\Providers\LoginFormsServiceProvider;
use LoginMeNow\Repositories\SettingsRepository;

class EasyDigitalDownloads extends IntegrationBase {
	public function boot(): void {
		Settings::init();

		if ( SettingsRepository::get( 'easy_digital_downloads_integration', true ) ) {
			return;
		}

		add_action( 'edd_login_fields_after', [$this, 'add_form'] );
	}

	public function add_form() {
		( new LoginFormsServiceProvider() )->login_buttons( false, true, false );
	}
}