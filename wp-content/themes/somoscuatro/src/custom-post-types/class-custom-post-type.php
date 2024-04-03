<?php
/**
 * Custom Post related functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Post_Types;

/**
 * Custom Post related functionality.
 */
class Custom_Post_Type {

	/**
	 * Custom Post Type singular name.
	 *
	 * @var string
	 */
	protected string $singular_name = '';

	/**
	 * Custom Post Type plural name.
	 *
	 * @var string
	 */
	protected string $plural_name = '';

	/**
	 * Custom Post Type default arguments.
	 *
	 * @var array
	 */
	protected array $args = array(
		'supports'           => array( 'title', 'editor', 'page-attributes' ),
		'has_archive'        => true,
		'hierarchical'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'show_in_rest'       => false,
	);

	/**
	 * Registers a Custom Post Type.
	 *
	 * See https://developer.wordpress.org/reference/functions/register_post_type/.
	 */
	public function init(): void {
		// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment
		$labels = array(
			'name'               => $this->plural_name,
			'singular_name'      => $this->singular_name,
			'add_new'            => __( 'Add New', 'somoscuatro-theme' ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'somoscuatro-theme' ), $this->singular_name ),
			'edit'               => __( 'Edit', 'somoscuatro-theme' ),
			'edit_item'          => sprintf( __( 'Edit %s', 'somoscuatro-theme' ), $this->singular_name ),
			'new_item'           => sprintf( __( 'New %s', 'somoscuatro-theme' ), $this->singular_name ),
			'view'               => __( 'View', 'somoscuatro-theme' ),
			'view_item'          => sprintf( __( 'View %s', 'somoscuatro-theme' ), $this->singular_name ),
			'search_items'       => sprintf( __( 'Search %s', 'somoscuatro-theme' ), $this->plural_name ),
			'not_found'          => sprintf( __( 'No %s found', 'somoscuatro-theme' ), $this->plural_name ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'somoscuatro-theme' ), $this->plural_name ),
			'parent'             => sprintf( __( 'Parent %s', 'somoscuatro-theme' ), $this->singular_name ),
		);
		// phpcs:enable WordPress.WP.I18n.MissingTranslatorsComment

		$this->args['labels'] = $labels;

		register_post_type( sanitize_title( $this->singular_name ), $this->args );
	}
}
