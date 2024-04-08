<?php
/**
 * Custom Taxonomy Loader.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Taxonomies;

use DI\Container;

/**
 * Custom Taxonomy Loader.
 */
class Loader {

	/**
	 * The PHP DI container.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Class constructor.
	 *
	 * @param Container $container The PHP DI Container.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Loads Custom Taxonomies.
	 */
	public function load(): void {
		foreach ( glob( __DIR__ . '/taxonomies/*' ) as $cpt_file ) {
			if ( ! is_file( $cpt_file ) ) {
				continue;
			}

			$class = implode(
				'_',
				array_map(
					'ucwords',
					explode(
						'-',
						str_replace( array( 'class-', '.php' ), '', basename( $cpt_file ) )
					)
				)
			);

			$full_class_path = sprintf( __NAMESPACE__ . '\Taxonomies\%s', $class );

			if ( method_exists( $full_class_path, 'init' ) ) {
				( new $full_class_path() )->init( $this->container );
			}
		}
	}
}
