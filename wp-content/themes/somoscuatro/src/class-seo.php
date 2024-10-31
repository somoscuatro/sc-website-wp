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
	 * Redirects Blog Posts.
	 *
	 * We name posts as `insights`.
	 */
	#[Action( 'template_redirect' )]
	public function redirect_posts(): void {
		global $post;

		if ( ! is_object( $post ) || 'post' !== $post->post_type ) {
			return;
		}

		$query_args      = add_query_arg( array() );
		$post_url_prefix = sprintf( '/%s/', $this->get_posts_prefix() );

		if ( ! str_starts_with( $query_args, $post_url_prefix ) ) {
			$url = preg_replace( '@/+@', '/', sprintf( '%s%s', $post_url_prefix, $query_args ) );

			wp_safe_redirect( $url, 301 );
			exit();
		}
	}

	/**
	 * Adds a Rewrite Rule for Blog Posts.
	 */
	#[Action( 'init', accepted_args: 0 )]
	public function rewrite_rules(): void {
		add_rewrite_rule(
			sprintf( '^%s/([^/]+)/?$', $this->get_posts_prefix() ),
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
	public function change_permalink_structure( string $permalink, WP_Post $post ): string {
		if ( 'post' === $post->post_type ) {
			$permalink = home_url( sprintf( '/%s/', $this->get_posts_prefix() ) . $post->post_name . '/' );
		}

		return $permalink;
	}

	/**
	 * Customize Breadcrumbs Links.
	 *
	 * @param array $links The Breadcrumb Links.
	 * @return array The modified Breadcrumb Links.
	 */
	#[Filter( 'wpseo_breadcrumb_links' )]
	public function my_custom_breadcrumb_links( array $links ): array {
		if ( is_front_page() ) {
			return array();
		}

		if ( is_singular( 'service' ) ) {
			$parent = array(
				'url'  => get_permalink( get_theme_mod( 'services_page' ) ),
				'text' => __( 'Services', 'somoscuatro-theme' ),
			);
		}

		if ( is_singular( 'case-study' ) ) {
			$parent = array(
				'url'  => get_permalink( get_theme_mod( 'case_studies_page' ) ),
				'text' => __( 'Case Studies', 'somoscuatro-theme' ),
			);
		}

		if ( is_singular( 'glossary-term' ) ) {
			$parent = array(
				'url'  => get_permalink( get_theme_mod( 'glossary_page' ) ),
				'text' => __( 'Glossary', 'somoscuatro-theme' ),
			);
		}

		if ( ! empty( $parent ) ) {
			array_splice( $links, 1, 0, array( $parent ) );
		}

		foreach ( $links as $index => &$link ) {
			if ( $index < count( $links ) - 1 ) {
				$link['text'] = '<span class="text-sm hover:underline">' . $link['text'] . '</span>';
			} else {
				$link['text'] = '<span class="text-sm">' . $link['text'] . '</span>';
			}
		}

		return $links;
	}

	/**
	 * Retrieves the prefix used for blog posts URLs.
	 *
	 * @return string The prefix for blog posts.
	 */
	private function get_posts_prefix(): string {
		return sprintf( '%s', _x( 'insights', 'Posts prefix to be used in url/slug', 'somoscuatro-theme' ) );
	}
}
