<?php
/**
 * WP CLI Command base class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme\CLI;

use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * WP CLI Command base class.
 */
abstract class CLI_Command extends \WP_CLI_Command {

	use Filesystem;

	/**
	 * The Gutenberg Blocks base path.
	 *
	 * @var string
	 */
	protected $blocks_base_path;

	/**
	 * Gets the root namespace.
	 *
	 * @return string The root namespace.
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
