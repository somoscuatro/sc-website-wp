<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\CTA;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class CTA extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = 'block_cta';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: CTA', 'somoscuatro-theme' ),
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
					'key'      => 'field_' . self::$acf_block_prefix . '_text',
					'label'    => __( 'Title', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_text',
					'type'     => 'textarea',
					'required' => true,
				),
				array(
					'key'          => 'field_' . self::$acf_block_prefix . '_buttons',
					'label'        => 'Columns',
					'name'         => self::$acf_block_prefix . '_buttons',
					'type'         => 'repeater',
					'layout'       => 'row',
					'min'          => 1,
					'max'          => 2,
					'button_label' => __( 'Add Button', 'somoscuatro-theme' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_button',
							'label'           => __( 'Button', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_button',
							'type'            => 'link',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_buttons',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/cta',
					),
				),
			),
		);
	}
}
