<?php
/**
 * Custom Post related functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Cpt;

/**
 * Custom Post related functionality.
 */
class Custom_Post {

	/**
	 * Registers a Custom Post Type.
	 *
	 * @param string $singular_name The singular name for the CPT.
	 * @param string $plural_name   The plural name for the CPT.
	 * @param array  $args Arguments to register the CPT.
	 *
	 * See https://developer.wordpress.org/reference/functions/register_post_type/.
	 */
	public static function register(
		string $singular_name,
		string $plural_name,
		array $args = array()
	): void {
		// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment
		$labels = array(
			'name'               => $plural_name,
			'singular_name'      => $singular_name,
			'add_new'            => __( 'Add New', 'somoscuatro-theme' ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'somoscuatro-theme' ), $singular_name ),
			'edit'               => __( 'Edit', 'somoscuatro-theme' ),
			'edit_item'          => sprintf( __( 'Edit %s', 'somoscuatro-theme' ), $singular_name ),
			'new_item'           => sprintf( __( 'New %s', 'somoscuatro-theme' ), $singular_name ),
			'view'               => __( 'View', 'somoscuatro-theme' ),
			'view_item'          => sprintf( __( 'View %s', 'somoscuatro-theme' ), $singular_name ),
			'search_items'       => sprintf( __( 'Search %s', 'somoscuatro-theme' ), $plural_name ),
			'not_found'          => sprintf( __( 'No %s found', 'somoscuatro-theme' ), $plural_name ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'somoscuatro-theme' ), $plural_name ),
			'parent'             => sprintf( __( 'Parent %s', 'somoscuatro-theme' ), $singular_name ),
		);
		// phpcs:enable WordPress.WP.I18n.MissingTranslatorsComment

		$args = wp_parse_args(
			$args,
			array(
				'supports'           => array( 'title', 'editor', 'page-attributes' ),
				'has_archive'        => true,
				'hierarchical'       => true,
				'public'             => true,
				'publicly_queryable' => true,
				'show_in_rest'       => false,
			)
		);

		$args['labels'] = $labels;

		register_post_type( sanitize_title( $singular_name ), $args );
	}

}
