<?php
/**
 * Contains Somoscuatro\Theme\CLI\CLI_Command Class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme\CLI;

use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * WP CLI Command Base Class.
 */
abstract class CLI_Command extends \WP_CLI_Command {

	use Filesystem;

	/**
	 * The Gutenberg Blocks Base Path.
	 *
	 * @var string
	 */
	protected $blocks_base_path;

	/**
	 * Gets the Root Namespace.
	 *
	 * @return string The Root Namespace.
	 */
	protected function get_base_namespace(): string {
		$namespace = explode( '\\', __NAMESPACE__ );

		$root_namespace = array(
			$namespace[0],
			$namespace[1],
		);

		return implode( '\\', $root_namespace );
	}
}
