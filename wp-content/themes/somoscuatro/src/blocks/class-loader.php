<?php
/**
 * Contains Somoscuatro\Theme\Blocks\Loaders Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks;

use DI\Container;

/**
 * Gutenberg Blocks Loader.
 */
class Loader {

	/**
	 * The PHP DI Container.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Class Constructor.
	 *
	 * @param Container $container The PHP DI Container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Loads Custom Gutenberg Blocks.
	 */
	public function load(): void {
		foreach ( glob( __DIR__ . '/*' ) as $block_dir ) {
			if ( ! is_dir( $block_dir ) ) {
				continue;
			}

			$class = implode(
				'_',
				array_map(
					'ucwords',
					explode( '-', basename( $block_dir ) )
				)
			);

			$full_class_path = sprintf( __NAMESPACE__ . '\%s\%s', $class, $class );
			if ( method_exists( $full_class_path, 'init' ) ) {
				( new $full_class_path( $this->container ) )->init();
			}
		}
	}
}
