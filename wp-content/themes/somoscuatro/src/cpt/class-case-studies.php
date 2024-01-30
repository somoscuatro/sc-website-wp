<?php
/**
 * Case Studies Post functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Cpt;

use Somoscuatro\Theme\Cpt\Custom_Post;
use Somoscuatro\Theme\Cpt\Custom_Taxonomy;

/**
 * Case Studies Post functionality.
 */
class Case_Studies {

	/**
	 * Initializes Case Studies CPT functionality.
	 */
	public static function init(): void {
		self::register_cpt();
		self::register_taxonomy();

		// Removes post thumbnail from Case Study CPT.
		add_filter( 'post_thumbnail_html', __CLASS__ . '::remove_post_thumbnail' );
	}

	/**
	 * Registers Case Studies CPT.
	 */
	private static function register_cpt(): void {
		Custom_Post::register(
			'Case Study',
			'Case Studies',
			array(
				'rewrite'      => array( 'slug' => 'case-studies' ),
				// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
				'menu_icon'    => 'data:image/svg+xml;base64,' . base64_encode(
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"> <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.04 16.5l.5-1.5h6.42l.5 1.5H8.29zm7.46-12a.75.75 0 00-1.5 0v6a.75.75 0 001.5 0v-6zm-3 2.25a.75.75 0 00-1.5 0v3.75a.75.75 0 001.5 0V9zm-3 2.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5z" clip-rule="evenodd" /> </svg>'
				),
				'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Registers Case Studies Category.
	 */
	private static function register_taxonomy(): void {
		Custom_Taxonomy::register(
			'Case Study Category',
			'Case Studies Categories',
			array( 'case-study' )
		);
	}

	/**
	 * Removes post thumbnail from Case Studies CPT.
	 *
	 * @param string $html The Case Study thumbnail HTML.
	 *
	 * @return string The modified Case Study thumbnail HTML.
	 */
	public static function remove_post_thumbnail( string $html ): string {
		if ( is_singular( 'case_study' ) ) {
			return '';
		}

		return $html;
	}

}
