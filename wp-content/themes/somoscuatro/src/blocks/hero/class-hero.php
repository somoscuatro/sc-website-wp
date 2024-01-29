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
	protected static $acf_block_prefix = 'block_hero';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Hero', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_headline',
					'label'    => __( 'Headline', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_headline',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_text',
					'label'    => __( 'Text', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_text',
					'type'     => 'textarea',
					'required' => true,
				),
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_image',
					'label' => __( 'Image', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_image',
					'type'  => 'image',
				),
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_button',
					'label' => __( 'Button', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_button',
					'type'  => 'link',
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
