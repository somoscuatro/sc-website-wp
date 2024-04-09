<?php
/**
 * Contains Somoscuatro\Theme\Attributes\Hook Class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme\Attributes;

use ReflectionAttribute;
use ReflectionClass;

use DI\Container;

/**
 * Hooks Management Class.
 */
class Hook {

	/**
	 * The PHP DI Container.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * The names of the classes that contain hooks handlers.
	 *
	 * @var array
	 */
	private array $hooked_classes = array();

	/**
	 * Class Constructor.
	 *
	 * @param Container $container The PHP DI Container.
	 */
	public function __construct( Container $container ) {
		$this->container      = $container;
		$this->hooked_classes = require __DIR__ . '/hooked-classes.php';
	}

	/**
	 * Registers hooks.
	 */
	public function register_hooks(): void {
		$instances = array();

		foreach ( $this->hooked_classes as $class_name ) {
			$reflection_class = new ReflectionClass( $class_name );

			foreach ( $reflection_class->getMethods() as $method ) {
				$attributes = $method->getAttributes( Filter::class, ReflectionAttribute::IS_INSTANCEOF );

				foreach ( $attributes as $attribute ) {
					// Maybe instantiate class.
					if ( ! array_key_exists( $class_name, $instances ) ) {
						$instances[ $class_name ] = $this->container->get( $class_name );
					}

					// Instantiate hooks.
					$hook_class = $attribute->newInstance();
					$hook_class->register(
						array(
							$instances[ $class_name ],
							$method->getName(),
						)
					);
				}
			}
		}
	}
}
