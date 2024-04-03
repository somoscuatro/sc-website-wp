<?php
/**
 * Glossary Custom Post Type functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Custom_Post_Types\Post_Types;

use Somoscuatro\Theme\Custom_Post_Types\Custom_Post_Type;

/**
 * Glossary Custom Post Type functionality.
 */
class Glossary extends Custom_Post_Type {

	/**
	 * Custom Post Type singular name.
	 *
	 * @var string
	 */
	protected string $singular_name = 'Glossary Term';

	/**
	 * Custom Post Type plural name.
	 *
	 * @var string
	 */
	protected string $plural_name = 'Glossary Terms';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$args = array(
			'rewrite'      => array( 'slug' => 'glossary' ),
				// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
			'menu_icon'    => 'data:image/svg+xml;base64,' . base64_encode(
				'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"> <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" /> </svg>'
			),
			'has_archive'  => false,
			'supports'     => array( 'title', 'editor', 'revisions' ),
			'show_in_rest' => true,
			'hierarchical' => false,
		);

		$this->args = wp_parse_args( $this->args, $args );
	}
}
