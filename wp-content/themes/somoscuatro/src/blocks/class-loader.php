<?php
/**
 * Gutenberg Blocks loader.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks;

use Somoscuatro\Theme\Dependency_Injection\Container_Interface as Dependencies;

/**
 * Gutenberg Blocks loader.
 */
class Loader {

	/**
	 * Dependencies container.
	 *
	 * @var Dependencies
	 */
	protected $dependencies;

	/**
	 * Class constructor.
	 *
	 * @param Dependencies $dependencies Dependencies container.
	 */
	public function __construct( Dependencies $dependencies ) {
		$this->dependencies = $dependencies;
	}

	/**
	 * Loads custom Gutenberg blocks.
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
				( new $full_class_path( $this->dependencies ) )->init();
			}
		}
	}
}
