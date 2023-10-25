<?php
/**
 * Services Post functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Cpt;

use Somoscuatro\Theme\Cpt\Custom_Post;
use Somoscuatro\Theme\Cpt\Custom_Taxonomy;

/**
 * Services Post functionality.
 */
class Services {

	/**
	 * Initializes Services CPT functionality.
	 */
	public static function init(): void {
		self::register_cpt();
		self::register_taxonomy();
		self::register_acf_custom_fields();

		// Removes post thumbnail from Service CPT.
		add_filter( 'post_thumbnail_html', __CLASS__ . '::remove_post_thumbnail' );
	}

	/**
	 * Registers Services CPT.
	 */
	private static function register_cpt(): void {
		Custom_Post::register(
			'Service',
			'Services',
			array(
				'rewrite'      => array( 'slug' => 'services' ),
				// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
				'menu_icon'    => 'data:image/svg+xml;base64,' . base64_encode(
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 016.775-5.025.75.75 0 01.313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 011.248.313 5.25 5.25 0 01-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 112.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0112 6.75zM4.117 19.125a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008z" clip-rule="evenodd" /><path d="M10.076 8.64l-2.201-2.2V4.874a.75.75 0 00-.364-.643l-3.75-2.25a.75.75 0 00-.916.113l-.75.75a.75.75 0 00-.113.916l2.25 3.75a.75.75 0 00.643.364h1.564l2.062 2.062 1.575-1.297z" /><path fill-rule="evenodd" d="M12.556 17.329l4.183 4.182a3.375 3.375 0 004.773-4.773l-3.306-3.305a6.803 6.803 0 01-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 00-.167.063l-3.086 3.748zm3.414-1.36a.75.75 0 011.06 0l1.875 1.876a.75.75 0 11-1.06 1.06L15.97 17.03a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>'
				),
				'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Registers Services Category.
	 */
	private static function register_taxonomy(): void {
		Custom_Taxonomy::register(
			'Services Category',
			'Services Categories',
			array( 'service' )
		);
	}

	/**
	 * Register Services ACF Custom Fields.
	 */
	public static function register_acf_custom_fields(): void {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_cpt_services',
					'title'    => __( 'CPT: Services', 'somoscuatro-theme' ),
					'fields'   => array(
						array(
							'key'      => 'field_cpt_services_short_excerpt',
							'label'    => __( 'Short Excerpt', 'somoscuatro-theme' ),
							'name'     => 'cpt_services_short_excerpt',
							'type'     => 'textarea',
							'required' => true,
						),
						array(
							'key'      => 'field_cpt_services_excerpt',
							'label'    => __( 'Excerpt', 'somoscuatro-theme' ),
							'name'     => 'cpt_services_excerpt',
							'type'     => 'textarea',
							'required' => true,
						),
						array(
							'key'      => 'field_cpt_services_icon',
							'label'    => __( 'Icon', 'somoscuatro-theme' ),
							'name'     => 'cpt_services_icon',
							'type'     => 'image',
							'required' => true,
						),
					),
					'location' => array(
						array(
							array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'service',
							),
						),
					),
				)
			);
		}
	}

	/**
	 * Removes post thumbnail from Services CPT.
	 *
	 * @param string $html The Service thumbnail HTML.
	 *
	 * @return string The modified Service thumbnail HTML.
	 */
	public static function remove_post_thumbnail( string $html ): string {
		if ( is_singular( 'service' ) ) {
			return '';
		}

		return $html;
	}

}
