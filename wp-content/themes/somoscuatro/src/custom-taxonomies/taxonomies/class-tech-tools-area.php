<?php
/**
 * Contains Somoscuatro\Theme\Custom_Taxonomies\Tech_Tools_Area Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Taxonomies\Taxonomies;

use Somoscuatro\Theme\Custom_Taxonomies\Custom_Taxonomy;

/**
 * Tech Tools Area Custom Taxonomy.
 */
class Tech_Tools_Area extends Custom_Taxonomy {

	/**
	 * Taxonomy Singular Name.
	 *
	 * @var string
	 */
	protected string $singular_name = 'Tech Tools Area';

	/**
	 * Taxonomy Plural Name.
	 *
	 * @var string
	 */
	protected string $plural_name = 'Tech Tools Areas';

	/**
	 * Custom Post Types Using This Taxonomy.
	 *
	 * @var array
	 */
	protected array $post_types = array( 'tech-tool' );

	/**
	 * Class Constructor.
	 */
	public function __construct() {
		parent::__construct();

		$args = array(
			'hierarchical' => false,
		);

		$this->args = wp_parse_args( $args, $this->args );
	}
}
