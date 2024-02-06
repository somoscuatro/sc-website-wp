<?php
/**
 * SEO custom functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

/**
 * SEO custom functionality.
 */
class SEO {

	/**
	 * SEO custom functionality initialization.
	 */
	public static function init(): void {
		add_filter( 'wpseo_sitemap_exclude_post_type', __CLASS__ . '::sitemap_exclude_post_type', 10, 2 );
		add_filter( 'wpseo_sitemap_exclude_taxonomy', __CLASS__ . '::sitemap_exclude_taxonomy', 10, 2 );
		add_filter( 'wpseo_sitemap_exclude_author', '__return_false' );
	}

	/**
	 * Excludes post types from sitemap.
	 *
	 * @param bool   $excluded True if the post type is excluded by default.
	 * @param string $post_type The post type.
	 *
	 * @return bool True if the post type should be excluded.
	 */
	public static function sitemap_exclude_post_type( bool $excluded, string $post_type ): bool {
		$excluded_post_types = array(
			'faq',
			'tech-tool',
			'testimonial',
		);

		return in_array( $post_type, $excluded_post_types, true );
	}

	/**
	 * Excludes taxonomies from sitemap.
	 *
	 * @param bool   $excluded True if the taxonomy is excluded by default.
	 * @param string $taxonomy The taxonomy.
	 *
	 * @return bool True if the taxonomy should be excluded.
	 */
	public static function sitemap_exclude_taxonomy( bool $excluded, string $taxonomy ): bool {
		$excluded_taxonomies = array(
			'category',
			'tech_tools_area',
		);

		return in_array( $taxonomy, $excluded_taxonomies, true );
	}
}
