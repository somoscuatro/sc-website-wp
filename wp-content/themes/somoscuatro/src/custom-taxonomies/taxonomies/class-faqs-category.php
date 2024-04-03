<?php
/**
 * FAQs Category custom Taxonomy.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Taxonomies\Taxonomies;

use Somoscuatro\Theme\Custom_Taxonomies\Custom_Taxonomy;

/**
 * FAQs Category custom Taxonomy.
 */
class FAQs_Category extends Custom_Taxonomy {

	/**
	 * Taxonomy singular name.
	 *
	 * @var string
	 */
	protected string $singular_name = 'FAQ Category';

	/**
	 * Taxonomy plural name.
	 *
	 * @var string
	 */
	protected string $plural_name = 'FAQ Categories';

	/**
	 * Custom Post Types using this taxonomy.
	 *
	 * @var array
	 */
	protected array $post_types = array( 'faq' );
}
