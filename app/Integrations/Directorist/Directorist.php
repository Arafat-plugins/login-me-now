<?php
/**
 * @author 	Pluginly
 * @since	1.6
 * @version 1.9
 */

namespace LoginMeNow\Integrations\Directorist;

use LoginMeNow\Common\IntegrationBase;
use LoginMeNow\Repositories\LoginProvidersRepository;
use LoginMeNow\Repositories\SettingsRepository;

class Directorist extends IntegrationBase {
	public function boot(): void {
		Settings::init();

		if ( ! $this->is_enabled() ) {
			return;
		}

		add_action( 'atbdp_before_login_form_end', [$this, 'directorist_integration'] );
		add_action( 'atbdp_before_user_registration_submit', [$this, 'directorist_integration'] );
	}

	public function directorist_integration() {
		$position  = 'before';
		$providers = SettingsRepository::get( 'directorist_integration_login_providers', [] );

		$repository = new LoginProvidersRepository();
		$repository->get_provider_buttons_html( false, $providers, $position );
	}

	public function is_enabled(): bool {
		return (bool) SettingsRepository::get( 'directorist_integration_enable', true );
	}
}