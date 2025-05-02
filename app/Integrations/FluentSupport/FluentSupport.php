<?php
/**
 * @author 	Pluginly
 * @since	1.6
 * @version 1.9
 */

namespace LoginMeNow\Integrations\FluentSupport;

use LoginMeNow\Common\IntegrationBase;
use LoginMeNow\Repositories\LoginProvidersRepository;
use LoginMeNow\Repositories\SettingsRepository;

class FluentSupport extends IntegrationBase {
	public function boot(): void {
		Settings::init();

		if ( ! $this->is_enabled() ) {
			return;
		}

		add_action( 'login_form_top', [$this, 'fluent_support_integration'] );
		//add_action( 'atbdp_before_user_registration_submit', [$this, 'fluent_support_integration'] );
	}

	public function fluent_support_integration() {
		$position  = 'after';
		$providers = SettingsRepository::get( 'fluent_support_integration_login_providers', [] );

		$repository = new LoginProvidersRepository();

		return $repository->get_provider_buttons_html( true, $providers, $position );
	}

	public function is_enabled(): bool {
		return (bool) SettingsRepository::get( 'fluent_support_integration_enable', true );
	}
}