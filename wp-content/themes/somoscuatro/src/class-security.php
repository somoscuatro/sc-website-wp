<?php
/**
 * Contains Somoscuatro\Theme\Security Class.
 *
 * @package somoscuatro-theme
 */

declare( strict_types=1 );

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Filter;

/**
 * Security Enhancing Functionality.
 */
class Security {

	/**
	 * Disables XML-RPC.
	 *
	 * @return bool Returns false to disable XML-RPC.
	 */
	#[Filter( 'xmlrpc_enabled' )]
	public function disable_xmlrpc() {
		return false;
	}
}
