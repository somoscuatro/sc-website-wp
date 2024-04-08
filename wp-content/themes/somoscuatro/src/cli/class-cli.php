<?php
/**
 * CLI management class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme\CLI;

use DI\Container;

/**
 * CLI management class.
 */
class CLI {

	/**
	 * The PHP DI container.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Class constructor.
	 *
	 * @param Container $container The PHP DI container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Registers CLI commands.
	 */
	public function register_commands(): void {
		// phpcs:ignore Generic.Commenting.DocComment.MissingShort
		/** @disregard P1011 */
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			$command = $this->container->get( __NAMESPACE__ . '\Commands\Export_Acf_Blocks_Fields' );
			\WP_CLI::add_command( 'export-acf-blocks-fields', $command );
		}
	}
}
