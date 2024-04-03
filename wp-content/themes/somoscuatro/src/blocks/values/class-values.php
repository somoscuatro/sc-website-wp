<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Values;

use Somoscuatro\Theme\Blocks\Block;
use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * Block main functionality.
 */
class Values extends Block {

	use Filesystem;

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_values';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Values', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'          => 'field_' . self::$acf_block_prefix . '_groups',
					'label'        => __( 'Groups', 'somoscuatro-theme' ),
					'name'         => self::$acf_block_prefix . '_groups',
					'type'         => 'repeater',
					'layout'       => 'row',
					'min'          => 1,
					'button_label' => __( 'Add Values Group', 'somoscuatro-theme' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_image',
							'label'           => __( 'Group Image', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_image',
							'type'            => 'image',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_groups',
						),
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_group_title',
							'label'           => __( 'Group Title', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_group_title',
							'type'            => 'text',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_groups',
						),
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_group_text',
							'label'           => __( 'Group Text', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_group_text',
							'type'            => 'textarea',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_groups',
						),
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_group_values',
							'label'           => __( 'Values', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_group_values',
							'type'            => 'repeater',
							'layout'          => 'row',
							'button_label'    => __( 'Add Value', 'somoscuatro-theme' ),
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_groups',
							'sub_fields'      => array(
								array(
									'key'             => 'field_' . self::$acf_block_prefix . '_value_title',
									'label'           => __( 'Group Title', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_value_title',
									'type'            => 'text',
									'parent_repeater' => 'field_' . self::$acf_block_prefix . '_group_values',
								),
								array(
									'key'             => 'field_' . self::$acf_block_prefix . '_value_text',
									'label'           => __( 'Group Text', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_value_text',
									'type'            => 'textarea',
									'parent_repeater' => 'field_' . self::$acf_block_prefix . '_group_values',
								),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/values',
					),
				),
			),
		);
	}
}
