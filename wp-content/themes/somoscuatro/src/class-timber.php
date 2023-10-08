<?php
/**
 * Timber main functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;
use Twig\TwigFunction;

/**
 * Timber configuration.
 */
class Timber {

	/**
	 * Timber initialization.
	 *
	 * @throws \Exception If Timber class does not exist.
	 */
	public static function init(): void {
		TimberLibrary::init();

		if ( ! class_exists( 'Timber' ) ) {
			throw new \Exception( 'Timber not found.' );
		}

		TimberLibrary::$dirname    = array(
			'templates',
			'templates/components',
			'templates/partials',
		);
		TimberLibrary::$autoescape = false;

		// Adds additional variables to global context.
		add_filter( 'timber/context', __CLASS__ . '::add_to_global_context' );

		// Adds custom functions to Twig.
		add_filter( 'timber/twig', __CLASS__ . '::extend_timber_functions' );
	}

	/**
	 * Adds additional variables to global context.
	 *
	 * @param array $context Timber context.
	 *
	 * @return array Global context data.
	 */
	public static function add_to_global_context( array $context ): array {
		$context['homepage_url'] = get_home_url();

		$context = self::get_menus( $context );

		return $context;
	}

	/**
	 * Adds registered menus to Timber global context.
	 *
	 * As documented in
	 * https://timber.github.io/docs/v2/guides/menus/#set-up-all-menus-globally
	 * Timber allows to add the registered menu to the global context. For unknown
	 * reasons, this is not fully working for us since the current menu item is
	 * not set (always false) and WordPress current item classes (e.g.
	 * current-menu-item) are not added.
	 *
	 * @param array $context The Timber global context.
	 *
	 * @return array The updated Timber global context.
	 */
	public static function get_menus( array $context ): array {
		foreach ( array_keys( get_registered_nav_menus() ) as $location ) {
			if ( ! has_nav_menu( $location ) ) {
				continue;
			}

			$context[ $location ] = TimberLibrary::get_menu( $location );
		}

		return $context;
	}

	/**
	 * Adds custom functions to Twig.
	 *
	 * @param \Twig\Environment $twig The Twig Environment.
	 *
	 * @return \Twig\Environment The modified Twig Environment.
	 *
	 * @phpstan-ignore-next-line
	 */
	public static function extend_timber_functions( \Twig\Environment $twig ): \Twig\Environment {
		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'enqueue_script', __CLASS__ . '::enqueue_script' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_static_image', __CLASS__ . '::get_static_image' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_image_srcset', __CLASS__ . '::get_image_srcset' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_server_request_uri', __CLASS__ . '::get_server_request_uri' )
		);

		return $twig;
	}

	/**
	 * Enqueue block scripts.
	 *
	 * @param string $handle The script handle.
	 */
	public static function enqueue_script( string $handle ): void {
		wp_enqueue_script( $handle );
	}

	/**
	 * Get static image URL.
	 *
	 * @param string $file_name The image name.
	 *
	 * @return string The image URL.
	 */
	public static function get_static_image( string $file_name ): string {
		return esc_url( get_stylesheet_directory_uri() ) . '/assets/images/' . $file_name;
	}

	/**
	 * Gets images source sets.
	 *
	 * @param array $sizes The WordPress image sizes.
	 * @param array $allowed_sizes The image sizes to generate for this particular image.
	 *
	 * @return array The image source set.
	 */
	public static function get_image_srcset( array $sizes, array $allowed_sizes = array( 'xs', 'sm', 'md', 'lg', 'xl' ) ): array {
		$srcset = array();

		if ( in_array( 'xs', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset' => $sizes['xs'],
				'media'  => '(max-width: 400px)',
				'width'  => $sizes['xs-width'],
				'height' => $sizes['xs-height'],
			);
		}

		if ( in_array( 'sm', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset' => $sizes['sm'],
				'media'  => '(max-width: 640px)',
				'width'  => $sizes['sm-width'],
				'height' => $sizes['sm-height'],
			);
		}

		if ( in_array( 'md', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset' => $sizes['md'],
				'media'  => '(max-width: 768px)',
				'width'  => $sizes['md-width'],
				'height' => $sizes['md-height'],
			);
		}

		if ( in_array( 'lg', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['lg'],
				'srcset@2x' => $sizes['lg@2x'],
				'media'     => '(max-width: 1024px)',
				'width'     => $sizes['lg-width'],
				'height'    => $sizes['lg-height'],
			);
		}

		if ( in_array( 'xl', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['xl'],
				'srcset@2x' => $sizes['xl@2x'],
				'media'     => '(max-width: 1280px)',
				'width'     => $sizes['xl-width'],
				'height'    => $sizes['xl-height'],
			);
		}

		return $srcset;
	}

	/**
	 * Gets the server request URI.
	 *
	 * @return string The server request URI.
	 */
	public static function get_server_request_uri(): string {
		return strtok( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), '?' );
	}
}
