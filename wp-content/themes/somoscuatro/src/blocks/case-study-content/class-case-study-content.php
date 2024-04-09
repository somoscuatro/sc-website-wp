<?php
/**
 * Contains Somoscuatro\Theme\Blocks\Case_Study_Content\Case_Study_Content Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Case_Study_Content;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block Main Functionality.
 */
class Case_Study_Content extends Block {

	/**
	 * The Prefix Used for ACF Blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_case_study_content';

	/**
	 * Gets the ACF Block Fields.
	 *
	 * @return array The ACF Block Fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Case Study Content', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_brand',
					'label'    => __( 'Brand', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_brand',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_location',
					'label'    => __( 'Location', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_location',
					'type'     => 'text',
					'required' => false,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_industry',
					'label'    => __( 'Industry', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_industry',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_services',
					'label'    => __( 'Services', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_services',
					'type'     => 'textarea',
					'required' => true,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_release',
					'label'    => __( 'Release', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_release',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_content',
					'label'    => __( 'Content', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_content',
					'type'     => 'wysiwyg',
					'required' => true,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/case-study-content',
					),
				),
			),
		);
	}
}
