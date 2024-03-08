<?php
/**
 * Theme's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Helpers\Setup;

use Somoscuatro\Theme\Cpt\Case_Studies;
use Somoscuatro\Theme\Cpt\FAQs;
use Somoscuatro\Theme\Cpt\Services;
use Somoscuatro\Theme\Cpt\Tech_Tools;
use Somoscuatro\Theme\Cpt\Testimonials;

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

		// Custom Post Types.
		Case_Studies::init();
		FAQs::init();
		Services::init();
		Tech_Tools::init();
		Testimonials::init();

		Navigation::register();
	}

	/**
	 * Initializes theme functionality.
	 *
	 * @hook init<Function>
	 */
	public static function init(): void {
		// Cleanups WordPress defaults.
		self::cleanup_wp_defaults();
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::cleanup_wp_default_assets', 100 );

		// Registers custom images sizes.
		self::register_image_sizes();
		add_filter( 'wp_editor_set_quality', __CLASS__ . '::image_compression_quality', 10, 0 );
		add_filter( 'jpeg_quality', __CLASS__ . '::image_compression_quality', 10, 0 );

		// Adds page slug to body class.
		add_filter( 'body_class', __CLASS__ . '::body_class' );

		// Adds support for preloading stylesheets.
		add_filter( 'style_loader_tag', __CLASS__ . '::preload_stylesheets', 10, 2 );

		// Enqueues frontend theme styles and scripts.
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_assets', 100 );

		// Enqueues style for the login page.
		add_action( 'login_enqueue_scripts', __CLASS__ . '::login_enqueue_scripts' );

		ACF::init();
		Navigation::init();
		Blocks\Loader::init();
		SEO::init();

		// Adds site footer controls to the customizer.
		add_action( 'customize_register', __NAMESPACE__ . '\Customizer::add_customizer_footer_controls' );

		// Adds 404 controls to the customizer.
		add_action( 'customize_register', __NAMESPACE__ . '\Customizer::add_customizer_404_controls' );

		if ( is_admin() ) {
			return;
		}

		GTM::init();
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
	 * Cleanups WordPress defaults.
	 */
	public static function cleanup_wp_defaults(): void {
		// Disables WordPress default image sizes.
		add_filter( 'intermediate_image_sizes', __CLASS__ . '::disable_wp_default_image_sizes' );

		// Disables WordPress emojis.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	/**
	 * Cleanups WordPress default assets.
	 */
	public static function cleanup_wp_default_assets(): void {
		remove_action( 'wp_footer', 'wp_enqueue_stored_styles', 1 );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'classic-theme-styles-inline' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'global-styles-inline' );
		wp_dequeue_style( 'core-block' );
	}

	/**
	 * Registers custom images sizes.
	 */
	public static function register_image_sizes(): void {
		add_image_size( 'xs', 60 );
		add_image_size( 'xs@2x', 120 );
		add_image_size( 'xs@3x', 180 );

		add_image_size( 'sm', 240 );
		add_image_size( 'sm@2x', 480 );
		add_image_size( 'sm@3x', 720 );

		add_image_size( 'md', 420 );
		add_image_size( 'md@2x', 840 );
		add_image_size( 'md@3x', 1260 );

		add_image_size( 'lg', 680 );
		add_image_size( 'lg@2x', 1360 );
		add_image_size( 'lg@3x', 2040 );

		add_image_size( 'xl', 1024 );
		add_image_size( 'xl@2x', 2048 );
		add_image_size( 'xl@3x', 3072 );
	}

	/**
	 * Sets images compression quality.
	 *
	 * @return int The images compression quality.
	 */
	public static function image_compression_quality(): int {
		return 100;
	}

	/**
	 * Adds page slug to body classes.
	 *
	 * @param array $classes The body classes.
	 *
	 * @return array The modified body classes.
	 */
	public static function body_class( array $classes ): array {
		if ( is_single() || ( is_page() && ! is_front_page() ) ) {
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
	 * Adds support for preloading stylesheets.
	 *
	 * @param string $tag    The link tag for the enqueued style.
	 * @param string $handle The style's registered handle.
	 *
	 * @return string The updated link tag.
	 */
	public static function preload_stylesheets( string $tag, string $handle ): string {
		if ( str_contains( $handle, 'preload' ) ) {
			$tag = str_replace( "rel='stylesheet'", 'rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'"', $tag );
		}
		return $tag;
	}

	/**
	 * Enqueues frontend theme styles and scripts.
	 */
	public static function enqueue_assets(): void {
		// Theme styles.
		wp_enqueue_style( self::PREFIX . '-fonts-preload', self::get_base_url() . '/dist/styles/fonts.css', false, self::get_version( 'styles/fonts.css' ) );
		wp_enqueue_style( self::PREFIX, self::get_base_url() . '/dist/styles/main.css', array( self::PREFIX . '-fonts-preload' ), self::get_version( 'styles/main.css' ) );

		// Theme script.
		wp_enqueue_script( self::PREFIX, self::get_base_url() . '/dist/scripts/main.js', array(), self::get_version( 'scripts/main.js' ), true );

		// @phpcs:disable WordPress.WP.EnqueuedResourceParameters.NoExplicitVersion
		wp_enqueue_style( 'calendly', 'https://assets.calendly.com/assets/external/widget.css', false, false );
		wp_enqueue_script(
			'calendly',
			'https://assets.calendly.com/assets/external/widget.js',
			array(),
			false,
			array(
				'footer'   => false,
				'strategy' => 'async',
			)
		);
		// @phpcs:enable WordPress.WP.EnqueuedResourceParameters.NoExplicitVersion
	}

	/**
	 * Enqueues style for the login page.
	 */
	public static function login_enqueue_scripts(): void {
		wp_enqueue_style( self::PREFIX . '-login', self::get_base_url() . '/dist/styles/login.css', false, self::get_version( 'styles/login.css' ) );
	}

	/**
	 * Loads the theme translation domain.
	 *
	 * @hook plugins_loaded<Function>
	 */
	public static function load_text_domain(): void {
		load_plugin_textdomain( 'somoscuatro-theme', false, 'somoscuatro/languages/' );
	}
}
