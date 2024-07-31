<?php
/**
 * Contains Somoscuatro\Theme\Security Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Filter;

use WP_Error;

/**
 * Security Enhancing Functionality.
 */
class Security {

	/**
	 * Block access to the REST API if the user is not logged in.
	 *
	 * @param mixed $access The access value to be returned.
	 *
	 * @return mixed The access value if the user is logged in, otherwise a WP_Error object.
	 */
	#[Filter( 'rest_authentication_errors' )]
	public function restrict_access_to_rest_api( $access ) {
		if ( ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_api_cannot_access',
				__( 'Your are not authorized to access the REST API.', 'somoscuatro-theme' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return $access;
	}
}
