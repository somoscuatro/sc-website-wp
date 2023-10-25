<?php
/**
 * Custom Taxonomy related functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Cpt;

/**
 * Custom Taxonomy related functionality.
 */
class Custom_Taxonomy {

	/**
	 * Registers a custom taxonomy linked to a custom post type.
	 *
	 * @param string $singular_name Singular name for the taxonomy.
	 * @param string $plural_name   Plural name for the taxonomy.
	 * @param array  $post_types    Post types the taxonomy is associated to.
	 * @param array  $args          Arguments to register the taxonomy.
	 *
	 * See https://developer.wordpress.org/reference/functions/register_taxonomy/.
	 */
	public static function register(
		string $singular_name,
		string $plural_name,
		array $post_types,
		array $args = array()
	): void {
		// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment
		$labels = array(
			'name'              => $plural_name,
			'singular_name'     => $singular_name,
			'search_items'      => sprintf( __( 'Search %s', 'somoscuatro-theme' ), $plural_name ),
			'all_items'         => sprintf( __( 'All %s', 'somoscuatro-theme' ), $plural_name ),
			'parent_item'       => sprintf( __( 'Parent %s', 'somoscuatro-theme' ), $singular_name ),
			'parent_item_colon' => sprintf( __( 'Parent %s', 'somoscuatro-theme' ), $singular_name ),
			'edit_item'         => sprintf( __( 'Edit %s', 'somoscuatro-theme' ), $singular_name ),
			'update_item'       => sprintf( __( 'Update %s', 'somoscuatro-theme' ), $singular_name ),
			'add_new_item'      => sprintf( __( 'Add New %s', 'somoscuatro-theme' ), $singular_name ),
			'new_item_name'     => sprintf( __( 'New %s', 'somoscuatro-theme' ), $singular_name ),
			'menu_name'         => $plural_name,
		);
		// phpcs:enable WordPress.WP.I18n.MissingTranslatorsComment

		$args = wp_parse_args(
			$args,
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'query_var'         => true,
			)
		);

		$args['labels'] = $labels;

		register_taxonomy(
			str_replace( '-', '_', sanitize_title( $singular_name ) ),
			$post_types,
			$args
		);
	}

}
