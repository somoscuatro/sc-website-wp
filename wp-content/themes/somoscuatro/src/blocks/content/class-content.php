<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Content;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class Content extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = 'block_content';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Content', 'somoscuatro-theme' ),
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
					'key'          => 'field_' . self::$acf_block_prefix . '_columns',
					'label'        => 'Columns',
					'name'         => self::$acf_block_prefix . '_columns',
					'type'         => 'repeater',
					'layout'       => 'row',
					'min'          => 1,
					'max'          => 6,
					'button_label' => __( 'Add Column', 'somoscuatro-theme' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_title',
							'label'           => __( 'Title', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_title',
							'type'            => 'text',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_columns',
						),
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_text',
							'label'           => __( 'Title', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_text',
							'type'            => 'textarea',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_columns',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/content',
					),
				),
			),
		);
	}
}
