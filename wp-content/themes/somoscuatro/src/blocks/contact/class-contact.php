<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Contact;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class Contact extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = 'block_contact';

	/**
	 * Registers activation hook callback.
	 *
	 * @implements register_activation_hook<Function>
	 */
	public static function init(): void {
		parent::init();

		// Conditionally loads the contact-form-7 assets.
		add_filter( 'wpcf7_load_css', __CLASS__ . '::wpcf7_load_assets' );
		add_filter( 'wpcf7_load_js', __CLASS__ . '::wpcf7_load_assets' );
	}

	/**
	 * Conditionally loads the contact-form-7 assets.
	 *
	 * As a performance improvement, contact-form-7 styles and scripts are only
	 * loaded in the contact page.
	 *
	 * @return bool True if the asset should be loaded.
	 */
	public static function wpcf7_load_assets(): bool {
		if ( is_page( 'contact-us' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Contact', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_title',
					'label' => __( 'Title', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_contact_form_id',
					'label' => __( 'Contact Form ID', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_contact_form_id',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_' . self::$acf_block_prefix . '_schedule_a_call',
					'label'         => __( 'Enable Schedule a Call', 'somoscuatro-theme' ),
					'name'          => self::$acf_block_prefix . '_schedule_a_call',
					'type'          => 'true_false',
					'required'      => true,
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'               => 'field_' . self::$acf_block_prefix . '_schedule_a_call_title',
					'label'             => __( 'Title', 'somoscuatro-theme' ),
					'name'              => self::$acf_block_prefix . '_schedule_a_call_title',
					'type'              => 'text',
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_' . self::$acf_block_prefix . '_schedule_a_call',
								'operator' => '==',
								'value'    => '1',
							),
						),
					),
				),
				array(
					'key'               => 'field_' . self::$acf_block_prefix . '_schedule_a_call_text',
					'label'             => __( 'Text', 'somoscuatro-theme' ),
					'name'              => self::$acf_block_prefix . '_schedule_a_call_text',
					'type'              => 'textarea',
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_' . self::$acf_block_prefix . '_schedule_a_call',
								'operator' => '==',
								'value'    => '1',
							),
						),
					),
				),
				array(
					'key'   => 'field_' . self::$acf_block_prefix . '_details',
					'label' => __( 'Contact Details', 'somoscuatro-theme' ),
					'name'  => self::$acf_block_prefix . '_details',
					'type'  => 'wysiwyg',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/contact',
					),
				),
			),
		);
	}
}
