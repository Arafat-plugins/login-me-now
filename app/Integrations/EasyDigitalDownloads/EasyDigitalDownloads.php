<?php
/**
 * @author 	Pluginly
 * @since	1.7
 * @version 1.9
 */

namespace LoginMeNow\Integrations\EasyDigitalDownloads;

use LoginMeNow\Common\IntegrationBase;
use LoginMeNow\Repositories\LoginProvidersRepository;
use LoginMeNow\Repositories\SettingsRepository;

class EasyDigitalDownloads extends IntegrationBase {
	public function boot(): void {
		Settings::init();

		if ( ! $this->is_enabled() ) {
			return;
		}

		add_action( 'edd_login_fields_after', [$this, 'easy_digital_downloads_integration'] );
	}

	public function easy_digital_downloads_integration() {
		$position  = 'after';
		$providers = SettingsRepository::get( 'easy_digital_downloads_integration_login_providers', [] );

		$repository = new LoginProvidersRepository();
		$repository->get_provider_buttons_html( false, $providers, $position );
	}

	public function is_enabled(): bool {
		return (bool) SettingsRepository::get( 'easy_digital_downloads_login_enable', true );
	}
}