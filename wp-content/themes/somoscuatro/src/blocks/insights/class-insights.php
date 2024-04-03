<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Insights;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class Insights extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_insights';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Hero', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'           => 'field_' . self::$acf_block_prefix . '_bg_color',
					'label'         => __( 'Background Color', 'somoscuatro-theme' ),
					'name'          => self::$acf_block_prefix . '_bg_color',
					'type'          => 'color_picker',
					'required'      => 1,
					'return_format' => 'string',
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_title',
					'label'    => __( 'Title', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_title',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'           => 'field_' . self::$acf_block_prefix . '_number_of_posts',
					'label'         => __( 'Number of Posts', 'somoscuatro-theme' ),
					'type'          => 'range',
					'required'      => 1,
					'default_value' => 3,
					'min'           => 1,
					'max'           => 9,
				),
				array(
					'key'         => 'field_' . self::$acf_block_prefix . '_posts',
					'label'       => __( 'Posts', 'somoscuatro-theme' ),
					'name'        => self::$acf_block_prefix . '_posts',
					'type'        => 'relationship',
					'required'    => true,
					'post_type'   => array(
						0 => 'post',
					),
					'post_status' => array(
						0 => 'publish',
					),
					'taxonomy'    => '',
					'filters'     => array(
						0 => 'search',
						1 => 'taxonomy',
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/insights',
					),
				),
			),
		);
	}
}
