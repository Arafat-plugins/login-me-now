<?php
/**
 * @author  Pluginly
 * @since  	1.8
 * @version 1.8
 */

namespace LoginMeNow\Controllers;

use LoginMeNow\Repositories\SettingsRepository;
use WP_REST_Request;

class SettingsController {
	public function save( WP_REST_Request $request ) {

		$params = $request->get_params();

		try {
			if ( ! is_array( $params ) ) {
				throw new \Exception( __( 'Invalid Params', 'login-me-now' ) );
			}

			foreach ( $params as $key => $value ) {
				SettingsRepository::save( $key, $value );
			}

			wp_send_json_success( [
				'message' => __( 'Successfully Settings Saved', 'login-me-now' ),
				'params'  => $params,
			] );

		} catch ( \Throwable $th ) {
			wp_send_json_error( [
				'message' => __( 'Settings Update Failed', 'login-me-now' ),
				'error'   => $th->getMessage(),
				'params'  => $params,
			] );
		}
	}
}