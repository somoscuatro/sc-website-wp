<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Hero;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class Hero extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_hero';

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
					'key'           => 'field_' . self::$acf_block_prefix . '_layout',
					'label'         => __( 'Layout', 'somoscuatro-theme' ),
					'name'          => self::$acf_block_prefix . '_layout',
					'type'          => 'true_false',
					'required'      => true,
					'default_value' => 1,
					'ui'            => 1,
					'ui_on_text'    => __( 'Horizontal', 'somoscuatro-theme' ),
					'ui_off_text'   => __( 'Vertical', 'somoscuatro-theme' ),
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_title',
					'label'    => __( 'Title', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_title',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_text',
					'label' => __( 'Text', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_text',
					'type'  => 'wysiwyg',
				),
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_image',
					'label' => __( 'Image', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_image',
					'type'  => 'image',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/hero',
					),
				),
			),
		);
	}
}
