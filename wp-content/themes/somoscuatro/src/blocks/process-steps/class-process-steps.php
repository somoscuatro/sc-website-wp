<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Process_Steps;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class Process_Steps extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = 'block_process_steps';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Process Steps', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'          => 'field_' . self::$acf_block_prefix . '_steps',
					'label'        => __( 'Steps', 'somoscuatro-theme' ),
					'name'         => self::$acf_block_prefix . '_steps',
					'type'         => 'repeater',
					'required'     => 1,
					'layout'       => 'row',
					'button_label' => __( 'Add Step', 'somoscuatro-theme' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_step_title',
							'label'           => __( 'Title', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_step_title',
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_step',
						),
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_step_text',
							'label'           => __( 'Text', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_step_text',
							'type'            => 'textarea',
							'required'        => 1,
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_step',
						),
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_substeps',
							'label'           => __( 'Sub-Steps', 'somoscuatro-theme' ),
							'name'            => self::$acf_block_prefix . '_substeps',
							'type'            => 'repeater',
							'required'        => 1,
							'layout'          => 'row',
							'button_label'    => __( 'Add Sub-Step', 'somoscuatro-theme' ),
							'sub_fields'      => array(
								array(
									'key'             => 'field_' . self::$acf_block_prefix . '_substep_title',
									'label'           => __( 'Title', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_substep_title',
									'type'            => 'text',
									'required'        => 1,
									'parent_repeater' => 'field_' . self::$acf_block_prefix . '_substeps',
								),
								array(
									'key'             => 'field_' . self::$acf_block_prefix . '_substep_text',
									'label'           => __( 'Text', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_substep_text',
									'type'            => 'textarea',
									'required'        => 1,
									'parent_repeater' => 'field_' . self::$acf_block_prefix . '_substeps',
								),
								array(
									'key'             => 'field_' . self::$acf_block_prefix . '_capabilities',
									'label'           => __( 'Capabilities', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_capabilities',
									'type'            => 'repeater',
									'required'        => 1,
									'layout'          => 'row',
									'button_label'    => __( 'Add Capability', 'somoscuatro-theme' ),
									'sub_fields'      => array(
										array(
											'key'      => 'field_' . self::$acf_block_prefix . '_capability',
											'label'    => __( 'Capability', 'somoscuatro-theme' ),
											'name'     => self::$acf_block_prefix . '_capability',
											'type'     => 'text',
											'required' => 1,
											'parent_repeater' => 'field_' . self::$acf_block_prefix . '_capabilities',
										),
									),
									'parent_repeater' => 'field_' . self::$acf_block_prefix . '_substeps',
								),
							),
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_step',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/process-steps',
					),
				),
			),
		);
	}
}
