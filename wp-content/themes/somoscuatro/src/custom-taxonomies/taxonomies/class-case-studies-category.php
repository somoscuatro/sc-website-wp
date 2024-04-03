<?php
/**
 * Case Studies Category custom Taxonomy.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Taxonomies\Taxonomies;

use Somoscuatro\Theme\Custom_Taxonomies\Custom_Taxonomy;

/**
 * Case Studies Category custom Taxonomy.
 */
class Case_Studies_Category extends Custom_Taxonomy {

	/**
	 * Taxonomy singular name.
	 *
	 * @var string
	 */
	protected string $singular_name = 'Case Studies Category';

	/**
	 * Taxonomy plural name.
	 *
	 * @var string
	 */
	protected string $plural_name = 'Case Studies Categories';

	/**
	 * Custom Post Types using this taxonomy.
	 *
	 * @var array
	 */
	protected array $post_types = array( 'case-study' );
}
