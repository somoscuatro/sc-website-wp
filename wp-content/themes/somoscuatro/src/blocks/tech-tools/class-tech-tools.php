<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Tech_Tools;

use Somoscuatro\Theme\Attributes\Filter;

use Somoscuatro\Theme\Blocks\Block;
use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * Block main functionality.
 */
class Tech_Tools extends Block {

	use Filesystem;

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_tech_tools';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Tech Tools', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'                  => 'field_' . self::$acf_block_prefix . '_tech_tools_areas',
					'label'                => 'Tech Tools Areas',
					'name'                 => self::$acf_block_prefix . '_tech_tools_areas',
					'type'                 => 'taxonomy',
					'required'             => true,
					'taxonomy'             => 'tech_tools_area',
					'add_term'             => 0,
					'return_format'        => 'object',
					'field_type'           => 'multi_select',
					'bidirectional'        => 0,
					'multiple'             => 0,
					'allow_null'           => 0,
					'bidirectional_target' => array(),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/tech-tools',
					),
				),
			),
		);
	}

	/**
	 * Sets a custom context for this specific block.
	 *
	 * @param array $context The Timber context.
	 *
	 * @return array The modified Timber context.
	 */
	public function set_custom_context( array $context ): array {
		$tech_tools_logos = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type'      => 'tech-tool',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				'tax_query'      => array(
					array(
						'taxonomy' => 'tech_tools_area',
						'field'    => 'object',
						'terms'    => wp_list_pluck( $context['tech_tools_areas'], 'term_id' ),
					),
				),
			)
		);

		$context['tech_tools_logos'] = array_map(
			function ( $tech_tools_logo ) {
				return array(
					'id'               => $tech_tools_logo->ID,
					'title'            => $tech_tools_logo->post_title,
					'image'            => acf_get_attachment( get_post_thumbnail_id( $tech_tools_logo->ID ) )['url'] ?? '',
					'tech_tools_areas' => htmlspecialchars( wp_json_encode( wp_list_pluck( get_the_terms( $tech_tools_logo->ID, 'tech_tools_area' ), 'slug' ) ), ENT_QUOTES, 'UTF-8' ),
				);
			},
			$tech_tools_logos
		);

		return $context;
	}

	/**
	 * Register block assets.
	 */
	public function register_assets(): void {
		wp_register_script(
			'alpine',
			'https://unpkg.com/alpinejs@3.5.0/dist/cdn.min.js',
			array(),
			'3.5.0',
			array(
				'footer'   => false,
				'strategy' => 'async',
			)
		);
	}
}
