<?php
/**
 * Gutenberg custom functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks;

use WP_Block_Editor_Context;

/**
 * Gutenberg custom functionality.
 */
class Loader {

	/**
	 * Initializes Gutenberg custom functionality.
	 */
	public static function init(): void {
		// Registers Gutenberg custom category.
		add_filter( 'block_categories_all', __CLASS__ . '::add_custom_block_category', 10, 2 );

		// Removes unwanted default WordPress Gutenberg block types.
		add_filter( 'allowed_block_types_all', __CLASS__ . '::allowed_block_types', 10, 0 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::remove_default_blocks_assets' );

		// Loads custom Gutenberg blocks.
		self::load();
	}

	/**
	 * Loads custom Gutenberg blocks.
	 */
	private static function load(): void {
		foreach ( glob( __DIR__ . '/*' ) as $block_dir ) {
			if ( ! is_dir( $block_dir ) ) {
				continue;
			}

			$class = implode(
				'_',
				array_map(
					'ucwords',
					explode( '-', basename( $block_dir ) )
				)
			);

			$full_class_path = sprintf( __NAMESPACE__ . '\%s\%s', $class, $class );

			if ( is_callable( array( $full_class_path, 'init' ) ) ) {
				$full_class_path::init();
			}
		}
	}

	/**
	 * Registers Gutenberg custom category.
	 *
	 * @param array[]                 $block_categories     Array of categories for block types.
	 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
	 */
	public static function add_custom_block_category( array $block_categories, WP_Block_Editor_Context $block_editor_context ): array {
		if ( ! ( $block_editor_context instanceof WP_Block_Editor_Context ) ) {
			return $block_categories;
		}

		return array_merge(
			$block_categories,
			array(
				array(
					'slug'  => 'somoscuatro',
					'title' => esc_html__( 'Somoscuatro Custom Blocks', 'somoscuatro-theme' ),
				),
			)
		);
	}

	/**
	 * Removes unwanted default WordPress Gutenberg block types.
	 *
	 * @return array The modified allowed block types.
	 */
	public static function allowed_block_types(): array {
		$block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();

		$blocks_to_remove = array(
			'core/archives'                     => null,
			'core/audio'                        => null,
			'core/avatar'                       => null,
			'core/block'                        => null,
			'core/button'                       => null,
			'core/buttons'                      => null,
			'core/calendar'                     => null,
			'core/categories'                   => null,
			'core/code'                         => null,
			'core/columns'                      => null,
			'core/comment-author-name'          => null,
			'core/comment-content'              => null,
			'core/comment-date'                 => null,
			'core/comment-edit-link'            => null,
			'core/comment-reply-link'           => null,
			'core/comment-template'             => null,
			'core/comments-pagination-next'     => null,
			'core/comments-pagination-numbers'  => null,
			'core/comments-pagination-previous' => null,
			'core/comments-pagination'          => null,
			'core/comments-title'               => null,
			'core/comments'                     => null,
			'core/cover'                        => null,
			'core/details'                      => null,
			'core/embed'                        => null,
			'core/file'                         => null,
			'core/footnotes'                    => null,
			'core/freeform'                     => null,
			'core/gallery'                      => null,
			'core/group'                        => null,
			'core/home-link'                    => null,
			'core/html'                         => null,
			'core/image'                        => null,
			'core/latest-comments'              => null,
			'core/latest-posts'                 => null,
			'core/legacy-widget'                => null,
			'core/loginout'                     => null,
			'core/media-text'                   => null,
			'core/missing'                      => null,
			'core/more'                         => null,
			'core/navigation-link'              => null,
			'core/navigation-submenu'           => null,
			'core/navigation'                   => null,
			'core/nextpage'                     => null,
			'core/page-list-item'               => null,
			'core/page-list'                    => null,
			'core/pattern'                      => null,
			'core/post-author-biography'        => null,
			'core/post-author-name'             => null,
			'core/post-author'                  => null,
			'core/post-comments-form'           => null,
			'core/post-comments'                => null,
			'core/post-content'                 => null,
			'core/post-date'                    => null,
			'core/post-excerpt'                 => null,
			'core/post-featured-image'          => null,
			'core/post-navigation-link'         => null,
			'core/post-template'                => null,
			'core/post-terms'                   => null,
			'core/post-title'                   => null,
			'core/preformatted'                 => null,
			'core/pullquote'                    => null,
			'core/query-no-results'             => null,
			'core/query-pagination-next'        => null,
			'core/query-pagination-numbers'     => null,
			'core/query-pagination-previous'    => null,
			'core/query-pagination'             => null,
			'core/query-title'                  => null,
			'core/query'                        => null,
			'core/quote'                        => null,
			'core/read-more'                    => null,
			'core/row'                          => null,
			'core/rss'                          => null,
			'core/search'                       => null,
			'core/separator'                    => null,
			'core/shortcode'                    => null,
			'core/site-logo'                    => null,
			'core/site-tagline'                 => null,
			'core/site-title'                   => null,
			'core/social-link'                  => null,
			'core/social-links'                 => null,
			'core/spacer'                       => null,
			'core/stack'                        => null,
			'core/tag-cloud'                    => null,
			'core/template-part'                => null,
			'core/term-description'             => null,
			'core/text-columns'                 => null,
			'core/verse'                        => null,
			'core/video'                        => null,
			'core/widget-group'                 => null,
			'wpseopress/breadcrumbs'            => null,
			'wpseopress/faq-block'              => null,
			'wpseopress/local-business-field'   => null,
			'wpseopress/local-business'         => null,
			'wpseopress/sitemap'                => null,
		);

		return array_keys( array_diff_key( $block_types, $blocks_to_remove ) );
	}

	/**
	 * Removes default Gutenberg blocks assets.
	 */
	public static function remove_default_blocks_assets(): void {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_script( 'wp-block-library' );
	}
}
