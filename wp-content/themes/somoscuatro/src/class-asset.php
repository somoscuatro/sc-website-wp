<?php
/**
 * Assets management class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;

use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * Assets management class.
 */
class Asset {

	use Filesystem;

	/**
	 * The Theme class.
	 *
	 * @var Theme
	 */
	protected $theme;

	/**
	 * Class constructor.
	 *
	 * @param Theme $theme The Theme class.
	 */
	public function __construct( Theme $theme ) {
		$this->theme = $theme;
	}

	/**
	 * Enqueues frontend theme styles and scripts.
	 */
	#[Action( 'wp_enqueue_scripts' )]
	public function enqueue_assets(): void {
		$theme_prefix = $this->theme->get_prefix();

		// Theme styles.
		wp_enqueue_style( $theme_prefix . '-fonts-preload', $this->get_base_url() . '/dist/styles/fonts.css', false, $this->get_filemtime( 'styles/fonts.css' ) );
		wp_enqueue_style( $theme_prefix, $this->get_base_url() . '/dist/styles/main.css', array( $theme_prefix . '-fonts-preload' ), $this->get_filemtime( 'styles/main.css' ) );

		// Theme script.
		wp_enqueue_script( $theme_prefix, $this->get_base_url() . '/dist/scripts/main.js', array(), $this->get_filemtime( 'scripts/main.js' ), true );

		// Legal pages assets.
		if ( is_page_template( 'legal.php' ) ) {
			wp_enqueue_style( $theme_prefix . '-legal', $this->get_base_url() . '/dist/styles/legal.css', array(), $this->get_filemtime( 'styles/legal.css' ) );
		}

		// Legal pages assets.
		if ( is_singular( 'glossary-term' ) ) {
			wp_enqueue_style( $theme_prefix . '-glossary', $this->get_base_url() . '/dist/styles/glossary.css', array(), $this->get_filemtime( 'styles/glossary.css' ) );
		}

		// Single post assets.
		if ( is_single() ) {
			wp_enqueue_style( $theme_prefix . '-single-post', $this->get_base_url() . '/dist/styles/single-post.css', array(), $this->get_filemtime( 'styles/single-post.css' ) );
		}

		// Glossary page assets.
		if ( is_page( get_theme_mod( 'glossary_page' ) ) ) {
			wp_enqueue_script( $theme_prefix . '-page-glossary', $this->get_base_url() . '/dist/scripts/page-glossary.js', array(), $this->get_filemtime( 'scripts/page-glossary.js' ), true );

			$glossary_terms = Glossary::get_terms();
			wp_localize_script(
				$theme_prefix . '-page-glossary',
				'glossary',
				array(
					'terms'   => $glossary_terms,
					'letters' => Glossary::get_letters( $glossary_terms ),
				)
			);
		}

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
	 * Enqueues editor theme styles and scripts.
	 */
	#[Action( 'admin_enqueue_scripts' )]
	public function enqueue_admin_assets() {
	}

	/**
	 * Enqueues wp-login theme styles and scripts.
	 */
	#[Action( 'login_enqueue_scripts' )]
	public function enqueue_login_assets() {
		wp_enqueue_style( $this->theme->get_prefix() . '-login', $this->get_base_url() . '/dist/styles/login.css', false, $this->get_filemtime( 'styles/login.css' ) );
	}
}
