<?php
/**
 * @author  Pluginly
 * @since   1.6
 * @version 1.9
 */

namespace LoginMeNow\Common;

use LoginMeNow\Common\Hookable;
use LoginMeNow\Common\Singleton;

abstract class LoginProviderButtonBase {
	use Singleton;
	use Hookable;

	abstract public function html(): string;
	abstract public function shortcodes(): void;
	abstract public function get_button(): string;

	public function __construct() {
		$this->action( 'init', [$this, 'shortcodes'] );
	}
}
