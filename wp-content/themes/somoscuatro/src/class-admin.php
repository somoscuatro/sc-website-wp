<?php
/**
 * Theme admin functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Helpers\Setup;

/**
 * Theme admin functionality.
 */
class Admin {

	use Setup;

	/**
	 * Initializes theme admin functionality.
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_admin_assets' );

		// Allows SVG images in media uploader.
		add_filter( 'upload_mimes', __CLASS__ . '::add_svg_support' );
	}

	/**
	 * Enqueues editor theme styles and scripts.
	 */
	public static function enqueue_admin_assets() {}

	/**
	 * Allows SVG images in media uploader.
	 *
	 * @param array $mimes The supported mime types.
	 *
	 * @return array The modified mime types.
	 */
	public static function add_svg_support( array $mimes ): array {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
