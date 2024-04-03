<?php
/**
 * Tech Tools Area custom Taxonomy.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Taxonomies\Taxonomies;

use Somoscuatro\Theme\Custom_Taxonomies\Custom_Taxonomy;

/**
 * Tech Tools Area custom Taxonomy.
 */
class Tech_Tools_Area extends Custom_Taxonomy {

	/**
	 * Taxonomy singular name.
	 *
	 * @var string
	 */
	protected string $singular_name = 'Tech Tools Area';

	/**
	 * Taxonomy plural name.
	 *
	 * @var string
	 */
	protected string $plural_name = 'Tech Tools Areas';

	/**
	 * Custom Post Types using this taxonomy.
	 *
	 * @var array
	 */
	protected array $post_types = array( 'tech-tool' );

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$args = array(
			'hierarchical' => false,
		);

		$this->args = wp_parse_args( $this->args, $args );
	}
}
