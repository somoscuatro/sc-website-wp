<?php
/**
 * Translations management class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * Translations management class.
 */
class Translation {

	use Filesystem;

	/**
	 * Loads the theme translation domain.
	 */
	#[Action( 'after_setup_theme' )]
	public function load_text_domain(): void {
		load_theme_textdomain( 'somoscuatro-theme', $this->get_base_path() . '/languages' );
	}
}
