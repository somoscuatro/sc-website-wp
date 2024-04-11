<?php
/**
 * Contains Somoscuatro\Theme\SEO Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Attributes\Filter;

use WP_Post;

/**
 * SEO custom functionality.
 */
class SEO {

	/**
	 * Excludes Post Types from Sitemap.
	 *
	 * @param bool   $excluded True If the Post Type Is Excluded by Default.
	 * @param string $post_type The Post Type.
	 *
	 * @return bool True If the Post Type Should Be Excluded.
	 */
	#[Filter( 'wpseo_sitemap_exclude_post_type', accepted_args: 2 )]
	public static function sitemap_exclude_post_type( bool $excluded, string $post_type ): bool {
		$excluded_post_types = array(
			'faq',
			'tech-tool',
			'testimonial',
		);

		return in_array( $post_type, $excluded_post_types, true );
	}

	/**
	 * Excludes Taxonomies from Sitemap.
	 *
	 * @param bool   $excluded True If the Taxonomy Is Excluded by Default.
	 * @param string $taxonomy The Taxonomy.
	 *
	 * @return bool True If the Taxonomy Should Be Excluded.
	 */
	#[Filter( 'wpseo_sitemap_exclude_taxonomy', accepted_args: 2 )]
	public static function sitemap_exclude_taxonomy( bool $excluded, string $taxonomy ): bool {
		$excluded_taxonomies = array(
			'category',
			'tech_tools_area',
		);

		return in_array( $taxonomy, $excluded_taxonomies, true );
	}

	/**
	 * Excludes Authors from Sitemap.
	 *
	 * @return boolean False.
	 */
	#[Filter( 'wpseo_sitemap_exclude_author', accepted_args: 0 )]
	public function sitemap_exclude_author(): bool {
		return false;
	}

	/**
	 * Adds a Rewrite Rule for Blog Posts.
	 */
	#[Action( 'init', accepted_args: 0 )]
	public function rewrite_rules(): void {
		add_rewrite_rule(
			'^insights/([^/]+)/?$',
			'index.php?post_type=post&name=$matches[1]',
			'top'
		);
	}

	/**
	 * Changes Blog Posts Permalink Structure.
	 *
	 * @param string  $permalink The Post Permalink.
	 * @param WP_Post $post The Post Object.
	 */
	#[Filter( 'post_link', priority: 1, accepted_args: 2 )]
	public function change_permalink_structure( string $permalink, WP_Post $post ) {
		if ( is_object( $post ) && 'post' === $post->post_type ) {
			$permalink = home_url( '/insights/' . $post->post_name . '/' );
		}

		return $permalink;
	}
}
