<?php
/**
 * Contains Somoscuatro\Theme\Blocks\About_Us\About_Us Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\About_Us;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block Main Functionality.
 */
class About_Us extends Block {

	/**
	 * The Prefix Used for ACF Blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_about_us';

	/**
	 * Gets the ACF Block Fields.
	 *
	 * @return array The ACF Block Fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: About Us', 'somoscuatro-theme' ),
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
					'key'   => 'field_' . self::$acf_block_prefix . '_text',
					'label' => __( 'Text', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_text',
					'type'  => 'textarea',
				),
				array(
					'key'          => 'field_' . self::$acf_block_prefix . '_customers_logos',
					'label'        => __( 'Customers Logos', 'somoscuatro-theme' ),
					'name'         => self::$acf_block_prefix . '_customers_logos',
					'type'         => 'repeater',
					'layout'       => 'row',
					'min'          => 6,
					'max'          => 6,
					'button_label' => __( 'Add Customer Logo', 'somoscuatro-theme' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_customer_logo',
							'label'           => __( 'Customer Logo', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_customer_logo',
							'type'            => 'image',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_customers_logos',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/about-us',
					),
				),
			),
		);
	}
}
