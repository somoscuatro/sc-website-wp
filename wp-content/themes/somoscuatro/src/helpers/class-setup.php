<?php
/**
 * Methods related to theme setup.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Helpers;

/**
 * Methods related to theme setup.
 */
trait Setup {

	/**
	 * Base for asset URLs.
	 *
	 * @var string
	 */
	private static string $base_url = '';

	/**
	 * Returns file last modified time.
	 *
	 * @param string $file_path The file path relative to dist folder.
	 *
	 * @return int File last modified time.
	 */
	public static function get_version( string $file_path = '' ): int {
		$version = $file_path
			? filemtime( self::get_base_path() . '/dist/' . trim( $file_path, '/' ) )
			: filemtime( self::get_base_path() . '/dist/' );

		return (int) $version;
	}

	/**
	 * Returns the base URL of this theme.
	 *
	 * @return string Return theme URI.
	 */
	public static function get_base_url(): string {
		if ( ! self::$base_url ) {
			self::$base_url = get_stylesheet_directory_uri();
		}
		return self::$base_url;
	}

	/**
	 * The absolute filesystem base path of this plugin.
	 *
	 * @return string Return base path URI.
	 */
	public static function get_base_path(): string {
		return dirname( __DIR__, 2 );
	}
}
