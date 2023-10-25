<?php
/**
 * Theme's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Helpers\Setup;

/**
 * Main theme functionality.
 */
class Theme {

	use Setup;

	/**
	 * Theme naming prefix.
	 *
	 * @var string
	 */
	const PREFIX = 'somoscuatro_theme';

	/**
	 * Initializes theme functionality after setup.
	 */
	public static function after_setup_theme(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		Navigation::register();
	}

	/**
	 * Initializes theme functionality.
	 *
	 * @hook init<Function>
	 */
	public static function init(): void {
		// Disables WordPress default image sizes.
		add_filter( 'intermediate_image_sizes', __CLASS__ . '::disable_wp_default_image_sizes' );

		// Adds page slug to body class.
		add_filter( 'body_class', __CLASS__ . '::body_class' );

		// Enqueues frontend theme styles and scripts.
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_assets', 100 );

		// Enqueues style for the login page.
		add_action( 'login_enqueue_scripts', __CLASS__ . '::login_enqueue_scripts' );

		Blocks::init();
		Navigation::init();
		Services::init();

		if ( is_admin() ) {
			return;
		}
	}

	/**
	 * Disables WordPress default image sizes.
	 *
	 * @param array $sizes The WordPress image sizes.
	 *
	 * @return array The modified sizes.
	 */
	public static function disable_wp_default_image_sizes( array $sizes ): array {
		$targets = array( 'thumbnail', 'medium', 'medium_large', 'large', '1536x1536', '2048x2048' );

		foreach ( $sizes as $size_index => $size ) {
			if ( in_array( $size, $targets, true ) ) {
				unset( $sizes[ $size_index ] );
			}
		}

		return $sizes;
	}

	/**
	 * Adds page slug to body classes.
	 *
	 * @param array $classes The body classes.
	 *
	 * @return array The modified body classes.
	 */
	public static function body_class( array $classes ): array {
		if ( is_single() || is_page() && ! is_front_page() ) {
			if ( ! in_array( basename( get_permalink() ), $classes, true ) ) {
				$classes[] = basename( get_permalink() );
			}
		}
		if ( is_page() && has_post_parent() ) {
			global $post;
			if ( ! in_array( basename( get_permalink( $post->post_parent ) ), $classes, true ) ) {
				$classes[] = basename( get_permalink( $post->post_parent ) );
			}
		}
		if ( is_404() ) {
			$classes[] = '404';
		}

		return $classes;
	}

	/**
	 * Enqueues frontend theme styles and scripts.
	 */
	public static function enqueue_assets(): void {
		// Theme styles.
		wp_enqueue_style( self::PREFIX, self::get_base_url() . '/dist/styles/main.css', false, self::get_version( 'styles/main.css' ) );
	}

	/**
	 * Enqueues style for the login page.
	 */
	public static function login_enqueue_scripts(): void {}

	/**
	 * Loads the theme translation domain.
	 *
	 * @hook plugins_loaded<Function>
	 */
	public static function load_text_domain(): void {
		load_plugin_textdomain( 'somoscuatro-theme', false, 'somoscuatro/languages/' );
	}
}
